<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\httppanel;

use yii\debug\Panel;
use yii\helpers\ArrayHelper;
use yii\log\Logger;
use yii\helpers\Html;

/**
 * Debugger panel that collects and displays httppanel queries performed.
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @since 2.0
 */
class DebugPanel extends Panel
{
    public $db = 'httpinterface';


    public function init()
    {
        $this->actions['httpinterface-query'] = [
            'class' => 'common\\components\\httppanel\\DebugAction',
            'panel' => $this,
            'db' => $this->db,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'httpinterface';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        $timings = $this->calculateTimings();
        $queryCount = count($timings);
        $queryTime = 0;
        foreach ($timings as $timing) {
            $queryTime += $timing[3];
        }
        $queryTime = number_format($queryTime * 1000) . ' ms';
        $url = $this->getUrl();
        $output = <<<EOD
<div class="yii-debug-toolbar-block">
    <a href="$url" title="Executed $queryCount microService queries which took $queryTime.">
        MicS <span class="label">$queryCount</span> <span class="label">$queryTime</span>
    </a>
</div>
EOD;

        return $queryCount > 0 ? $output : '';
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function getDetail()
    {
        $timings = $this->calculateTimings();
        ArrayHelper::multisort($timings, 3, SORT_DESC);
        $rows = [];
        $i = 0;
        foreach ($timings as $logId => $timing) {
            $duration = sprintf('%.1f ms', $timing[3] * 1000);
            $message = $timing[1];
            $traces = $timing[4];
            if (($pos = mb_strpos($message, "#")) !== false) {
                $url = mb_substr($message, 0, $pos);
                $body = mb_substr($message, $pos + 1);
            } else {
                $url = $message;
                $body = null;
            }
            $traceString = '';
            if (!empty($traces)) {
                $traceString .= Html::ul($traces, [
                    'class' => 'trace',
                    'item' => function ($trace) {
                        return "<li>{$trace['file']}({$trace['line']})</li>";
                    },
                ]);
            }

            $rows[] = <<<HTML
<tr>
    <td style="width: 10%;">$duration</td>
    <td style="width: 75%;"><div><b>$url</b><br/><p>$body</p>$traceString</div></td>
</tr>
<tr style="display: none;"><td id="elastic-time-$i"></td><td colspan="3" id="elastic-result-$i"></td></tr>
HTML;
            $i++;
        }
        $rows = implode("\n", $rows);

        return <<<HTML
<h1>httppanel Queries</h1>

<table class="table table-condensed table-bordered table-striped table-hover" style="table-layout: fixed;">
<thead>
<tr>
    <th style="width: 10%;">Time</th>
    <th style="width: 75%;">Url / Query</th>
</tr>
</thead>
<tbody>
$rows
</tbody>
</table>
HTML;
    }

    private $_timings;

    public function calculateTimings()
    {
        if ($this->_timings !== null) {
            return $this->_timings;
        }
        $messages = $this->data['messages'];
        $timings = [];
        $stack = [];
        foreach ($messages as $i => $log) {
            list($token, $level, $category, $timestamp) = $log;
            $log[5] = $i;
            if ($level == Logger::LEVEL_PROFILE_BEGIN) {
                $stack[] = $log;
            } elseif ($level == Logger::LEVEL_PROFILE_END) {
                if (($last = array_pop($stack)) !== null && $last[0] === $token) {
                    $timings[$last[5]] = [count($stack), $token, $last[3], $timestamp - $last[3], $last[4]];
                }
            }
        }

        $now = microtime(true);
        while (($last = array_pop($stack)) !== null) {
            $delta = $now - $last[3];
            $timings[$last[5]] = [count($stack), $last[0], $last[2], $delta, $last[4]];
        }
        ksort($timings);

        return $this->_timings = $timings;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $target = $this->module->logTarget;
        $messages = $target->filterMessages($target->messages, Logger::LEVEL_PROFILE, ['Httpful\Request::send']);

        return ['messages' => $messages];
    }
}

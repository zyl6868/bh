<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-21
 * Time: 下午5:35
 */

namespace backend\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class sbNav extends Nav
{

    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($items !== null) {
//            $linkOptions['data-toggle'] = 'dropdown';
//            Html::addCssClass($options, 'dropdown');
//            Html::addCssClass($linkOptions, 'dropdown-toggle');
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    protected function renderDropdown($items, $parentItem)
    {

        return sbNav::widget([

            'dropDownCaret' => Html::tag('span', '', ['class' => 'fa arrow']),

            'encodeLabels' => false,
            'options' => ['class' => "nav nav-second-level"],
            'items' => $items,
        ]);

    }


}
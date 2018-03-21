<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 16/3/3
 * Time: 下午6:17
 */

namespace common\components;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class GridView extends   \yii\grid\GridView
{


    public function run()
    {

        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::tag($tag, $content, $options);
    }
}
<?php

namespace frontend\modules\mobiles;


class MobilesModule extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\mobiles\controllers';

    public function init()
    {
        parent::init();

        $this->layout='lay_mobile';
        // custom initialization code goes here
    }
}
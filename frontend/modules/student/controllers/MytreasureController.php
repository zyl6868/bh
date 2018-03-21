<?php
namespace frontend\modules\student\controllers;

use frontend\components\StudentBaseController;
use frontend\controllers\mytreasure\MyTreasureAction;
use frontend\controllers\mytreasure\TreasureDetailsAction;
use frontend\controllers\mytreasure\TreasureExchangeAction;

class MytreasureController extends StudentBaseController
{
    public $layout = 'lay_user_new';

    public function actions()
    {
        return[
            'my-treasure'=>['class'=>MyTreasureAction::class],
            'treasure-details'=>['class'=>TreasureDetailsAction::class],
        ];
    }

    /**
     * 学米规则
     * @return string
     */
    public function actionRules(){
        $this->layout = '@app/views/layouts/main_v2';
        return $this->render('@app/views/publicView/mytreasure/studentTreasureRules');
    }
}
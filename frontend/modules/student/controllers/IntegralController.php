<?php
namespace frontend\modules\student\controllers;

use frontend\components\StudentBaseController;
use frontend\controllers\newintegral\IncomeDetailsAction;
use frontend\controllers\newintegral\MyRankingAction;


/**
 * Created by zyl.
 * User: Administrator
 * Date: 2017/04/20
 * Time: 15:14
 */
class IntegralController extends StudentBaseController
{
    public $layout = 'lay_user_new';

    public function actions()
    {
        return [
            'income-details' => ['class' => IncomeDetailsAction::class],
            'my-ranking' => ['class' => MyRankingAction::class],
        ];
    }

    /**
     * 积分规则
     * @return string
     */
    public function actionRules()
    {
        $this->layout = '@app/views/layouts/main_v2';
        return $this->render('@app/views/publicView/newintegral/jfRule');
    }
}

?>
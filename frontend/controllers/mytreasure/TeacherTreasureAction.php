<?php
declare(strict_types = 1);
namespace frontend\controllers\mytreasure;

use common\clients\XuemiMicroService;
use yii\base\Action;

class TeacherTreasureAction extends Action
{
    public function run()
    {
        $user = loginUser();
        $userId = (int)$user->userID;
        $xuemiHelperModel = new XuemiMicroService();

        //老师月学米
        $month = date('Y-m', time());
        $myAccount = $xuemiHelperModel->getTeacherMonthXuemi($userId, (string)$month);

        //今日学米
        $todayAccount = $xuemiHelperModel->getTodayXuemi($userId);
        //结转学米
        $convertXuemiModel = $xuemiHelperModel->convertXuemiCount((int)$user->userID);

        $convertXuemiCount = isset($convertXuemiModel->incomeTotal) ? $convertXuemiModel->incomeTotal-$convertXuemiModel->costTotal : 0;


        return $this->controller->render('@app/views/publicView/mytreasure/teacherTreasure', ['user' => $user, 'myAccount' => $myAccount, 'todayAccount' => $todayAccount,'convertXuemiCount'=>$convertXuemiCount]);
    }
}
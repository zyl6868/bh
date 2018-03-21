<?php
declare(strict_types = 1);
namespace frontend\controllers\mytreasure;

use common\clients\XuemiMicroService;
use common\clients\XuemiShopService;
use yii\base\Action;
use yii\web\HttpException;

class TreasureExchangeAction extends Action
{
    public function run()
    {
        $user = loginUser();
        $userId = (int)$user->userID;
        $xuemiHelperModel = new XuemiMicroService();
        $accountType = (int)app()->request->get('accountType',0);
        $goods = $xuemiHelperModel->Goods($user->type,$accountType);

        $monthAccountId = 0;
        $month = 0;
        $total = 0;
        if ($user->type == 1) {

            if($accountType == 1){
                //结转学米
                $convertXuemiModel = $xuemiHelperModel->convertXuemiCount((int)$user->userID);
                if (!empty($convertXuemiModel)) {
                    $total = isset($convertXuemiModel->incomeTotal) ? $convertXuemiModel->incomeTotal-$convertXuemiModel->costTotal : 0;
                    $monthAccountId = isset($convertXuemiModel->monthAccountId) ? $convertXuemiModel->monthAccountId : 0;
                }

            }else{
                //老师几月学米
                $year = app()->request->get('year');
                $month = app()->request->get('month');

                if (empty($year) || empty($month)) {
                    throw new HttpException(404, 'The requested page does not exist.');
                }

                $yearMonth = $year . '-' . $month;
                $nowMonthAccountModel = $xuemiHelperModel->getMonthAccount($userId, (string)$yearMonth);
                if (!empty($nowMonthAccountModel)) {
                    $total = isset($nowMonthAccountModel->incomeTotal) ? $nowMonthAccountModel->incomeTotal-$nowMonthAccountModel->costTotal : 0;
                    $monthAccountId = isset($nowMonthAccountModel->monthAccountId) ? $nowMonthAccountModel->monthAccountId : 0;
                }
            }

            //获取老师当月学米
            $nowMonth = date('Y-m', time());
            $myAccount = $xuemiHelperModel->getTeacherMonthXuemi($userId, (string)$nowMonth);

        } else {
            //学生可用学米
            $myAccount = $xuemiHelperModel->getStudentUsableXuemi($userId);
        }

        //今日学米
        $todayAccount = $xuemiHelperModel->getTodayXuemi($userId);

        return $this->controller->render('@app/views/publicView/mytreasure/treasureExchange', [
            'accountType'=>$accountType,
            'user' => $user,
            'total' => $total,
            'myAccount' => $myAccount,
            'month' => $month,
            'monthAccountId' => $monthAccountId,
            'todayAccount' => $todayAccount,
            'goods' => $goods
        ]);
    }
}
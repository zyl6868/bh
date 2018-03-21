<?php
declare(strict_types = 1);
namespace frontend\controllers\mytreasure;

use common\clients\XuemiMicroService;
use yii\base\Action;
use yii\data\Pagination;

class TreasureDetailsAction extends Action
{
    public function run()
    {

        $user = loginUser();
        $userId = (int)$user->userID;
        $xuemiHelperModel = new XuemiMicroService();
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $xuemiModel = $xuemiHelperModel->getXuemiDetails($userId, (int)$pages->getPage() + 1, (int)$pages->pageSize);
        $xuemiResult = $xuemiModel->body;
        $pages->totalCount = $xuemiModel->headers['x-pagination-total-count'];

//        if ($user->type == 1) {
//            //老师月学米
//            $month = date('Y-m', time());
//            $myAccount = $xuemiHelperModel->getStudentUsableXuemi($userId);
//        } else {
//            //学生可用学米
            $myAccount = $xuemiHelperModel->getStudentUsableXuemi($userId);
//        }

        //今日学米
        $todayAccount = $xuemiHelperModel->getTodayXuemi($userId);


        if (app()->request->isAjax) {

            return $this->controller->renderPartial('@app/views/publicView/mytreasure/_treasure_details', ['user' => $user, 'model' => $xuemiResult, 'pages' => $pages]);
        }

        return $this->controller->render('@app/views/publicView/mytreasure/treasureDetails', ['user' => $user, 'myAccount' => $myAccount, 'todayAccount' => $todayAccount, 'model' => $xuemiResult, 'pages' => $pages]);
    }
}
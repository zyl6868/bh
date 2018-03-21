<?php
declare(strict_types = 1);
namespace frontend\controllers\mytreasure;

use common\clients\XuemiMicroService;
use yii\base\Action;
use yii\data\Pagination;

class MyTreasureAction extends Action
{
    public function run()
    {
        $user = loginUser();
        $userId = (int)$user->userID;
        $xuemiHelperModel = new XuemiMicroService();


        //学生可用学米
        $myAccount = $xuemiHelperModel->getStudentUsableXuemi($userId);

        //今日学米
        $todayAccount = $xuemiHelperModel->getTodayXuemi($userId);

        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 50;
        $rankType = app()->request->get('rankVal', 1);
        if ($rankType == 3) {
            $pages->pageSize = 150;
        }
        $xuemiRankingResult = $xuemiHelperModel->getXuemiRanking($userId, (int)$rankType, (int)$pages->getPage() + 1, (int)$pages->pageSize);


        if (app()->request->isAjax) {

            return $this->controller->renderPartial('@app/views/publicView/mytreasure/_treasure_list', ['user' => $user, 'xuemiRankingResult' => $xuemiRankingResult]);
        }
        return $this->controller->render('@app/views/publicView/mytreasure/myTreasure', ['user' => $user, 'xuemiRankingResult' => $xuemiRankingResult, 'myAccount' => $myAccount, 'todayAccount' => $todayAccount]);
    }
}
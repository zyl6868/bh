<?php

namespace frontend\controllers\newintegral;
use common\clients\JfManageService;
use yii\base\Action;
use yii\data\Pagination;
use yii\web\HttpException;

class IncomeDetailsAction extends Action {
    /**
     * @return string
     * @throws HttpException
     */
    public function run(){
        //累计积分
        $userid = user()->id;
        $user= loginUser();

        if(!$user){
            throw new HttpException(404, 'The requested page does not exist.');
        }
        $jfManageHelperModel=new JfManageService();
        //总积分
        $userScore=$jfManageHelperModel->UserScore($userid);
        $totalPoints=$userScore->totalPoints;

        //今日积分，积分等级
        $todayPoints = $jfManageHelperModel->UserDayScore($userid);
        $gradePoints = $jfManageHelperModel->JfGrade($userid);

        // 积分明细
        $pages = new Pagination();
        $pages->validatePage=false;
        $pages->pageSize = 20;
        $restResult=$jfManageHelperModel->Points($userid,$pages->getPage() + 1,$pages->pageSize);
        $model=$restResult->body->items;
        $pages->totalCount=$restResult->headers['x-pagination-total-count'];
        if (app()->request->isAjax) {
            return $this->controller->renderPartial("@app/views/publicView/newintegral/_income_list", [
                 'pages'=>$pages,
                 'totalPonits'=>$totalPoints,
                 'model'=>$model
                ]);
        }
        return $this->controller->render("@app/views/publicView/newintegral/incomeDetails", [
             'pages'=>$pages,
             'totalPoints'=>$totalPoints,
             'model'=>$model,
             'user'=>$user,
             'todayPoints'=>$todayPoints,
             'gradePoints'=>$gradePoints
            ]);
    }
}
?>
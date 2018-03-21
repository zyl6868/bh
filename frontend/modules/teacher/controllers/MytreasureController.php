<?php
namespace frontend\modules\teacher\controllers;

use common\models\JsonMessage;
use common\clients\XuemiMicroService;
use frontend\components\TeacherBaseController;
use frontend\controllers\mytreasure\TeacherTreasureAction;
use frontend\controllers\mytreasure\TreasureDetailsAction;
use frontend\controllers\mytreasure\TreasureExchangeAction;

class MytreasureController extends TeacherBaseController
{
    public $layout = 'lay_user_new';

    public function actions()
    {
        return[
//            'teacher-treasure'=>['class'=>TeacherTreasureAction::class],
            'treasure-details'=>['class'=>TreasureDetailsAction::class],
            'treasure-exchange'=>['class'=>TreasureExchangeAction::class]
        ];
    }

    /**
     * 学米规则
     * @return string
     */
    public function actionRules(){
        $this->layout = '@app/views/layouts/main_v2';
        return $this->render('@app/views/publicView/mytreasure/teacherTreasureRules');
    }

    /**
     * 老师月度学米时间轴
     * @return string
     */
    public function actionGetMonthList(){
        $user = loginUser();
        $xuemiHelperModel=new XuemiMicroService();
        $pages = app()->request->get('page');
        $perPage = 3;
        $monthXuemiModel = $xuemiHelperModel->getMonthXuemiList((int)$user->userID,(int)$pages,(int)$perPage);

        $monthXuemiList = $monthXuemiModel->body;
        $pageCount = $monthXuemiModel->headers['x-pagination-total-count'];
        $data = [];
        $data['list'] = $monthXuemiList;
        $data['pageCount'] = $pageCount;
        return $this->renderJSON($data);

    }

    /**
     * 结转学米
     * @return array|mixed
     */
    public function actionConvertXuemi(){

        $jsonResult = new JsonMessage();
        $monthAccountId = (int)app()->request->post('monthAccountId');
        $userId = (int)user()->id;
        $xuemiHelperModel=new XuemiMicroService();

        $result = $xuemiHelperModel->convertXuemi($userId,$monthAccountId);
        if($result){
            $jsonResult->success = true;
            $jsonResult->message = '结转成功';
        }else{
            $jsonResult->success = false;
            $jsonResult->message = '学米不足';
        }
        return $this->renderJSON($jsonResult);
    }
}
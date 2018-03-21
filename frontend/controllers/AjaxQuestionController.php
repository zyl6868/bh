<?php
namespace frontend\controllers;
use common\components\WebDataCache;
use common\helper\DateTimeHelper;
use common\models\JsonMessage;
use common\models\pos\SeQuestionFavoriteFolderNew;
use common\models\pos\SeQuestionGroup;
use common\models\sanhai\ShQuestionError;
use common\models\sanhai\ShTestquestion;
use common\clients\JfManageService;
use frontend\components\TeacherBaseController;

/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/22
 * Time: 14:55
 */
class AjaxQuestionController extends TeacherBaseController{

    /**
     *添加收藏
     * @throws \yii\base\ExitException
     */
    public function actionCollect(){
        $jsonResult = new JsonMessage();

        $department = app()->request->getBodyParam('department');
        $subjectId = app()->request->getBodyParam('subjectId');
        $groupType = 0; //分组类型：0我的收藏1自定义分组

        $groupDefault = SeQuestionGroup::find()->where(['userId'=>user()->id, 'subjectId'=>$subjectId, 'departmentId'=>$department, 'groupType'=>$groupType])->one();
        //添加“我的收藏”默认分组
        if ( empty($groupDefault) ) {
            $qusGroupModel = new SeQuestionGroup();
            $qusGroupModel->userId = user()->id;
            $qusGroupModel->subjectId = $subjectId;
            $qusGroupModel->departmentId = $department;
            $qusGroupModel->groupName = '我的收藏';
            $qusGroupModel->groupType = $groupType;
            $qusGroupModel->createTime = DateTimeHelper::timestampX1000();
            if ( $qusGroupModel->save(false) ) {
                $groupId = $qusGroupModel->attributes['groupId'];
            }
        } else {
            $groupId = $groupDefault->groupId;
        }
        //关联到题目收藏夹分组
        $qusFavModel = new SeQuestionFavoriteFolderNew();
        $questionID=app()->request->getBodyParam('questionID');
        $collect = SeQuestionFavoriteFolderNew::find()->where(['userId'=>user()->id, 'questionId'=>$questionID])->one();
        $collectCount = SeQuestionFavoriteFolderNew::find()->where(['userId'=>user()->id, 'isDelete'=>0])->count();

        if ( $collect ) {
            $collect->isDelete = '0';
            /** @var integer $groupId */
            $collect->groupId = $groupId;
            if( $collect->save(false) ){
                $jsonResult->success = true;
            }
        } else {
            $qusFavModel->createTime = DateTimeHelper::timestampX1000();
            $qusFavModel->questionId = $questionID;
            /** @var integer $groupId */
            $qusFavModel->groupId = $groupId;
            $qusFavModel->userId = user()->id;
            if ($collectCount < 1000){
                $qusFavModel->save(false);
                $jsonResult->success = true;
            }else{
                $jsonResult->success = false;
                $jsonResult->message = '收藏题目限制1000个';

            }
        }
        return $this->renderJSON($jsonResult);

    }

    /**
     * @return string
     * @throws \yii\base\ExitException
     * 加载整个页面判断每道题是否被收藏了
     */
    public function actionIfCollected(){
        $jsonResult=new JsonMessage();
        $questionIDArray=app()->request->getBodyParam('questionIDArray');
        $isCollectedArray=[];
        $isCollected= SeQuestionFavoriteFolderNew::find()->where(['userId'=>user()->id,'questionId'=>$questionIDArray,'isDelete'=>0])->select('questionId')->asArray()->all();
        foreach($isCollected as $v){
            $isCollectedArray[] = $v['questionId'];
        }
        $jsonResult->data=$isCollectedArray;
        return $this->renderJSON($jsonResult);
    }

    /**
     * @return string
     * @throws \yii\base\ExitException
     * 取消收藏
     */
    public function actionCancelCollect(){
        $jsonResult=new JsonMessage();
        $questionID=app()->request->getBodyParam('questionID');
        /** @var SeQuestionFavoriteFolderNew $qusFavModel */
        $qusFavModel= SeQuestionFavoriteFolderNew::find()->where(['questionId'=>$questionID,'userId'=>user()->id])->one();
        $qusFavModel->isDelete=1;
        if($qusFavModel->save()){
            $jsonResult->success=true;
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * //题目纠错
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionQuestionError()
    {
        $jsonResult = new JsonMessage();
        $questionId = app()->request->post('questionId', '');
        $errorBrief=app()->request->getBodyParam('errorBrief');
        $question = ShTestquestion::find()->where(['id' => $questionId])->one();

        if ($question && !empty($_POST)) {

                $errorType = app()->request->post('errorType', '');
                $questionErrorModel = new ShQuestionError();
                $questionErrorModel->questionId = $questionId;
                $questionErrorModel->errorType = $errorType;
                $questionErrorModel->userName = WebDataCache::getTrueNameByuserId(user()->id);
                $questionErrorModel->brief = $errorBrief;
                $questionErrorModel->userId = user()->id;
                $questionErrorModel->createTime = times();
                if ($questionErrorModel->save()) {
                    //                    题目纠错增加积分
                    $jfHelper = new JfManageService;
                    $jfHelper->addJfXuemi('pos-error', user()->id);
                    $jsonResult->success = true;
                }

            return $this->renderJSON($jsonResult);
        } else {
            $jsonResult->message = '非法操作！';
            return $this->renderJSON($jsonResult);
        }
    }

    /**
     * 获取题目纠错弹窗
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetErrorBox(){
        return $this->renderPartial('error_box');
    }


}
?>
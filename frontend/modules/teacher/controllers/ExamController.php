<?php
namespace frontend\modules\teacher\controllers;
use frontend\components\TeacherBaseController;
use frontend\services\pos\pos_ExamService;
use frontend\services\pos\pos_PaperManageService;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-10-15
 * Time: 下午1:15
 */
class ExamController extends TeacherBaseController
{
    public $layout = 'lay_user';


    /**
     *上传类型的试卷预览
     * @throws \yii\base\InvalidParamException
     */
    public function actionPaperPreview()
    {
        $paperID = app()->request->getParam('paperID');
        $paperService = new pos_PaperManageService();
        $paperResult = $paperService->queryPaperById($paperID, "", "");
        $getType = $paperResult->getType;
        if ($getType == 1) {
            return   $this->NewDigitalPreview();

        }
        $server = new pos_ExamService();
        $result = $server->queryPaperByIDOrgType("", $paperID);

        return $this->render('paperPreview', array('result' => $result));
    }


    /**
     *新的电子试卷预览
     * @throws \yii\base\InvalidParamException
     */
    public function NewDigitalPreview(){
        $this->layout= 'lay_prepare';
        $paperID = app()->request->getParam('paperID');
        $server=new pos_PaperManageService();
        $result=$server->queryMakerPaperById($paperID);
        return $this->render('newDigitalPreview', array('result' => $result));
    }


}
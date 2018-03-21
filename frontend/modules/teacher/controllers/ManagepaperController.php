<?php
namespace frontend\modules\teacher\controllers;
use common\models\JsonMessage;
use common\models\pos\SePaper;
use common\models\pos\SeSchoolInfo;
use frontend\components\TeacherBaseController;
use common\components\WebDataCache;
use schoolmanage\components\helper\GradeHelper;
use yii\helpers\ArrayHelper;
use frontend\models\PaperForm;
use frontend\services\BaseService;
use frontend\services\pos\pos_PaperManageService;
use common\models\pos\SeUserinfo;
use yii\data\Pagination;

/**
 * Created by yangjie
 * User: Administrator
 * Date: 14-10-16
 * Time: 下午16:27
 */
class ManagepaperController extends TeacherBaseController
{

    public $layout = 'lay_user';

    /**
     * 设置试卷结构
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $this->layout= 'lay_user_new';
        $proFirstime = microtime(true);
        $user =loginUser();
		$userId = user()->id;

        $department = app()->request->get('department', $user->department);
        $subjectId = app()->request->getParam('subjectId', $user->subjectID);
        $getType =app()->request->getParam('getType', null);

        //分页
        $pages = new Pagination();
        $pages->validatePage=false;
        $pages->pageSize = 10;

        //根据学部和学制获取相对的年级id列表
        $schoolInfoModel = new SeSchoolInfo();
        $schoolData = $schoolInfoModel::getOneCache($user->schoolID);
        $lengthOfSchooling = $schoolData->lengthOfSchooling;

        $gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($department,$lengthOfSchooling,1);
        $gradeDataList =  ArrayHelper::map($gradeModel, 'gradeId', 'gradeName');
        $gradeList = array_keys($gradeDataList);

        //查询试卷列表
        $paperModel = SePaper::getPaperModel($userId,$subjectId,$gradeList,$getType);
		$pages->totalCount = $paperModel->count();
        $paperList = $paperModel->orderBy('uploadTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
        \Yii::info('教师试卷管理 '.(microtime(true)-$proFirstime),'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('_test_paper_list', array(
                'data' => $paperList,
                'pages' => $pages
            ));
		}

		return $this->render('teacherTestPaper',array(
            'data' => $paperList,
            'department' => $department,
            'pages' => $pages,
            'subjectId'=>$subjectId
        ));
    }


    /**
     *  上传试卷
     * @throws \Camcima\Exception\InvalidParameterException
     * @throws \yii\base\InvalidParamException
     */
    public function  actionUploadPaper()
    {
        $this->layout= 'lay_user_new';
        $model = new PaperForm();
        $model->provience = loginUser()->getModel()->provience;
        $model->city = loginUser()->getModel()->city;
        $model->county = loginUser()->getModel()->country;
		$model->gradeID = loginUser()->getModel()->getUserInfoInClass()[0]['gradeID'];
		$model->subjectID = loginUser()->getModel()->subjectID;
		$model->versionID = loginUser()->getModel()->textbookVersion;
        $tmp=[];
        if (isset($_POST['PaperForm'])) {
            $model->attributes = $_POST['PaperForm'];
            //处理图片
            $arr = $_POST['picurls'];
            foreach ($arr as $k => $v) {
                $tmp['images'][]['url'] = $v;
            }
            $model->paperRoute = json_encode($tmp);
            $paperServer = new pos_PaperManageService();
            $result = $paperServer->uploadPaper($model->paperName, $model->provience, $model->city, $model->county, $model->gradeID, $model->subjectID, $model->versionID, $model->knowledgePoint, $model->summary, user()->id, $model->paperRoute, 0, 0);
            if ($result->resCode == BaseService::successCode) {
                return $this->redirect(url('teacher/managepaper'));
            }
        }
        return $this->render('uploadPaper', array('model' => $model));
    }


    /**
     *  删除试卷
     * @throws \Camcima\Exception\InvalidParameterException
     * @throws \yii\base\ExitException
     */
    public function actionDeletePaper()
    {
        $paperId = app()->request->getParam('paperId');

        $paperServer = new pos_PaperManageService();
        $result = $paperServer->deletePaper($paperId);

        $jsonResult = new JsonMessage();
        if ($result->resCode == BaseService::successCode) {
            $jsonResult->success = true;
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '删除失败';
        }
        return $this->renderJSON($jsonResult);
    }




}
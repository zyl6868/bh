<?php
declare(strict_types=1);
namespace schoolmanage\modules\organization\controllers;

use common\clients\OrganizationService;
use common\models\JsonMessage;
use common\models\pos\SeClass;
use schoolmanage\components\helper\GradeHelper;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class DefaultController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_organization_index';
    public $enableCsrfValidation = false;

    /**
     * 小学学部
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $schoolID = $this->schoolId;

        $gradeId = (string)app()->request->get('gradeId', '');
        $classId = (string)app()->request->get('classId', '');
        $status = (int)app()->request->get('status', 1);

        $schoolData = $this->schoolModel;

        $departmentIds = empty($schoolData->department) ? null : $schoolData->department; //学部id
        $lengthOfSchooling = (string)empty($schoolData->lengthOfSchooling) ? '' : $schoolData->lengthOfSchooling; //学制

        //默认为第一个学部
        $defaultDepartmentId = substr($departmentIds, 0, 5);

        $departmentId = (string)app()->request->get('departmentId', $defaultDepartmentId);
        //查询默认学部的年级列表
        $gradeData = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($departmentId,$lengthOfSchooling);
        $gradeDataList = ArrayHelper::map($gradeData, 'gradeId', 'gradeName');

        //查询班级列表数据
        $classListData = SeClass::getClassInfoList($schoolID, $gradeId, $classId,$departmentId,$status);

        $classCount = count($classListData);

        if(app()->request->isAjax){
            return $this->renderPartial('_class_list',[
                'departmentIds'=>$departmentIds,
                'schoolId' => $schoolID,
                'departmentId'=>$departmentId,
                'classCount'=>$classCount,
                'classListData'=>$classListData
            ]);
        }

        return $this->render('index',[
            'departmentIds'=>$departmentIds,
            'gradeDataList'=>$gradeDataList,
            'schoolId' => $schoolID,
            'departmentId'=>$departmentId,
            'classCount'=>$classCount,
            'classListData'=>$classListData
        ]);
    }


    /**
     * 保存创建班级
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionCreateClass(){
        $schoolID = $this->schoolId;
        $departmentId = (int)app()->request->get('departmentId');
        $gradeId = (int)app()->request->get('gradeId');
        $classNumber = (int)app()->request->get('classNumber');
        $joinYear = (int)app()->request->get('joinYear');
        $creatorID = user()->id;

        $organizationModel = new OrganizationService();
        $result = $organizationModel->CreateClass($creatorID,$classNumber,$departmentId,$gradeId,$joinYear,$schoolID);

        return $this->renderJSON($result);
    }


    /**
     * ajax获取学部和入学年份
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetDepartmentYear(){
        $departmentId = (string)app()->request->get('departmentId');
        $jsonResult = new JsonMessage();
        //加入时间
        $years = getClassYears();
        $joinYear = [];
        foreach($years as $k=>$v){
            $joinYear[] = $v;
        }

        //学部
        $schoolData = $this->schoolModel;
        $departmentIds = $schoolData->department; //学部id
        $departmentIds = explode(',',$departmentIds);


        $departmentArr = [];
        foreach($departmentIds as $k=>$v){
            $departmentArr[$k]['id'] = $v;
        }

        //年级
        $gradeArr = $this->actionGetGrade($departmentId);

        $jsonResult->success = true;
        $jsonResult->joinYear = $joinYear;
        $jsonResult->departmentArr = $departmentArr;
        $jsonResult->gradeArr = $gradeArr;


        return $this->renderJSON($jsonResult);

    }

    /**
     * ajax点击封班获取年级和班级
     * @throws \yii\base\ExitException
     */
    public function actionCloseClass(){

        $jsonResult = new JsonMessage();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $departmentId = (string)app()->request->post('departmentId');

        $gradeArr = $this->actionGetGrade($departmentId);

        $classListArr = $this->getClassListArr('', $departmentId);

        $jsonResult->classListArr = $classListArr;
        $jsonResult->gradeArr = $gradeArr;

        return $this->renderJSON($jsonResult);
    }

    /**
     * 完成封班
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     */
    public function actionFinishCloseClass(){

        $schoolId = (int)app()->request->post('schoolId');
        $classIds = app()->request->post('classIds');
        $this->isClassInSchool($classIds);
        $classIds = implode(',',$classIds);
        $organizationModel=new OrganizationService();
        $result = $organizationModel->CloseClass($classIds, $schoolId);

        \Yii::info('班级封班操作, 操作人Id：'.Yii::$app->user->id . '; schoolId:'.$schoolId.'; classIds:'.$classIds.', 方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($result);

    }

    /**
     * 升级
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionUpgrade(){
        $schoolId = $this->schoolId;
        $departmentId = (int)app()->request->post('departmentId');
        $organizationModel = new OrganizationService();
        $result = $organizationModel->SchoolUpgrade($departmentId, $schoolId);

        \Yii::info('学部升级操作, 操作人Id：'.Yii::$app->user->id . '; schoolId:'.$schoolId.'; departmentId:'.$departmentId.', 方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($result);
    }

    /**
     * 封班:更换年级
     * @throws \yii\base\ExitException
     */
    public function actionGetClass(){
        $jsonResult = new JsonMessage();
        $gradeId = (string)app()->request->get('gradeId');
        $departmentId = (string)app()->request->get('departmentId');

        $classListArr = $this->getClassListArr($gradeId, $departmentId);

        $jsonResult->classListArr = $classListArr;

        return $this->renderJSON($jsonResult);
    }

    /**
     * 获取班级数据
     * @param string $gradeId 年级
     * @param string $departmentId 学部
     * @return array
     * @throws \yii\base\ExitException
     */
    public function getClassListArr(string $gradeId, string $departmentId){
        $schoolID = $this->schoolId;
        $classList = SeClass::getClassList($schoolID, $gradeId, $departmentId);
        $classListArr=[];
        foreach($classList as $k=>$v){
            $classListArr[] = ['className'=>$v['className'],'classID'=>$v['classID']];
        }
        return $this->renderJSON($classListArr);
    }


    /**
     * 创建班级:根据学部获取年级
     * @param string $departmentId 學部
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetGrade(string $departmentId){

        $schoolData = $this->schoolModel;
        $lengthOfSchooling = $schoolData->lengthOfSchooling; //学制
        //查询默认学部的年级列表
        $gradeData = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($departmentId,$lengthOfSchooling);
        $gradeDataList = ArrayHelper::map($gradeData, 'gradeId', 'gradeName');
        return $this->renderJSON($gradeDataList);
    }
}

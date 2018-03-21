<?php
namespace frontend\modules\teacher\controllers;

use common\clients\OrganizationService;
use common\models\JsonMessage;
use common\models\pos\SeSchoolInfo;
use common\clients\SearchSchoolMicroService;
use frontend\components\BaseController;
use frontend\components\helper\AreaHelper;
use schoolmanage\components\helper\GradeHelper;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-30
 * Time: 下午6:29
 */
class SearchschoolController extends BaseController
{

    public $layout = '@app/views/layouts/lay_join_class.php';

    /**
     * 根据地区搜索学校
     * @return string
     */
    public function actionIndex()
    {
        $this->actionAuthJudge();

        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;

        $county = app()->request->get('country', '');

        $schoolModel = new SearchSchoolMicroService();

        $schoolInfos = $schoolModel->getSchoolByCounty($county);

        $pages->totalCount = count($schoolInfos);

        if (app()->request->isAjax) {

            return $this->renderPartial('_school_list', ['schoolInfos' => $schoolInfos, 'pages' => $pages]);
        }

        return $this->render('index', ['schoolInfos' => $schoolInfos, 'pages' => $pages]);
    }

    /**
     * 根据学校名称搜索
     * @return string
     */
    public function actionFindSchoolByName()
    {
        $this->actionAuthJudge();
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;

        $schoolName = (string)app()->request->get('schoolName', '');
        $schoolModel = new SearchSchoolMicroService();
        $schoolInfos = $schoolModel->getSchoolByName(urlencode($schoolName));

        return $this->render('schoolList', ['schoolName' => $schoolName, 'schoolInfos' => $schoolInfos, 'pages' => $pages]);

    }

    /**
     * 学校班级列表
     * @return string
     */
    public function actionClassList()
    {
        $this->actionAuthJudge();
        $schoolId = app()->request->get('schoolId');

        $schoolInfo = SeSchoolInfo::getOneCache($schoolId);
        if (empty($schoolInfo)) {
            return $this->notFound('学校不存在！');
        }

        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;

        $departmentIds = $schoolInfo->department;
        //默认为第一个学部
        $defaultDepartmentId = substr($departmentIds, 0, 5);

        $departmentId = (int)app()->request->get('departmentId', $defaultDepartmentId);

        $schoolModel = new SearchSchoolMicroService();

        $classList = $schoolModel->getClassListBySchool($departmentId, $schoolId);


        if (app()->request->isAjax) {

            return $this->renderPartial('_class_list', ['classList' => $classList, 'pages' => $pages]);
        }

        return $this->render('classList', ['schoolInfo' => $schoolInfo, 'departmentIds' => $departmentIds, 'departmentId' => $departmentId, 'classList' => $classList, 'pages' => $pages]);

    }

    /**
     * 去申请学校
     * @return string
     */
    public function actionApplySchool()
    {
        $this->actionAuthJudge();
        $countryId = (string)app()->request->get('schoolCountryId', 0);
        $cityId = (string)AreaHelper::getOneInfo($countryId);
        $provinceId = (string)AreaHelper::getOneInfo($cityId);

        return $this->render('applySchool', ['countryId' => $countryId, 'cityId' => $cityId, 'provinceId' => $provinceId]);
    }

    /**
     * 确认申请学校
     * @return string
     */
    public function actionConfirmApplySchool()
    {
        $JsonMessage = new JsonMessage();
        $provinceId = (string)app()->request->post('provinceId');
        $cityId = (string)app()->request->post('cityId');
        $countryId = (string)app()->request->post('countryId');
        $applySchoolName = (string)app()->request->post('applySchoolName');
        $userId = (int)user()->id;

        $schoolModel = new SearchSchoolMicroService();
        $applySchool = $schoolModel->applySchool($userId, $applySchoolName,$provinceId,$cityId,$countryId);

        if ($applySchool && $applySchool->meta_data['http_code'] == 200) {
            $JsonMessage->success = true;
            $JsonMessage->message = '申请学校成功';
        } else {
            $JsonMessage->message = '申请学校失败';
        }

        return $this->renderJSON($JsonMessage);
    }


    /**
     * 创建班级
     * @return string
     */
    public function actionCreateClass()
    {
        $this->actionAuthJudge();
        $schoolId = (int)app()->request->get('schoolId');
        $departmentId = (string)app()->request->get('departmentId');
        $schoolInfo = SeSchoolInfo::getOneCache($schoolId);
        if (empty($schoolInfo)) {
            return $this->notFound('学校不存在！');
        }

        //加入时间
        $years = getClassYears();
        $joinYear = [];
        foreach ($years as $k => $v) {
            $joinYear[] = $v;
        }

        //年级
        $lengthOfSchooling = $schoolInfo->lengthOfSchooling; //学制
        //查询默认学部的年级列表
        $gradeData = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($departmentId, $lengthOfSchooling);
        $gradeDataList = ArrayHelper::map($gradeData, 'gradeId', 'gradeName');


        return $this->render('createClass', ['schoolInfo' => $schoolInfo, 'departmentId' => $departmentId, 'joinYear' => $joinYear, 'gradeDataList' => $gradeDataList]);
    }


    /**
     * 确认创建班级
     * @return string
     */
    public function actionConfirmCreateClass()
    {

        $jsonMessage = new JsonMessage();
        $schoolId = (int)app()->request->post('schoolId');
        $departmentId = (string)app()->request->post('departmentId');
        $gradeId = (int)app()->request->post('gradeId');
        $classId = (string)app()->request->post('classId');
        $joinYear = (string)app()->request->post('joinYear');

        $userId = user()->id;

        $schoolModel = new SearchSchoolMicroService();
        $classInfo = $schoolModel->findClassOne($schoolId, $gradeId, $classId, $joinYear);
        if ($classInfo) {
            $jsonMessage->data = $classInfo[0]->classID;
            $jsonMessage->success = false;
            $jsonMessage->message = '该班级已存在！';
            return $this->renderJSON($jsonMessage);
        }

        $createClass = $schoolModel->createClass($userId, $schoolId, $departmentId, $gradeId, $classId, $joinYear);
        if ($createClass) {
            $jsonMessage->data = $createClass->classID;
            $jsonMessage->success = true;
            $jsonMessage->message = '创建班级成功！';
        }

        return $this->renderJSON($jsonMessage);

    }

    /**
     * 加入班级
     * @return string
     */
    public function actionJoinClass()
    {

        $jsonMessage = new JsonMessage();
        $classId = app()->request->post('classId');
        $userId = user()->id;
        $organizationModel = new OrganizationService();
        $addTeacher = $organizationModel->ChangeTeacherClass($userId, $classId);

        if ($addTeacher->success) {
            $jsonMessage->success = true;
            $jsonMessage->data = $classId;
            $jsonMessage->message = '加入班级成功！';
        } else {
            $jsonMessage->message = '加入班级失败！';
        }

        return $this->renderJSON($jsonMessage);
    }


    /**
     * 权限判断
     * @return string|\yii\web\Response
     */
    public function actionAuthJudge(){
        if(user()->isGuest){
            return $this->redirect('/site/login');
        }
        if(loginUser()->isStudent()){
            return $this->notFound();
        }
       return $this->userRedirectClassHome();
    }

}
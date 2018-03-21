<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/2
 * Time: 11:44
 */
namespace schoolmanage\modules\personnel\controllers;
use common\clients\OrganizationService;
use common\helper\DateTimeHelper;
use common\models\JsonMessage;
use common\models\pos\SeClass;
use common\models\pos\SeUserinfo;
use common\clients\ClassChangeService;
use common\models\dicmodels\ClassListModel;
use common\models\dicmodels\LoadSubjectModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use schoolmanage\components\helper\GradeHelper;
use schoolmanage\components\SchoolManageBaseAuthController;
use schoolmanage\models\TeacherForm;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * UserController implements the CRUD actions for SeUserinfo model.
 * Class TeacherController
 * @package schoolmanage\modules\personnel\controllers
 */
class TeacherController extends SchoolManageBaseAuthController
{

	public $layout = 'lay_personnel_index';
	public $enableCsrfValidation = false;

	/**
	 * 人员管理 教师管理
	 * @return string
	 * @throws \yii\base\InvalidParamException
	 */
	public function actionIndex()
	{
		$schoolId = $this->schoolId;
		$department = app()->request->get('department');
		$subjectId = app()->request->get('subjectId');

		$searchWord = app()->request->post('searchWord');

		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$schoolData = $this->schoolModel;
		$departmentId = $schoolData->department; //学部id
		$departmentArray = explode(',', $departmentId);

		$teacherQuery = SeUserinfo::find()->where(['schoolID' =>$schoolId, 'type' =>1]);

		//搜用户名 he 搜手机
		if(!empty($searchWord)){
			$teacherQuery->andWhere(['or', ['trueName' => $searchWord],  ['bindphone' => $searchWord]]);
		}

		//搜学部
		if (!empty($department)) {
			$teacherQuery->andWhere(['department' =>$department]);
		}
		//搜学科
		if (!empty($subjectId)) {
			$teacherQuery->andWhere(['subjectID' =>$subjectId]);
		}

		$numberOfPeople = $teacherQuery->count();
		$pages->totalCount = $numberOfPeople;
		$userInfo = $teacherQuery->orderBy('createTime desc, userID desc')->offset($pages->getOffset())->limit($pages->getLimit())->select('userID,trueName,department,sex,subjectID,bindphone,phoneReg')->all();

		if (app()->request->isAjax) {
			return $this->renderPartial('_teacher_list', ['userInfo' => $userInfo, 'pages' => $pages, 'numberOfPeople' => $numberOfPeople]);
		}

		return $this->render('index',[
				'userInfo' => $userInfo,
				'pages' => $pages,
				'departmentArray' => $departmentArray,
				'numberOfPeople' => $numberOfPeople
		]);
	}

	/**
	 * 用于重置密码页面
	 * @return bool|string
	 * @throws \yii\base\ExitException
	 * @throws \yii\web\HttpException
	 */
	public function actionAlertPassword()
	{
		$schoolId = $this->schoolId;
		$userId = (int)app()->request->get('userId',0);
		$type = 1;//用户身份
		if(empty($userId)){
			return $this->notFound('用户不能为空！');
		}
		//查询该用户是否在该校
		$userInfo = SeUserinfo::accordingToUserIdAndSchoolIdToGetUserIdAndTrueName($userId,$schoolId,$type);
		if(empty($userInfo)){
			return $this->notFound('未找到该用户');
		}
		return $this->renderAjax('_reset_passwd_view', ['userInfo' =>$userInfo]);
	}

	/**
	 * 重置密码
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionUpdatePassword()
	{
		$jsonResult = new JsonMessage();

		$schoolId = $this->schoolId;
		$userId = (int)app()->request->get('userId', 0);
		$type = 1; //用户身份
		//查询该用户是否在该校
		$userInfo = SeUserinfo::accordingToUserIdAndSchoolIdToGetUserIdAndTrueName($userId,$schoolId,$type);

		if(empty($userId)){
			$jsonResult->success = false;
			$jsonResult->message = '请正确修改！';
		} elseif (empty($userInfo)) {
			$jsonResult->success = false;
			$jsonResult->message = '无该教师，请检查！';
		} else {
			$updatePwd = SeUserinfo::accordingUserIdAndSchoolIdUpdatePassword($userId, $schoolId, $type);

			if($updatePwd === 1) {
				$jsonResult->success = true;
				$jsonResult->message = '修改成功！';
			} else {
				$jsonResult->success = false;
				$jsonResult->message = '修改失败！';
			}
		}

        \Yii::info('老师重置密码操作, 操作人Id：'.Yii::$app->user->id . '; schoolId:'.$schoolId.'; userId:'.$userId.', 方法：' . __METHOD__  , 'userHandler');

		return $this->renderJSON($jsonResult);
	}

	/**
	 * 查询教师的详情
	 * @return bool|string
	 * @throws \yii\base\ExitException
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\web\HttpException
	 */
	public function actionViewUserInfo()
	{
		$schoolId = $this->schoolId;

		$userId = (int)app()->request->get('userId',0);
		if(empty($userId)){
			return $this->notFound('用户不能为空！');
		}
		//教师身份
		$type =1;
		//查询教师部分信息
		$teaInfo = SeUserinfo::accordingToUserIdAndSchoolIdToGetSomeInformation($userId,$schoolId,$type);

		if(empty($teaInfo))
		{
			$classMem = [];
		} else {
			//获取班级
			$classMem = $teaInfo->getSeClassMembers()->select('classID')->all();
		}

		return $this->renderPartial('_view_teacher_info', ['teaInfo' =>$teaInfo, 'classMem' =>$classMem]);
	}

	/**
	 * 点击修改 获取 用户相关信息
	 * @return string
	 * @throws \yii\base\ExitException
	 * @throws \yii\web\HttpException
	 */
	public function actionUpdateTeaInfoView()
	{
		$schoolId = $this->schoolId;

		$userId = (int)app()->request->get('userId',0);
		if(empty($userId)){
			return $this->notFound('用户不能为空！');
		}
		//教师身份
		$type = 1;
		//查询教师部分信息
		$teaInfo = SeUserinfo::accordingToUserIdAndSchoolIdToGetSomeInformation($userId,$schoolId,$type);

		if(empty($teaInfo))
		{
			$classMem = [];
		} else {
			//获取班级
			$classMem = $teaInfo->getSeClassMembers()->select('classID')->all();
		}

		return $this->renderAjax('_edit_teacher_info', ['teaInfo' =>$teaInfo, 'classMem' =>$classMem]);
	}

	/**
	 * 修改用户信息
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionUpdateUserInfo()
	{
		$jsonResult = new JsonMessage();

		$schoolId = $this->schoolId;
		$userId = (int)app()->request->post('userId',0);
		$teaName = app()->request->post('teaName');
		$teaSex = app()->request->post('teaSex');
		$version = app()->request->post('version');
		$subject = app()->request->post('subject');
		$type = 1;
		//查询该用户是否在该校
		$checkUserInfo = SeUserinfo::accordingToUserIdAndSchoolIdToGetSomeInformation($userId,$schoolId,$type);

		if(empty($userId)){
			$jsonResult->success = false;
			$jsonResult->message = '请正确修改！';
		} elseif(empty($checkUserInfo)) {
			$jsonResult->success = false;
			$jsonResult->message = '该校无此教师，请检查！';
		}elseif(empty($teaName)){
			$jsonResult->success = false;
			$jsonResult->message = '用户名不能为空！';
		}elseif(mb_strlen($teaName)<2){
			$jsonResult->success = false;
			$jsonResult->message = '用户名至少2个字！';
		}elseif(empty($subject)){
			$jsonResult->success = false;
			$jsonResult->message = '请选择学科！';
		} else {

			$checkUserInfo->trueName = $teaName;
			$checkUserInfo->sex = $teaSex;
			$checkUserInfo->subjectID = $subject;
			$checkUserInfo->textbookVersion = $version;

			if($checkUserInfo->save(false) ){
				$jsonResult->success = true;
				$jsonResult->message = '修改成功！';
			}else{
				$jsonResult->success = false;
				$jsonResult->message = '修改失败！';
			}
		}

        \Yii::info('修改老师用户信息操作, 操作人Id：'.Yii::$app->user->id . '; userId:'.$userId.'; trueName:'.$teaName.'; sex:'.$teaSex.'; subjectID:'.$subject.'; textbookVersion:'.$version.', 方法：' . __METHOD__  , 'userHandler');

		return $this->renderJSON($jsonResult);
	}

	/**
	 * 查询单条用户信息  用于修改信息后刷新单条记录
	 * @return string
	 * @throws \yii\base\ExitException
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\web\HttpException
	 */
	public function actionTeacherOneDetail(){
		$schoolId = $this->schoolId;

		$userId = (int)app()->request->get('userId',0);
		if(empty($userId)){
			return $this->notFound('用户不能为空！');
		}
		$type = 1;
		//查询教师信息
		$teaInfo = SeUserinfo::accordingToUserIdAndSchoolIdToGetSomeInformation($userId,$schoolId,$type);
		if(empty($teaInfo)){
			return $this->notFound('未找到该用户');
		}
		return $this->renderPartial('_teacher_list_detail', ['item' =>$teaInfo]);
	}


	/**
	 *根据学部获取科目
	 * @param string $department 学部
	 */
	public function actionGetSubject(string $department)
	{
		echo Html::tag('option', '学科', array('value' => ''));
		if (empty($department)) {
			return;
		}
		$data = LoadSubjectModel::model()->getData($department, 1);
			foreach ($data as $item) {
			echo Html::tag('option', Html::encode($item->secondCodeValue), array('value' => $item->secondCode));
		}
	}

	/**
	 * 根据科目查询版本
	 * @param string $subject 科目
	 */
	public function actionGetVersion(string $subject,$prompt=true,$grade=null)
	{

		if($prompt){
			echo Html::tag('option', '请选择', array('value' => ''));
		}
		if (empty($subject)) {
			return;
		}
		$data = LoadTextbookVersionModel::model($subject,$grade)->getListData();
		foreach ($data as $key => $item) {
			echo Html::tag('option', Html::encode($item), array('value' => $key));
		}
	}

	/**
	 * 根据 学段 科目查询版本
	 * @param string $subject 科目
	 * @param string $department 学段
	 */
	public function actionGetVersions(string $subject, string $department)
	{

		echo Html::tag('option', '版本', array('value' => ''));
		if (empty($subject) || empty($department)) {
			return;
		}
		$data = LoadTextbookVersionModel::model($subject, null, $department)->getListData();
		foreach ($data as $key => $item) {
			echo Html::tag('option', Html::encode($item), array('value' => $key));
		}
	}

	/**
	 * 老师移除学校
	 * @throws \yii\base\ExitException
	 * @throws \yii\web\HttpException
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function actionKickedOutSchool()
	{
		$jsonResult = new JsonMessage();
		$schoolId = $this->schoolId;
		$userId = (int)app()->request->post('userId',0);
		if(empty($userId)){
			$jsonResult->message = '用户名不能为空';
			return $this->renderJSON($jsonResult);
		}
		$this->getSchoolUser($userId);
		$organizationModel = new OrganizationService();
		$jsonResult = $organizationModel->OutSchool($userId);

        \Yii::info('老师移除学校操作, 操作人Id：'.Yii::$app->user->id . '; userId:'.$userId.'; schoolId:'.$schoolId.', 方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($jsonResult);

	}


	/**
	 * 查询学部下的年级
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionGetGrade()
	{
		$departmentId = (string)app()->request->post('departmentId');
		$jsonResult = new JsonMessage();
		//学制
		$schoolData = $this->schoolModel;
		$lengthOfSchooling = $schoolData->lengthOfSchooling;

		//根据学部和学制获取相对的年级列表
		$gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($departmentId,$lengthOfSchooling,1);
		$gradeDataList =  ArrayHelper::map($gradeModel, 'gradeId', 'gradeName');
		$jsonResult->data = $gradeDataList;
		return $this->renderJSON($jsonResult);
	}

	/**
	 * 老师教的班级及班级名
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionTeachingClasses()
	{
		$jsonResult = new JsonMessage();
		$userId = (int)app()->request->post('userId');
		if(empty($userId)){
			$jsonResult->message = '用户名不能为空';
			return $this->renderJSON($jsonResult);
		}

		//老师教的班级
		$teachingClasses = SeClass::getClasses($userId);
		$classesDataList =  ArrayHelper::map($teachingClasses, 'classID', 'className');
		$jsonResult->success = true;
		$jsonResult->data = $classesDataList;
		return $this->renderJSON($jsonResult);
	}

	/**
	 * 获取年级下面的班级
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionGetClasses()
	{
		$jsonResult = new JsonMessage();
		$schoolId = $this->schoolId;
		$departmentId = (string)app()->request->post('departmentId');
		$gradeId = (string)app()->request->post('gradeId',null);    //获取年级

		//获取相应年级下面相对应的班级
		$classesList=ClassListModel::model($schoolId, $gradeId, $departmentId)->getListData();
		$jsonResult->success = true;
		$jsonResult->data = $classesList;
		return $this->renderJSON($jsonResult);
	}


	/**
	 * 老师班级的修改
	 * @throws \yii\base\ExitException
	 * @throws \yii\web\HttpException
	 * @throws \Httpful\Exception\ConnectionErrorException
	 */
	public function actionTeacherClassModify()
	{
		$jsonResult = new JsonMessage();
		$classIdList = app()->request->post('classIdList');
		$userId = (int)app()->request->post('userId');
		if(empty($userId)){
			$jsonResult->message = '用户名不能为空';
			return $this->renderJSON($jsonResult);
		}
		if(empty($classIdList)){
			$jsonResult->message = '班级不能为空';
			return $this->renderJSON($jsonResult);
		}

		$this->getSchoolUser($userId);
		//去重
		$classIdList = array_unique($classIdList);
		$seClassModelList = $this->getSchoolClassModels($classIdList);
		$classIdListAuth =ArrayHelper::getColumn($seClassModelList,'classID');
		$classList = implode(',',$classIdListAuth);
		$organizationModel = new OrganizationService();
		$jsonResult= $organizationModel ->ChangeTeacherClass($userId,$classList);
        \Yii::info('老师调班操作, 操作人Id：'.Yii::$app->user->id . '; userId:'.$userId.'; classId:'.implode(',',$classIdList).',方法：' . __METHOD__  , 'userHandler');

        return $this->renderJSON($jsonResult);
	}

	/**
	 * 点击添加老师
	 * @return string
	 * @throws \yii\web\HttpException
	 */
	public function actionAddTeaInfoView()
	{
		$schoolData = $this->schoolModel;
		$departmentId = $schoolData->department;
		$departmentArray = explode(',', $departmentId);

		return $this->renderAjax('_add_teacher', ['departmentArray' =>$departmentArray]);
	}

	/**
	 * 添加老师
	 * @return JsonMessage|string
	 * @throws \yii\base\InvalidParamException
	 * @throws \yii\base\ExitException
	 */
	public function actionAddTeacherAccount()
	{
		$jsonResult = new JsonMessage();
		$schoolId = $this->schoolId;
		$trueName = app()->request->post('trueName');
		$bindphone = app()->request->post('bindphone');
		$sex = app()->request->post('sex',0);
		$department = app()->request->post('department');
		$subjectID = app()->request->post('subjectID');
		$textbookVersion = app()->request->post('textbookVersion');
		$phoneReg = $trueName.$bindphone;
		$userIsExisted = SeUserinfo::existsPhoneReg($phoneReg);
		if($userIsExisted){
			$phoneReg = $trueName.random_int(1,99).$bindphone;
		}

		$userinfoModel = SeUserinfo::accordingPhoneRegGetUserInfo($phoneReg);

		if( isset($userinfoModel) ) {
			$jsonResult->message = '帐号已经存在';
			return $this->renderJSON($jsonResult);
		}

        $service = new ClassChangeService();

        $result = $service->NewAddTeacher((int)$schoolId,(string)$trueName,(int)$bindphone,(int)$sex,(int)$department,(int)$subjectID,(int)$textbookVersion);

		if($result->success){
		    $jsonResult->success = true;
		    $jsonResult->data = $result->data;
		    $jsonResult->message = '添加老师成功';
        }else{
            $jsonResult->message = $result->message;
        }

		return $this->renderJSON($jsonResult);
	}


}
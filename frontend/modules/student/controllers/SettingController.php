<?php
declare(strict_types=1);
namespace frontend\modules\student\controllers;

use common\clients\JfManageService;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClassMembers;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeUserinfo;
use common\models\pos\SeWrongQuestionBookInfo;
use common\models\pos\SeWrongQuestionBookSubject;
use frontend\components\StudentBaseController;
use frontend\models\EditPasswordForm;
use frontend\services\pos\pos_MessageSentService;
use Yii;
use yii\data\Pagination;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-19
 * Time: 上午9:54
 */
class SettingController extends StudentBaseController
{

	public function actions()
	{
		//私信部分
		return ['message-list' => [
			'class' => 'frontend\controllers\message_box\MessageListAction'
		],
			'view-message' => [
				'class' => 'frontend\controllers\message_box\ViewMessageAction'
			]
		];
	}

	public $layout = 'lay_user_new';

    /**
     * 修改密码
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */
	public function actionChangePassword()
	{
		$model = new EditPasswordForm();
		if ($_POST) {
			$model->attributes = $_POST['EditPasswordForm'];
			$model->userId = user()->id;

			if ($model->validate()) {
				Yii::$app->getSession()->setFlash('success', '密码修改成功！');
				return $this->redirect(['change-password']);
			}
		}
		return $this->render('//publicView/setting/changePassword', array('model' => $model));
	}

    /**
     * 修改头像
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionSetHeadPic()
	{
		return $this->render('//publicView/setting/setHeadPic');
	}

    /**
     * 个人中心
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionMyCenter()
	{
		$proFirstime = microtime(true);

		$userId = user()->id;
		$wrongSubjectId = null;

		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 2;

		//获取用户所在学校
		$userModel = loginUser();
		$schoolId = $userModel->schoolID;
		$schoolModel = $this->getSchoolModel($schoolId);
		//获取用户所在班级
		$classModel = $userModel->getClassInfo();
		$class = current($classModel);
		$classId = 0;
		if (!empty($class)) {
			$classId = $class->classID;
		}

		//总积分和可用积分和今日积分(调接口)
		$jfManageHelperModel = new JfManageService();
		$userScore = $jfManageHelperModel->UserScore($userId);
		$points = $userScore->points ?? 0;
		$totalPoints = $userScore->totalPoints ?? 0;
		$todayPoints = $jfManageHelperModel->UserDayScore($userId);
		$gradePonits = $jfManageHelperModel->JfGrade($userId);

		//我的作业
		$homeworkPelModel = new SeHomeworkRel();
		$taskResult = $homeworkPelModel->selectStuCenterHomework($userId, $classId);
		$homeworkPelModel::getHomeworkTeacherInfo($taskResult);
		
		//答疑
		$answerQuestionModel = new SeAnswerQuestion();
		$answerResult = $answerQuestionModel->selectStuCenterAnswer($userId);
		//查询回答数
		$answerQuestionModel::getAnswerCount($answerResult);
		//错题编号
		$wrongQueBookInfoModel = new SeWrongQuestionBookInfo();
		$wrongQuestion = $wrongQueBookInfoModel->selectWrongQuestion($userId, $wrongSubjectId);

		\Yii::info('学生中心 ' . (microtime(true) - $proFirstime), 'service');
		return $this->render('studentCenter',
			[
				'pages' => $pages,
				'classId' => $classId,
				'classModel' => $class,
				'schoolModel' => $schoolModel,
				'taskResult' => $taskResult,
				'answerResult' => $answerResult,
				'wrongQuestion' => $wrongQuestion,
				'points' => $points,
				'totalPoints' => $totalPoints,
				'todayPoints' => $todayPoints,
				'gradePonits' => $gradePonits,
			]);
	}


    /**
     * 学生个人中心 系统消息
     * @return string
     * @throws \yii\base\InvalidParamException
     */

	public function actionGetStuMessages()
	{
		$userId = app()->request->get('userId');
		//系统消息3条
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 3;
		$data = new pos_MessageSentService();
		$result = $data->readerQuerySentMessageInfo($userId, 508, '', $pages->getPage() + 1, $pages->pageSize);

		return $this->renderPartial('student_message', ['result' => $result->data->list]);
	}

	/*
	 * 新错题集
	 * @return string
	 */
	public function actionWroTopForItem()
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 2;
		$subjectId = app()->request->get('type', '');
		$wrongSubjectId = '';
		$userId = user()->id;
		$wrongQueBookInfoModel = new SeWrongQuestionBookInfo();
		$wrongQueBookSubjectModel = new SeWrongQuestionBookSubject();
		if (empty($subjectId)) {
			//选择全部
			$wrongQuestion = $wrongQueBookInfoModel->selectWrongQuestion($userId, $wrongSubjectId);
		} else {
			//选择相应学科的查询
			$wrongSubject = $wrongQueBookSubjectModel->selectWrongSubjectId($userId, $subjectId);
			if (empty($wrongSubject)) {
				$wrongQuestion = [];
			} else {
				$wrongSubjectId = $wrongSubject->wrongSubjectId;
				$wrongQuestion = $wrongQueBookInfoModel->selectWrongQuestion($userId, $wrongSubjectId);
			}
		}

		return $this->renderPartial('//publicView/wrong/_new_wrong_question_list', ['wrongQuestion' => $wrongQuestion, 'pages' => $pages]);
	}

    /**
     * 学生修改班级页面
     * wgl
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionChangeClass()
	{
		$userId = user()->id;
		$classInfo = SeClassMembers::getClass($userId);
		if (empty($classInfo)) {
			return $this->redirect(url('register/join-class'));
		}
		return $this->render('studentChangeClass', ['classInfo' => $classInfo]);
	}

    /**
     * 用于退出班级确认弹窗~
     * wgl
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
	public function actionFindClassInfo()
	{
		$classId = app()->request->get('classId');
		$userId = user()->id;
		$classInfo = SeClassMembers::getOneClassInfo((int)$classId, $userId);
		if (empty($classInfo)) {
			return $this->notFound('未找到该班级,请正确输入！');
		}
		return $this->renderPartial('_student_del_class_view', ['classInfo' => $classInfo]);
	}

    /**
     * 学生基本信息页面
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionBasicInformation()
	{
		$userId = user()->id;
		$parentAccountModel = SeUserinfo::getParentAccount($userId);
		if (!$parentAccountModel) {
            $parentAccount = '';
        } else {
            $parentAccount = $parentAccountModel->phoneReg;
        }
		return $this->render('student_basic_information', ['parentAccount' => $parentAccount]);
	}


    /**
     * 学生修改基本信息页面
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */
	public function actionStudentEditBasicInformation()
	{
		$userModel = loginUser();

		$parentAccountModel = SeUserinfo::getParentAccount($userModel->userID);
		if (!$parentAccountModel) {
            $parentAccount = '';
        } else {
            $parentAccount = $parentAccountModel->phoneReg;
        }

		if (app()->request->getIsPost()) {
			$userModel->sex = app()->request->post('sex', 0);
			if ($userModel->save(false)) {
				return $this->redirect(['basic-information']);
			}
		}
		return $this->render('student_edit_basic_information', ['parentAccount' => $parentAccount]);
	}
}
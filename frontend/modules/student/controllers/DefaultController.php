<?php
namespace frontend\modules\student\controllers;

use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClassMembers;
use common\models\pos\SeQuestionResult;
use common\models\pos\SeUserinfo;
use frontend\components\BaseAuthController;
use yii\data\Pagination;


/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-1
 * Time: 下午1:19
 */
class DefaultController extends BaseAuthController
{
	public $layout = 'lay_user_home';

    /**
     * 首页
     * @param int $studentId
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
	public function actionIndex($studentId = 0)
	{

		if ($studentId == 0) {
			$studentId = user()->id;
			return $this->redirect(url('student/default/index', ['studentId' => $studentId]));
		}
		$user = SeUserinfo::getUserDetails($studentId);
		if ($user == null) {
			return $this->notFound();
		}
		if ($user->isTeacher()) {
			return $this->redirect(url('teacher/default/index', ['teacherId' => $studentId]));
		}

		$this->view->params['studentId'] = $studentId;
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$answerQuestion = SeAnswerQuestion::find()->where('creatorID=:CreatorId  OR (aqID IN (SELECT rel_aqID FROM se_questionResult WHERE isDelete=0 and creatorID=:CreatorId))', [':CreatorId' => $studentId])->active();
		$pages->totalCount = $answerQuestion->count();
		$modelList = $answerQuestion->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		//关于答疑总汇的统计
		$useCnt = SeQuestionResult::getUserRelyQuestion($studentId);
		$answerCnt = SeQuestionResult::getUserAnswerQuestion($studentId);
		$askQuesCnt = SeAnswerQuestion::getUserAskQuestion($studentId);
		if ($useCnt == null || $answerCnt == null || $askQuesCnt == null) {
			return $this->notFound();
		}

		return $this->render('new_index',
			array(
				'modelList' => $modelList,
				'studentId' => $studentId,
				'pages' => $pages,
				'useCnt' => $useCnt,
				'answerCnt' => $answerCnt,
				'askQuesCnt' => $askQuesCnt
			)
		);
	}

    /**
     * @param $studentId
     * @return string|\yii\web\Response
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
	public function IsInto($studentId)
	{
		if ($studentId == 0) {
			$studentId = user()->id;
			return $this->redirect(url('student/default/index', ['studentId' => $studentId]));

		}

		$user = loginUser()->getUserInfo($studentId);
		if ($user == null) {
			return $this->notFound();
		}
		if ($user->isTeacher()) {
			return $this->redirect(url('teacher/default/index', ['teacherId' => $studentId]));
		}
	}

    /**
     * 点击查看更多
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionGetPages()
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$userId = app()->request->getQueryParam('userid', '');
		$answerQuestion = SeAnswerQuestion::find()->where('creatorID=:CreatorId OR (aqID IN (SELECT rel_aqID FROM se_questionResult WHERE isDelete=0 and creatorID=:CreatorId))', [':CreatorId' => $userId])->active();
		$pages->totalCount = $answerQuestion->count();
		$modelList = $answerQuestion->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		if ($modelList != null) {
			return $this->renderPartial('_list_view', array('modelList' => $modelList, 'studentId' => $userId, 'pages' => $pages));
		}
	}

	/**
	 * 获取班级教师和学生排除自己
	 * @param $studentId
	 * @return array|\common\models\pos\SeClassMembers[]
	 */
	public function getClassMemberAll($studentId)
	{
		$classResult = [];
		if (!empty($studentId)) {
			$classID = loginUser()->getFirstClass();
			if (!empty($classID)) {
				$classResult = SeClassMembers::getClassMemberInfo($classID);
			}
		}
		return $classResult;
	}
}
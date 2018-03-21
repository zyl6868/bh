<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-9-3
 * Time: 下午5:06
 */
namespace frontend\controllers;

use common\clients\HomeworkService;
use common\helper\DateTimeHelper;
use common\models\JsonMessage;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClass;
use common\models\pos\SeClassEvent;
use common\models\pos\SeClassEventPic;
use common\models\pos\SeClassMembers;
use common\models\pos\SeHomeworkAnswerDetailImage;
use common\models\pos\SeHomeworkAnswerImage;
use common\models\pos\SeHomeworkAnswerInfo;
use common\models\pos\SeHomeworkAnswerInfoQuery;
use common\models\pos\SeHomeworkAnswerQuestionAll;
use common\models\pos\SeHomeworkQuestion;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use common\models\pos\SeShareMaterial;
use common\models\sanhai\ShTestquestion;
use common\models\sanhai\SrMaterial;
use common\clients\JfManageService;
use frontend\components\BaseAuthController;
use frontend\components\helper\ImagePathHelper;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/**
 * BaseAuthController 为登录权限
 * 本班的教师和学生可以修改
 * Class ClassController
 * @package frontend\controllers
 */
class ClassController extends BaseAuthController
{

	public $layout = 'lay_new_class_v2';

    /**
     *班级主页
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
	public function actionIndex(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_index_v2';
		$classModel = $this->getClassModel($classId);
		$pages = new Pagination();
		$pages->validatePage = false;

		$homeworkRelModel = new SeHomeworkRel();
		$answerModel = new SeAnswerQuestion();
		$classEventModel = new SeClassEvent();

		//查询作业 答疑 大事记
		$homeworkInfoRel = $homeworkRelModel->selectOneClassHomework($classId);
		$answerInfo = $answerModel->selectOneClassAnswer($classId);
		$classEventList = $classEventModel->selectClassEventList($classId);

		$classEventInfo = [];
		if (!empty($classEventList)) {
			$classEventInfo = $classEventList[0];
		}

		//判断成员是否在该班级中
		$isInClass = loginUser()->getModel()->getInClassInfo($classId);

		return $this->render('newIndex', [
			'classModel' => $classModel,
			'homeworkInfoRel' => $homeworkInfoRel,
			'answerInfo' => $answerInfo,
			'classEventInfo' => $classEventInfo,
			'classEventList' => $classEventList,
			'isInClass' => $isInClass,
		]);
	}

    /**
     * 班内答疑
     * 答疑列表 wgl
     * @param integer $classId 班级id
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionAnswerQuestions(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';
		$proFirstime = microtime(true);
		$this->getClassModel($classId);
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$keyWord = app()->request->get('keyWord', '');//获取搜索答疑关键词，之前预留口
		$subjectID = (int)app()->request->get('subjectID', 0);//获取科目id搜索
		$solvedType = (int)app()->request->get('solved_type', 0);
		$answerQuery = SeAnswerQuestion::find()->where(['classID' => $classId])->active();
		//条件为空不搜索
		if (!empty($keyWord)) {
			$answerQuery->andWhere(['like', 'aqName', $keyWord]);
		}
		//条件为空不搜索
		if (!empty($subjectID)) {
			$answerQuery->andWhere(['subjectID' => $subjectID]);
		}
		//已解决
		if ($solvedType == 1) {
			$answerQuery->andWhere(['isSolved' => 1]);
		}
		//未解决
		if ($solvedType == 2) {
			$answerQuery->andWhere(['isSolved' => 0]);
		}

		//查询排名 班级 个人提问数+同问数
		$answerSort = SeAnswerQuestion::getClassAnswerRanking($classId);

		$pages->totalCount = $answerQuery->count();
		$answerList = $answerQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		//查询各个问题的回答数
		SeAnswerQuestion::getAnswerCount($answerList);

		//查询同问数
		SeAnswerQuestion::getAlsoAskCount($answerList);
		\Yii::info('班级答疑 ' . (microtime(true) - $proFirstime), 'service');
		if (app()->request->isAjax) {
			//公共页面传数据
			return $this->renderPartial('//publicView/answer/_new_answer_question_list', array('modelList' => $answerList, 'pages' => $pages, 'classId' => $classId));
		}

		return $this->render('answerquestions', array(
			'modelList' => $answerList,
			'answerSort' => $answerSort,
			'classId' => $classId,
			'pages' => $pages
		));
	}


    /**
     * 班级新鲜事 换一换
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionChangeNew(int $classId)
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		//查询作业

		//查询答疑

		//0：顺序搜索；1：随机搜索

		$homeworkInfoRel = SeHomeworkRel::randHomeworkRelDetails($classId);
		$answerInfo = SeAnswerQuestion::randAnswerQuestion($classId);
		$classEventInfo = SeClassEvent::randClassEvent($classId);
		//       判断成员是否在该班级中
		$isInClass = loginUser()->getModel()->getInClassInfo($classId);
		return $this->renderPartial('_class_index_something_new', [
			'homeworkInfoRel' => $homeworkInfoRel,
			'answerInfo' => $answerInfo,
			'classEventInfo' => $classEventInfo,
			'classId' => $classId,
			'isInClass' => $isInClass
		]);
	}

    /**
     * 班级文件列表（新加）
     * @param integer $classId 班级id
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionClassFile(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';

		$proFirstime = microtime(true);
		$this->getClassModel($classId);
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;

		$mattype = app()->request->getQueryParam('mattype', '');
		$gradeid = (int)app()->request->getQueryParam('gradeid', 0);
		$subjectid = (int)app()->request->getQueryParam('subjectid', 0);
		$fileName = app()->request->getQueryParam('fileName', '');
		$sortCondition = app()->request->getQueryParam('sortType', 'createTime');

		$shareMaterialData = SeShareMaterial::find()->select(['matId', 'createTime'])->where(['classID' => $classId])->active()->all();
		$matIdArr = [];
		foreach ($shareMaterialData as $item) {
			$matIdArr[] = $item->matId;
		}
		$materialQuery = SrMaterial::find()->where(['id' => $matIdArr]);

		if (!empty($mattype)) {
			$materialQuery->andWhere(['matType' => $mattype]);
		}
		if (!empty($gradeid)) {
			$materialQuery->andWhere(['gradeid' => $gradeid]);
		}
		if (!empty($subjectid)) {
			$materialQuery->andWhere(['subjectid' => $subjectid]);
		}
		if (!empty($fileName)) {
			$materialQuery->andWhere(['like', 'name', $fileName]);
		}
		if (!empty($sortCondition)) {
			$materialQuery->orderBy("$sortCondition desc");
		}


		$pages->totalCount = $materialQuery->count();
		$materialList = $materialQuery->offset($pages->getOffset())->limit($pages->getLimit())->all();

		$pages->params = ['mattype' => $mattype,
			'gradeid' => $gradeid,
			'subjectid' => $subjectid,
			'classId' => $classId,

		];
		\Yii::info('班级文件 ' . (microtime(true) - $proFirstime), 'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('_classfile_list', array(
				'shareMaterialData' => $shareMaterialData,
				'materialList' => $materialList,
				'classId' => $classId,
				'pages' => $pages
			));

		}
		return $this->render('classfile', array(
			'shareMaterialData' => $shareMaterialData,
			'materialList' => $materialList,
			'classId' => $classId,
			'mattype' => $mattype,
			'gradeid' => $gradeid,
			'subjectid' => $subjectid,
			'pages' => $pages,
			'fileName' => $fileName
		));

	}

    /**
     * 班级大事记
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionMemorabilia(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';
		$proFirstime = microtime(true);

		$this->getClassModel($classId);
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$eventModel = new SeClassEvent();
		$eventQuery = $eventModel::find()->where(['isDelete' => 0, 'classID' => $classId]);
        $pages->totalCount = $eventQuery->count();
        $eventResult = $eventQuery->orderBy('time desc')->limit($pages->getLimit())->offset($pages->getOffset())->all();
		\Yii::info('大事记 ' . (microtime(true) - $proFirstime), 'service');
		return $this->render('newMemorabilia', ['eventModel' => $eventModel, 'eventResult' => $eventResult, 'pages' => $pages, 'classID' => $classId]);
	}

    /**
     * 大事记相册模式
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionMemorabiliaAlbum(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';
		$this->getClassModel($classId);
		return $this->render('memorabiliaAlbum', ['classId' => $classId]);
	}

    /**
     * 添加大事记
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
	public function actionAddMemorabilia(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_new_class_v2';
		$this->getClassModel($classId);
		$eventModel = new SeClassEvent();
		if ($_POST) {
			$eventData = app()->request->getBodyParams();
			$eventName = $eventData['SeClassEvent']['name'];

			$time = $eventData['SeClassEvent']['time'];

			$briefOfEvent = $eventData['SeClassEvent']['briefOfEvent'];

			$eventModel->eventName = $eventName;
			$eventModel->time = strtotime($time) * 1000;
			$eventModel->createTime = DateTimeHelper::timestampX1000();
			$eventModel->briefOfEvent = $briefOfEvent;
			$eventModel->creatorID = user()->id;
			$eventModel->classID = $classId;
			if ($eventModel->save()) {
				if (array_key_exists('image', $eventData['SeClassEvent'])) {
					$image = $eventData['SeClassEvent']['image'];
					foreach ($image as $v) {
						$eventPicModel = new SeClassEventPic();
						$eventPicModel->picUrl = $v;
						$eventPicModel->eventID = $eventModel->eventID;
						$eventPicModel->createTime = DateTimeHelper::timestampX1000();
						$eventPicModel->save();
					}
				}
				$this->redirect(url::to(['/class/memorabilia', 'classId' => $classId]));
			}
		}
		return $this->render('addMemorabilia', ['eventModel' => $eventModel, 'classId' => $classId]);
	}

    /**
     * 修改大事记
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
	public function actionModifyMemorabilia(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_new_class_v2';
		$eventID = (int)app()->request->getQueryParam('eventID',0);
		$this->getClassModel($classId);
		$eventModel = SeClassEvent::getOneEventDetails($eventID);
		if ($_POST) {
			$eventData = app()->request->getBodyParams();
			$eventName = $eventData['SeClassEvent']['name'];
			$time = $eventData['SeClassEvent']['time'];

			$briefOfEvent = $eventData['SeClassEvent']['briefOfEvent'];
			$eventModel->eventName = $eventName;
			$eventModel->time = strtotime($time) * 1000;
			$eventModel->createTime = DateTimeHelper::timestampX1000();
			$eventModel->briefOfEvent = $briefOfEvent;
			$eventModel->creatorID = user()->id;
			if ($eventModel->save()) {
                SeClassEventPic::deleteAll(['eventID' => $eventID]);
				if (array_key_exists('image', $eventData['SeClassEvent'])) {
					$image = $eventData['SeClassEvent']['image'];
					foreach ($image as $v) {
						$updatePicModel = new  SeClassEventPic();
						$updatePicModel->picUrl = $v;
						$updatePicModel->eventID = $eventID;
						$updatePicModel->createTime = DateTimeHelper::timestampX1000();
						$updatePicModel->save();

					}
				}
				$this->redirect(url::to(['/class/memorabilia', 'classId' => $classId]));
			}
		}
		return $this->render('modifyMemorabilia', ['eventModel' => $eventModel, 'classId' => $classId]);
	}

    /**
     * 删除大事记
     * @return string
     * @throws \yii\base\ExitException
     */
	public function actionDeleteEvent()
	{
		$jsonResult = new JsonMessage();
		$eventID = (int)app()->request->getBodyParam('eventID',0);
		$result = SeClassEvent::deleteEvent($eventID);
		if ($result) {
			$jsonResult->success = true;
		}
		return $this->renderJSON($jsonResult);
	}

    /**
     * 大事记分页
     * @return string
     * @throws \yii\base\ExitException
     */
	public function actionGetEventPage()
	{

		$jsonResult = new JsonMessage();
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$classID = (int)app()->request->getQueryParam('classID',0);
		$eventQuery = SeClassEvent::find()->where(['isDelete' => 0, 'classID' => $classID]);
        $pages->totalCount = $eventQuery->count();
        $eventResult = $eventQuery->orderBy('time desc')->limit($pages->getLimit())->offset($pages->getOffset())->all();
		$dataArray = [];
		// 判断是否是该班的班主任
		$isMaster = $this->MasterClassByClass($classID);
		$userID = user()->id;
		foreach ($eventResult as $v) {
			$time = DateTimeHelper::timestampDiv1000($v->time);
			if ($isMaster) {
				$power = true;
			} else {
				if ($userID != $v->creatorID) {
                    $power = false;
                } else {
                    $power = true;
                }
			}
			$dataArray[] = ['year' => date('Y', $time), 'month' => date('m', $time), 'day' => date('d', $time), 'cont' => $v->eventName, 'eventID' => $v->eventID, 'power' => $power];

		}
		$array = ['pageCount' => $pages->getPageCount(), 'currPage' => $pages->getPage() + 2, 'data' => $dataArray];
		$jsonResult->data = $array;

		return $this->renderJSON($jsonResult);
	}

    /**
     * ajax大事记相册模式分页
     * @return string
     * @throws \yii\base\ExitException
     */
	public function actionGetAlbumList()
	{

		$jsonResult = new JsonMessage();
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$classID = (int)app()->request->getQueryParam('classID',0);
		$eventQuery = SeClassEvent::find()->where(['isDelete' => 0, 'classID' => $classID])->innerJoinWith('eventPic')->orderBy('time desc')->select('se_classEvent.eventID,time')->distinct();
		$pages->totalCount = $eventQuery->count();
		$eventResult = $eventQuery->limit($pages->getLimit())->offset($pages->getOffset())->all();
		$dataArray = [];
		foreach ($eventResult as $v) {
			$time = DateTimeHelper::timestampDiv1000($v->time);
			$date = date('Y-m-d', $time);
			if (!isset($dataArray[$date])) {
				$dataArray[$date] = ['year' => date('Y', $time), 'month' => date('m', $time), 'day' => date('d', $time), 'picList' => []];
			}
			$picResult = $v->eventPic;
			foreach ($picResult as $item) {
				$dataArray[$date]['picList'][] = ['href' => resCdn($item->picUrl), 'small_href' => ImagePathHelper::imgThumbnail($item->picUrl, 180, 120)];
			}
		}
		$picList = array_values($dataArray);


		$data = ['pageCount' => $pages->getPageCount(), 'currPage' => $pages->getPage() + 2, 'list' => $picList];
		$jsonResult->data = $data;

		return $this->renderJSON($jsonResult);
	}

    /**
     * 大事记详情
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionGetEventDetails()
	{
		$eventID = (int)app()->request->getBodyParam('eventID',0);
		$eventDetail = SeClassEvent::getOneEventDetails($eventID);
		return $this->renderPartial('_event_details', ['eventDetail' => $eventDetail]);
	}


    /**
     *  班级成员管理
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionMemberManage(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';

		$proFirstime = microtime(true);
		$this->getClassModel($classId);
		$classMembersModel = new SeClassMembers();

		//查询班主任
		$master = $classMembersModel->selectClassAdviser($classId);
		//查询教师列表
		$teacherList = $classMembersModel->selectClassTeacherList($classId);
		//查询学生列表
		$studentList = $classMembersModel->selectClassStudentList($classId);

		\Yii::info('班级成员 ' . (microtime(true) - $proFirstime), 'service');
		return $this->render('MemberManage', ['master' => $master, 'teacherList' => $teacherList, 'studentList' => $studentList]);

	}

    /**
     * 班级教师作业列表
     * wgl
     * @param integer $classId 班级ID
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function  actionHomework(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';
		$proFirstime = microtime(true);
		if (loginUser()->isStudent()) {
			return $this->redirect(Url::to(['student-homework', 'classId' => $classId]));

		}
		$classId = (int)$classId;
		$this->getClassModel($classId);
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;

		$subject = (int)app()->request->get('subjectId', 0);
		$getType = (int)app()->request->getParam('getType', 0);

		$query = SeHomeworkRel::find()->active()->where(['classID' => $classId]);
		//查询作业类型 纸质 or 电子
		if ($getType > 0) {
			$query->andWhere('homeworkId in (select id from se_homework_teacher where getType=:getType ) ', [':getType' => $getType]);
		}
		//查询科目
		if ($subject > 0) {
			$query->andWhere('homeworkId in (select id from se_homework_teacher where subjectId=:subjectId ) ', [':subjectId' => $subject]);
		}
        $pages->totalCount = $query->count();
		$homework = $query->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

		SeHomeworkRel::getHomeworkTeacherInfo($homework);

		\Yii::info('教师作业列表 ' . (microtime(true) - $proFirstime), 'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('_homework_list_tch', ['homework' => $homework, 'classId' => $classId, 'pages' => $pages]);
		}

		return $this->render('classTchWorkList', ['homework' => $homework, 'classId' => $classId, 'pages' => $pages]);
	}

    /**
     * 新 教师 作业作答情况
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
	public function actionWorkDetail(int $classId)
	{
		$this->getClassModel($classId);
		$classHomeworkId = (int)app()->request->get('classhworkid',0);
		$type = app()->request->get('type', 1);
		$checkTime = (int)app()->request->get('checkTime',0);
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		//查询rel关系表
		$result = SeHomeworkRel::getOneHomeworkRelDetails($classHomeworkId);
		//查询是否存在这条记录
		if (empty($result)) {
			return $this->notFound('该作业已被删除！');
		}
		//截止时间
		$deadlineTime = strtotime(date('Y-m-d 23:59:59', DateTimeHelper::timestampDiv1000($result->deadlineTime))) * 1000;
		//查询详情信息
		$homeWorkTeacher = $result->getHomeWorkTeacher()->one();
		$query = SeHomeworkAnswerInfo::find()->where(['relId' => $classHomeworkId, 'isUploadAnswer' => '1'])->orderBy('uploadTime asc');
		$cloneQuery = clone $query;
        /** @var SeHomeworkTeacher $homeWorkTeacher */
		//未批改选项卡
		if ($type == 1) {
			//调用拆分出去的 未交批改的内容页
            return $this->noCorrections($result, $classHomeworkId, $deadlineTime, $query, $checkTime, $homeWorkTeacher, $pages, $classId);
		} else if ($type == 2) {
			//调用拆分出去的 未提交的人员列表页
			return $this->noSubmitJob($result, $homeWorkTeacher, $classId, $classHomeworkId);
		}else {
			//已批改页面
			return $this->alreadyCorrections($result, $classHomeworkId, $deadlineTime, $classId, $cloneQuery, $pages, $checkTime, $homeWorkTeacher);
		}
	}

    /**
     * 作业作答情况 未批改选项卡内容
     * @param SeHomeworkRel $result 查询rel关系表
     * @param integer $classHomeworkId 班级作业id
     * @param integer $deadlineTime 截止时间
     * @param SeHomeworkAnswerInfoQuery $query 查询作业信息
     * @param integer $checkTime 检测时间
     * @param SeHomeworkTeacher $homeWorkTeacher 查询de详情信息
     * @param Pagination $pages 分页数
     * @param integer $classId 班级id
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	private function noCorrections(SeHomeworkRel $result, int $classHomeworkId, int $deadlineTime, SeHomeworkAnswerInfoQuery $query, int $checkTime, SeHomeworkTeacher $homeWorkTeacher, Pagination $pages, int $classId)
	{

		//未批改的作业数
		$noCorrections = $result->getHomeworkAnswerInfo()->where(['isCheck' => [0, 2], 'isUploadAnswer' => '1'])->count();

		//教师作业 补充内容的语音
		$homeworkRelAudio = $result->audioUrl;

		//查询未批改的
		$queryCount = SeHomeworkAnswerInfo::find()->where(['relId' => $classHomeworkId, 'isUploadAnswer' => '1', 'isCheck' => [0, 2]]);
		$cloneQueryCount = clone $queryCount;
		//查询按时提交数
		$onTimeNumber = $queryCount->andWhere(['<', 'uploadTime', $deadlineTime])->count();
		//超时提交
		$overtime = $cloneQueryCount->andWhere(['>', 'uploadTime', $deadlineTime])->count();
		//查询答题信息和全部提交

		if (!app()->request->isAjax) {

            $query->andWhere(['isCheck' => [0, 2], 'isUploadAnswer' => '1']);

            $pages->totalCount = $query->count();

            //未批改
            $answer = $query->offset($pages->getOffset())->limit($pages->getLimit())->all();
            //查询答案相关信息


            if (!empty($pages) && !empty($pages->params)) {
				$pages->params = ['type' => '1', 'classId' => $classId, 'classhworkid' => $classHomeworkId];
			}
		}
		if (app()->request->isAjax) {
			//未批改
			$unAnsweredQuery = $query->andWhere(['isCheck' => [0, 2]]);
			if ($checkTime == 2) {
				$unAnsweredQuery->andWhere(['<', 'uploadTime', $deadlineTime]);
			}
			if ($checkTime == 3) {
				$unAnsweredQuery->andWhere(['>', 'uploadTime', $deadlineTime]);
			}

			$pages->totalCount = (int)$unAnsweredQuery->count();
            $answer = $unAnsweredQuery->offset($pages->getOffset())->limit($pages->getLimit())->all();

            $pages->params = ['type' => '1', 'classhworkid' => $classHomeworkId, 'classId' => $classId];
			return $this->renderPartial('_tch_work_details_no_corrections_new',
				array(
					'answer' => $answer,
					'page' => $pages,
					'homeworkDetailsTeacher' => $homeWorkTeacher,
					'classId' => $classId
				));
		}
		return $this->render('classTchWorkDetails_new', [
			'noCorrections' => $noCorrections,
			'onTimeNumber' => $onTimeNumber,
			'overtime' => $overtime,
			'answer' => $answer,
			'homeworkDetailsTeacher' => $homeWorkTeacher,
			'page' => $pages,
			'classId' => $classId,
			'classhworkId' => $classHomeworkId,
			'homeworkRelAudio' => $homeworkRelAudio
		]);

	}

    /**
     * 作业作答情况 未提交学生列表的 选项卡内容
     * @param SeHomeworkRel $result 查询rel关系表
     * @param SeHomeworkTeacher $homeWorkTeacher 查询de详情信息
     * @param integer $classId 班级id
     * @param integer $classHomeworkId 班级作业id
     * @return string
     * @throws \yii\base\InvalidParamException
     */

	private function noSubmitJob(SeHomeworkRel $result, SeHomeworkTeacher $homeWorkTeacher, int $classId, int $classHomeworkId)
	{

		//教师作业 补充内容的语音
		$homeworkRelAudio = $result->audioUrl;
		//查询已答学生和 数
		$answerNumber = $result->getHomeworkAnswerInfo()->andWhere(['isUploadAnswer' => '1'])->count();
		$answerStuList = $result->getHomeworkAnswerInfo()->andWhere(['isUploadAnswer' => '1'])->all();
//查询班级学生数
		$studentClassQuery = SeClassMembers::find()->where(['classID' => $result->classID, 'identity' => '20403'])->andWhere(['>', 'userID', 0]);
		$studentMemberClone = clone $studentClassQuery;
        $studentMember = $studentMemberClone->count();
        $studentList = $studentClassQuery->all();
		//未答数
		$noStudentMember = $studentMember - $answerNumber;

		return $this->render('classTchWorkDetailsNoSubmitJob', ['homeworkDetailsTeacher' => $homeWorkTeacher, 'answerStuList' => $answerStuList, 'studentList' => $studentList, 'noStudentMember' => $noStudentMember, "classId" => $classId, 'classhworkId' => $classHomeworkId, 'homeworkRelAudio' => $homeworkRelAudio]);
	}

    /**
     * 作业作答情况 已批改选项卡 内容
     * @param SeHomeworkRel $result 查询rel关系表
     * @param integer $classHomeworkId 班级作业id
     * @param integer $deadlineTime 截止时间
     * @param integer $classId 班级id
     * @param SeHomeworkAnswerInfoQuery $cloneQuery clone的查询语句
     * @param Pagination $pages 分页数
     * @param integer $checkTime 检测时间
     * @param SeHomeworkTeacher $homeWorkTeacher 查询de详情信息
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	private function alreadyCorrections(SeHomeworkRel $result, int $classHomeworkId, int $deadlineTime, int $classId, SeHomeworkAnswerInfoQuery $cloneQuery, Pagination $pages, int $checkTime, SeHomeworkTeacher $homeWorkTeacher)
	{

		//教师作业 补充内容的语音
		$homeworkRelAudio = $result->audioUrl;
		//查询批改数
		$isCorrections = $result->getHomeworkAnswerInfo()->where(['isCheck' => '1', 'isUploadAnswer' => '1'])->count();
		//查询已批改的
		$markedQueryCount = SeHomeworkAnswerInfo::find()->where(['relId' => $classHomeworkId, 'isCheck' => '1', 'isUploadAnswer' => '1']);
		$cloneMarkedQueryCount = clone $markedQueryCount;
		//查询按时提交数
		$markedOnTimeNumber = $markedQueryCount->andWhere(['<', 'uploadTime', $deadlineTime])->count();
		//超时提交
		$markedOvertime = $cloneMarkedQueryCount->andWhere(['>', 'uploadTime', $deadlineTime])->count();

		if (!app()->request->isAjax) {
			//已批改
			$pagesCorrected = new Pagination();
			$pagesCorrected->pageSize = 10;
			$pagesCorrected->params = ['type' => '3', 'classId' => $classId, 'classhworkid' => $classHomeworkId];
            $cloneQuery->andWhere(['isCheck' => '1']);
            $pagesCorrected->totalCount = $cloneQuery->count();
            $answerCorrected = $cloneQuery->offset($pages->getOffset())->limit($pages->getLimit())->all();

        }
		if (app()->request->isAjax) {
			//已批改
			$pagesCorrected = new Pagination();
			$pagesCorrected->validatePage = false;
			$pagesCorrected->pageSize = 10;
			$answeredQuery = $cloneQuery->andWhere(['isCheck' => 1]);
			if ($checkTime == 2) {
				$answeredQuery->andWhere(['<', 'uploadTime', $deadlineTime]);
			}
			if ($checkTime == 3) {
				$answeredQuery->andWhere(['>', 'uploadTime', $deadlineTime]);
			}
            $pagesCorrected->totalCount = (int)$answeredQuery->count();
            $answerCorrected = $answeredQuery->offset($pagesCorrected->getOffset())->limit($pagesCorrected->getLimit())->all();

            $pagesCorrected->params = ['type' => 3, 'classhworkid' => $classHomeworkId, 'checkTime' => $checkTime, 'classId' => $classId];
			return $this->renderPartial('_tch_work_details_already_corrections_new', array('answerCorrected' => $answerCorrected, 'pagesCorrected' => $pagesCorrected, 'homeworkDetailsTeacher' => $homeWorkTeacher, "classId" => $classId));
		}
        /** @var SeHomeworkAnswerInfoQuery $answerCorrected */
        /** @var Pagination $pagesCorrected */
        return $this->render('classTchWorkDetailsAlreadyCorrections',
			[
				'markedOvertime' => $markedOvertime,
				'isCorrections' => $isCorrections,
				'markedOnTimeNumber' => $markedOnTimeNumber,
				'answerCorrected' => $answerCorrected,
				'homeworkDetailsTeacher' => $homeWorkTeacher,
				'pagesCorrected' => $pagesCorrected,
				"classId" => $classId,
				'classhworkId' => $classHomeworkId,
				'homeworkRelAudio' => $homeworkRelAudio
			]);
	}

    /**
     * 学生作业列表
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     */
	public function actionStudentHomework(int $classId)
	{
		$this->layout = '@app/views/layouts/lay_class_has_image_header';
		$proFirstime = microtime(true);
		$this->getClassModel($classId);
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$userId = user()->id;
		$subject = (int)app()->request->get('subjectId', 0);
		$getType = (int)app()->request->getParam('getType', '');
		$state = (int)app()->request->getParam('state', 3);
		$query = SeHomeworkRel::find()->active()->where(['classID' => $classId]);
		//查询作业类型 纸质 or 电子
		if ($getType != '') {
			$query->andWhere('homeworkId in (select id from se_homework_teacher where getType=:getType ) ', [':getType' => $getType]);
		}

		//查询科目
		if ($subject > 0) {
			$query->andWhere('homeworkId in (select id from se_homework_teacher where subjectId=:subjectId ) ', [':subjectId' => $subject]);
		}

		//已完成的
		if ($state == 2) {
			$query->andWhere('id in (select relId from se_homeworkAnswerInfo where isUploadAnswer=1 and studentID=:userId)', [':userId' => $userId]);
		}
		//未完成的
		if ($state == 3) {
			$query->andWhere('id not in (select relId from se_homeworkAnswerInfo where isUploadAnswer=1 and studentID=:userId)', [':userId' => $userId]);
		}
		$pages->totalCount = $query->count();
		$homework = $query->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		SeHomeworkRel::getHomeworkTeacherInfo($homework);
		SeHomeworkRel::existsStuIsComplete($homework);


		\Yii::info('学生作业列表 ' . (microtime(true) - $proFirstime), 'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('_homework_list_stu', ['homework' => $homework, 'classId' => $classId, 'pages' => $pages]);
		}
		return $this->render('classStuWorkList', ['homework' => $homework, 'classId' => $classId, 'pages' => $pages]);
	}

    /**
     * 纸质作业详情
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
	public function actionUpDetails(int $classId)
	{
		$this->getClassModel($classId);
		$homeworkId = (int)app()->request->getParam('homeworkId', 0);
		$homeworkRel = SeHomeworkRel::find()->where(['classID' => $classId, 'homeworkId' => $homeworkId])->select('id,audioUrl')->one();
		if (empty($homeworkRel)) {
			return $this->notFound('', '403');
		}
		//教师作业 补充内容的语音
		$homeworkRelAudio = $homeworkRel->audioUrl;

		$homeworkData = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkId);

		$imageList = $homeworkData->getHomeworkImages()->all();

		return $this->render('updetails', ['homeworkData' => $homeworkData, 'imageList' => $imageList, 'homeworkRelAudio' => $homeworkRelAudio]);

	}

    /**
     * 电子作业详情
     * @param integer $classId 班级ID
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     */
	public function actionOrganizeDetails(int $classId)
	{
		$this->getClassModel($classId);
		$homeworkId = (int)app()->request->getParam('homeworkId', 0);
		$homeworkRel = SeHomeworkRel::getAudioUrl($classId, $homeworkId);
		if (empty($homeworkRel)) {
			return $this->notFound('', '403');
		}
		//教师作业 补充内容的语音
		$homeworkRelAudio = $homeworkRel->audioUrl;
		//查询语音
		$homeworkData = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkId);;
		//根据homeworkID查询questionid
		$questionList = $homeworkData->getHomeworkQuestion()->select('questionId')->asArray()->all();
		//  查询题目的具体内容
		$homeworkResult = [];
        /** @var SeHomeworkQuestion $questionList */
        foreach ($questionList as $v) {
			//查询题详情
			$oneHomework = ShTestquestion::getTestQuestionDetails_Cache((int)$v['questionId']);
			$homeworkResult[] = $oneHomework;
		}
		return $this->render('organizedetails', ['homeworkData' => $homeworkData, 'homeworkResult' => $homeworkResult, 'homeworkRelAudio' => $homeworkRelAudio]);
	}


    /**
     * 纸质作业的批改
     * @param integer $classId 班级id
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionCorrectPicHom(int $classId)
	{
		$this->getClassModel($classId);
		$homeworkAnswerID = (int)app()->request->getQueryParam('homeworkAnswerID',0);
		$oneAnswerResult = SeHomeworkAnswerInfo::getHomeworkInfoDe($homeworkAnswerID);
//        根据relId查询当前作业所有提交了答案的学生
		//1已批，0未批
		$type = (int)app()->request->getQueryParam('type', 0);
		$homeworkAnswerResult = SeHomeworkAnswerInfo::getHomeworkInfoList($oneAnswerResult->relId, $type);
		$homeworkAnswerResultReverse = SeHomeworkAnswerInfo::getHomeworkInfoList($oneAnswerResult->relId, $type == 0 ? 1 : 0);
		if (!empty($homeworkAnswerResultReverse)) {
			$homeworkAnswerIdFirst = $homeworkAnswerResultReverse[0]['homeworkAnswerID'];
		} else {
			$homeworkAnswerIdFirst = $homeworkAnswerResult[0]['homeworkAnswerID'];
		}
//        查询当前学生提交的图片
		$imageResult = SeHomeworkAnswerDetailImage::getHomeworkAnswerDetailImageUrl($homeworkAnswerID);
		$imageArray = ArrayHelper::getColumn($imageResult, 'imageUrl');
		return $this->render('correctPicHom', [
			'oneAnswerResult' => $oneAnswerResult,
			'homeworkAnswerID' => $homeworkAnswerID,
			'homeworkAnswerIdFirst' => $homeworkAnswerIdFirst,
			'homeworkAnswerResult' => $homeworkAnswerResult,
			'imageArray' => $imageArray,
			'type' => $type,
			'classId' => $classId
		]);
	}

    /**
     * ajax批改纸质作业
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
	public function actionAjaxPicCorrect()
	{
		$jsonResult = new JsonMessage();
		$correctLevel = (int)app()->request->getBodyParam('correctLevel',0);
		$homeworkAnswerID = (int)app()->request->getBodyParam('homeworkAnswerID',0);

        $userId = (int)user()->id;

        $homeService = new HomeworkService();
		$result = $homeService->correctPaperHomework($userId,$homeworkAnswerID,$correctLevel);
		if($result->code == 200){
            $jsonResult->success = true;
        }
		return $this->renderJSON($jsonResult);

	}

    /**
     * 批改电子作业
     * @param integer $classId 班级id
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionCorrectOrgHom(int $classId)
	{
		$this->getClassModel($classId);
		$homeworkAnswerID = (int)app()->request->getQueryParam('homeworkAnswerID',0);
		//1已批，0未批
		$type = (int)app()->request->getQueryParam('type', 0);
		$oneAnswerResult = SeHomeworkAnswerInfo::getHomeworkInfoDe($homeworkAnswerID);
		// 根据relId查询当前作业所有提交了答案的学生
		$homeworkAnswerResult = SeHomeworkAnswerInfo::getHomeworkInfoList($oneAnswerResult->relId, $type);
		$homeworkAnswerResultReverse = SeHomeworkAnswerInfo::getHomeworkInfoList($oneAnswerResult->relId, $type == 0 ? 1 : 0);
		// 查询当前作业当前学生提交的图片
		$answerImageResult = SeHomeworkAnswerImage::find()->where(['homeworkAnswerID' => $homeworkAnswerID])->select('url')->asArray()->all();

		$answerImageArray = ArrayHelper::getColumn($answerImageResult, 'url');

		if (!empty($homeworkAnswerResultReverse)) {
			$homeworkAnswerIdFirst = $homeworkAnswerResultReverse[0]['homeworkAnswerID'];
		} else {
			$homeworkAnswerIdFirst = $homeworkAnswerResult[0]['homeworkAnswerID'];
		}
		//根据relId查询homeworkId
		$homeworkID = (int)SeHomeworkRel::getOneHomeworkRelDetails($oneAnswerResult->relId)->homeworkId;
		//根据homeworkID查询题目
		$homeworkResult = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkID);
		$questionArray = $this->findAll($homeworkID);

		return $this->render('correctOrgHom', [
			'homeworkAnswerResult' => $homeworkAnswerResult,
			'questionArray' => $questionArray,
			'homeworkID' => $homeworkID,
			'oneAnswerResult' => $oneAnswerResult,
			'answerImageArray' => $answerImageArray,
			'homeworkAnswerID' => $homeworkAnswerID,
			'homeworkAnswerIdFirst' => $homeworkAnswerIdFirst,
			'homeworkResult' => $homeworkResult,
			'type' => $type,
			'classId' => $classId
		]);
	}

    /**
     * ajax电子批改作业
     * @return string
     * @throws \yii\base\ExitException
     */
	public function actionAjaxOrgCorrect()
	{
		$jsonResult = new JsonMessage();
		$aid = (int)app()->request->getBodyParam('aid');
		$homeworkAnswerID = (int)app()->request->getBodyParam('homeworkAnswerID');
		$correctResult = (int)app()->request->getBodyParam('correctResult');

		$homeworkService = new HomeworkService();
        $result = $homeworkService->orgCorrectHomework($aid, $homeworkAnswerID, $correctResult);

        if($result->code == 200){
            $jsonResult->success = true;
        }
		return $this->renderJSON($jsonResult);
	}

    /**
     *批改作业更新主表的批改状态
     * @throws \yii\base\ExitException
     */
	public function actionUpdateHomCorrectLevel()
	{
		$jsonResult = new JsonMessage();
		$homeworkAnswerID = (int)app()->request->getBodyParam('homeworkAnswerID',0);
		$userId = (int)user()->id;
		$homeworkService = new HomeworkService();
		$result = $homeworkService->finishCorrectHomework($userId,$homeworkAnswerID);

		if($result->code == 200){
            $jsonResult->success = true;
        }
		return $this->renderJSON($jsonResult);
	}

	/**
	 * 客观题，主观题分组
	 * @param integer $homeworkID 作业id
	 * @return array
	 */
	public function findAll(int $homeworkID)
	{
		$questionResult = SeHomeworkQuestion::getHomeworkQuestionId($homeworkID);
		$questionArray = array();
		foreach ($questionResult as $v) {
			$partQuestionQuery = ShTestquestion::find()->where(['mainQusId' => (int)$v['questionId']]);
            //判断当前大题是否有小题
			if ($partQuestionQuery->exists()) {
				$partQuestionResult = $partQuestionQuery->select('id')->all();
				foreach ($partQuestionResult as $value) {
					$questionID = (int)$value->id;
					$shTestquestion = ShTestquestion::getTestQuestionDetails_Cache($questionID);
					if (!empty($shTestquestion)) {
						if ($shTestquestion->isMajorQuestion() && !$shTestquestion->isJudgeQuestion()) {
							$questionArray[] = $questionID;
						}
					}
				}
			} else {
				$questionID = (int)$v['questionId'];
				$shTestquestion = ShTestquestion::getTestQuestionDetails_Cache($questionID);
				if (!empty($shTestquestion)) {
					if ($shTestquestion->isMajorQuestion() && !$shTestquestion->isJudgeQuestion()) {
						$questionArray[] = $questionID;
					}
				}
			}
		}
		return $questionArray;
	}

    /**
     * 题目详情弹窗
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionGetQuestionContent()
	{
		$questionID = (int)app()->request->getBodyParam('questionID',0);
		//查询题目的具体内容
		$questionResult = ShTestquestion::getTestQuestionDetails_Cache($questionID);
		return $this->renderPartial('question_content', ['questionResult' => $questionResult]);
	}

    /**
     * 班级首页作业、答疑、文件统计
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
	public function actionClassStatistics(){

		$jsonResult = new JsonMessage();
		$classID = (int)app()->request->get('classID');
		$classModel = $this->getClassModel($classID);
		/** @var SeClass $classModel */
		$homeworkMember = $classModel->getCountHomeworkMember();
		$deadlineTimeHomework = $classModel->getCountDeadlineTimeHomeworkMember();
		$answerAllCount = $classModel->getAnswerAllCount();
		$resolvedAnswer = $classModel->getResolvedAnswer();
		$fileCount = $classModel->getFileCount();
		$readCount = $classModel->getReadCount();
		$readCount = isset($readCount) ? $readCount:0;
		$jsonResult -> homeworkMember = $homeworkMember;
		$jsonResult -> deadlineTimeHomework = $deadlineTimeHomework;
		$jsonResult -> answerAllCount = $answerAllCount;
		$jsonResult -> resolvedAnswer = $resolvedAnswer;
		$jsonResult -> fileCount = $fileCount;
		$jsonResult -> readCount = $readCount;

		return $this->renderJSON($jsonResult);
	}

}
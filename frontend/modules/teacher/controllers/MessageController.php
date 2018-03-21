<?php
declare(strict_types = 1);
namespace frontend\modules\teacher\controllers;

use common\models\dicmodels\GradeModel;
use common\models\JsonMessage;
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\pos\SeHomeworkPlatform;
use common\models\pos\SeHomeworkPlatformPushRecord;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use common\models\pos\SeUserinfo;
use common\models\sanhai\SeSchoolGrade;
use common\clients\MessageSearchService;
use frontend\components\TeacherBaseController;
use frontend\services\BaseService;
use frontend\services\pos\pos_ClassMembersService;
use frontend\services\pos\pos_MessageSentService;
use frontend\services\pos\pos_SchlHomMsgService;
use frontend\services\pos\pos_SchoolTeacherService;
use Yii;
use yii\data\Pagination;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/8/4
 * Time: 16:48
 */
class MessageController extends TeacherBaseController
{

    /**
     * 班海消息
     */
    const BAN_HAI_NOTICE = 507009;
    public $layout = 'lay_user';

    public function actionIndex()
    {
        return $this->redirect(['notice']);
    }

    /**
     * 学校通知--我发出的/未发送
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionMsgContact()
    {
        $this->layout = 'lay_user_new';
        $category = app()->request->getParam('category', 1);
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $creator = user()->id;

        $model = new pos_SchlHomMsgService();
        $modelList = $model->querySchlHomMsg('', $creator, $category, 1 + $pages->getPage(), $pages->pageSize, '');
        $pages->totalCount = (int)$modelList->countSize;
        if (app()->request->isAjax) {
            return $this->renderPartial('msg_contact', array('modelList' => $modelList->list, 'pages' => $pages, 'category' => $category));
        }
        $pages->params = ['category' => $category];

        return $this->render('msgContact', array('modelList' => $modelList->list, 'pages' => $pages, 'category' => $category));
    }

    /**
     * 学校通知--我收到的
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionReceiver()
    {
        $this->layout = 'lay_user_new';
        $category = app()->request->getParam('category', 2);
        $messageType = app()->request->getParam('messagetype', '');
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $receiverUserID = user()->id;
        $data = new pos_MessageSentService();
        $result = $data->readerQuerySentMessageInfo($receiverUserID, 507, $messageType, $pages->getPage() + 1, $pages->pageSize);
        $pages->totalCount = (int)$result->data->countSize;
        if (app()->request->isAjax) {
            return $this->renderPartial('_new_list_view', array('modelList' => $result->data, 'pages' => $pages, 'category' => $category));
        }
        $pages->params = ['category' => $category];

        return $this->render('msgContact', array('modelList' => $result->data, 'pages' => $pages, 'category' => $category));
    }

    /**
     * 我发出和未发的通知详情
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public function actionMsginfo()
    {
        $id = app()->request->get('id');
        $homMsg = new pos_SchlHomMsgService();
        $messageModel = $homMsg->querySchlHomMsg($id, user()->id, '', '', '', '');
        $messageInfo = $messageModel->list[0];
        $url = '';
        $img = $messageInfo->urls;

        if (!empty($img)) {
            $url = explode(',', $img);

        }
        return $this->renderPartial('_msgInfo_view', array('messageInfo' => $messageInfo, 'url' => $url));
    }

    /**
     * 我收到的通知详情
     * @return mixed
     * @throws \yii\base\InvalidParamException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionReceiverMsginfo()
    {
        $id = app()->request->get('id');
        $homMsg = new MessageSearchService();
        $messageModel = $homMsg->getMessageById($id);
        $messageInfo = $messageModel->data->schlHomMsg;
        $url = '';
        $img = $messageInfo->urls;

        if (!empty($img)) {
            $url = explode(',', $img);

        }
        //修改已读状态
        $data = new pos_MessageSentService();
        $data->isRead($id);

        return $this->renderPartial('_receivermsgInfo_view', array('messageInfo' => $messageInfo, 'url' => $url));
    }

    /**
     * 发布通知
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionAddContactView()
    {
        $this->layout = 'lay_user_new';
        $schoolClassArr = [];
        $teacherID = user()->id;
        $teacher = new pos_SchoolTeacherService();
        $schoolClass = $teacher->searchTeacherClass($teacherID);
        foreach ($schoolClass->classList as $key => $val) {
            if ($val->identity == '20401' || $val->identity == '20402') {
                $schoolClassArr[] = $val;
            }
        }
        return $this->render('addcontactview', array('schoolClass' => $schoolClassArr));
    }

    /**
     * 添加通知
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionAddContact()
    {
        $jsonResult = new JsonMessage();
        $messageInfo = app()->request->post('message');
        $title = $messageInfo['title'];
        $classId = $messageInfo['classId'];
        $stuAll = $messageInfo['stuAll'];
        $stuId = array();
        if ($stuAll == 0) {
            $stuId = $messageInfo['stuId'];
        }
        if ($stuAll == 1) {
            $class = new pos_ClassMembersService();
            $studentList = $class->loadRegisteredMembers($classId, 1, '');
            foreach ($studentList as $stu) {
                $stuId[] = $stu->userID;
            }
        }
        $student = array();
        $receiverJson = null;
        if (!empty($stuId)) {
            foreach ($stuId as $item) {
                $student[] = ['userId' => $item];
            }
            $receiverJson = json_encode($student);
        }
        $receiverType = $messageInfo['receiverType'];
        $txt = $messageInfo['txt'];
        if (isset($messageInfo['img'])) {

            $img = $messageInfo['img'];
        }

        $userId = user()->id;
        $url = '';
        if (!empty($img)) {
            $url = implode(',', $img);
        }
        if (!empty($receiverType)) {
            $receiverType = implode(',', $receiverType);
        }

        if ($stuAll == 0 && $receiverJson == "") {
            $jsonResult->message = '请选择学生';
            return $this->renderJSON($jsonResult);
        }
        $teachers = SeClassMembers::find()->where(['classID' => $classId])->andWhere(['in', 'identity', [20401, 20402]])->select('userID')->asArray()->all();
        foreach ($teachers as $key => $teacher) {
            $teachers[$key] = $teacher['userID'];
        }
        if (!in_array($userId, $teachers)) {
            $jsonResult->message = '只能发送所教班级';
            return $this->renderJSON($jsonResult);
        }
        $createSchlHomMsg = new MessageSearchService();
        $addmodel = $createSchlHomMsg->createSchlHomMsg($title, $classId, $stuAll, '', $receiverJson, $receiverType, 2, '', '', '', $txt, $userId, 3, '', '', $url, '');
        if ($addmodel->resCode == BaseService::successCode) {
            if ($messageInfo['type'] == 'send') {
                $result = $this->sendHomMsg($addmodel->data->messageId);
                if (!isset($result)) {
                    $jsonResult->success = false;
                    return $this->renderJSON($jsonResult);
                }
            }
            $jsonResult->success = true;
            return $this->renderJSON($jsonResult);
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '添加失败';
            return $this->renderJSON($jsonResult);
        }
    }


    /**
     * 修改保存的通知
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionModifyContact()
    {
        $jsonResult = new JsonMessage();
        $messageInfo = app()->request->post('message');
        $id = $messageInfo['msgid'];
        $title = $messageInfo['title'];
        $classId = $messageInfo['classId'];
        $stuAll = $messageInfo['stuAll'];
        $stuId = array();
        if ($stuAll == 0) {
            $stuId = $messageInfo['stuId'];
        }
        if ($stuAll == 1) {
            $class = new pos_ClassMembersService();
            $studentList = $class->loadRegisteredMembers($classId, 1, '');
            foreach ($studentList as $stu) {
                $stuId[] = $stu->userID;
            }
        }
        $student = array();
        $receiverJson = null;
        if (!empty($stuId)) {
            foreach ($stuId as $item) {
                $student[] = ['userId' => $item];
            }
            $receiverJson = json_encode($student);
        }
        $receiverType = $messageInfo['receiverType'];
        $txt = $messageInfo['txt'];
        if (isset($messageInfo['img'])) {

            $img = $messageInfo['img'];
        }
        $url = '';
        if (!empty($img)) {
            $url = implode(',', $img);
        }
        $receiverType = implode(',', $receiverType);

        if ($stuAll == 0 && $receiverJson == "") {
            $jsonResult->message = '请选择学生';
            return $this->renderJSON($jsonResult);
        }
        $modifySchlHomMsg = new MessageSearchService();
        $modifymodel = $modifySchlHomMsg->updateSchlHomMsg($id, $title, '', $classId, $stuAll, $receiverJson, $receiverType, 2, '', '', '', $txt, '', '', '', $url, '');
        if ($modifymodel->resCode == BaseService::successCode) {
            if ($messageInfo['type'] == 'send_') {
                $result = $this->sendHomMsg($id);
                if (!isset($result)) {
                    $jsonResult->success = false;
                    return $this->renderJSON($jsonResult);
                }
            }
            $jsonResult->success = true;
            return $this->renderJSON($jsonResult);
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '修改失败';
            return $this->renderJSON($jsonResult);
        }
    }

    /**
     * 修改站内信页面
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionEditContact()
    {
        $this->layout = 'lay_user_new';
        $id = app()->request->getParam('id');
        $schlHomMsg = new pos_SchlHomMsgService();
        $editmodel = $schlHomMsg->querySchlHomMsg($id, '', '', '', '', '');
        $modelList = $editmodel->list[0];
        $receivers = $modelList->receivers;
        $receiverType = $modelList->receiverType;
        $receiverType = explode(',', $receiverType);
        $son = '';
        if (in_array(1, $receiverType)) {
            $son = 1;
        }
        $parent = '';
        if (in_array(2, $receiverType)) {
            $parent = 2;
        }
        $url = $modelList->urls;
        if (!empty($url)) {

            $url = explode(',', $url);
        }
        $teacherID = user()->id;
        $teacher = new pos_SchoolTeacherService();
        $schoolClassArr = [];
        $schoolClass = $teacher->searchTeacherClass($teacherID);
        foreach ($schoolClass->classList as $key => $val) {
            if ($val->identity == '20401' || $val->identity == '20402') {
                $schoolClassArr[] = $val;
            }
        }
        return $this->render('modifycontactview', array('modelList' => $modelList, 'schoolClass' => $schoolClassArr, 'url' => $url, 'son' => $son, 'parent' => $parent, 'receivers' => $receivers));
    }

    /**
     * 删除信息
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionDelHomMsg()
    {
        $id = app()->request->getParam('id', 0);
        $schlHomMsg = new pos_SchlHomMsgService();
        $del = $schlHomMsg->delSchlHomMsg($id);
        $jsonResult = new JsonMessage();
        if ($del->resCode == BaseService::successCode) {
            $jsonResult->success = true;
            return $this->renderJSON($jsonResult);
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '删除失败';
            return $this->renderJSON($jsonResult);
        }
    }

    /**
     * 发送通知
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionSendHomMsg()
    {
        $id = app()->request->getParam('id', 0);

        $jsonResult = new JsonMessage();
        $result = $this->sendHomMsg($id);
        if (isset($result)) {
            $jsonResult->success = true;
        } else {
            $jsonResult->success = false;
            $jsonResult->data = '发送错误';
        }
        return $this->renderJSON($jsonResult);

    }

    /**
     * 发送通知
     * @param $id string 通知id
     * @return bool
     */
    protected function sendHomMsg($id)
    {
        $schlHomMsg = new pos_SchlHomMsgService();
        $send = $schlHomMsg->sendSchlHomMsg($id);
        if ($send == null) {
            return false;
        }
        return true;
    }

    /**
     * 获取班级和班级全部同学
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionNewGetClass()
    {
        $classId = app()->request->getParam('classId', 0);
        $class = new pos_ClassMembersService();
        $studentList = $class->loadRegisteredMembers($classId, 1, '');
        return $this->renderPartial('_new_getClass_view', ['studentList' => $studentList]);
    }

    /**
     * 我的通知（删除一条消息）
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionDeleteNotice()
    {
        $jsonResult = new JsonMessage();
        $messageId = app()->request->getParam('id');
        $data = new pos_MessageSentService();
        $result = $data->readerMessageDelet($messageId);
        if ($result->resCode == BaseService::successCode) {
            $jsonResult->success = true;
            $jsonResult->data = $result->data;
            $jsonResult->message = '删除成功';
        } else {
            $jsonResult->success = false;
            $jsonResult->message = '删除失败';
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 系统消息列表
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\InvalidParamException
     */
    public function actionNotice()
    {
        $this->layout = 'lay_user_new';
        $proFirsTime = microtime(true);
        $userId = user()->id;
        $messageType = self::BAN_HAI_NOTICE;
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $data = new pos_MessageSentService();
        $result = $data->readerQuerySentMessageInfo($userId, 508, $messageType, $pages->getPage() + 1, $pages->pageSize);
        if (!empty($result)) {
            $pages->totalCount = (int)$result->data->countSize;
        }
        \Yii::info('教师系统消息 ' . (microtime(true) - $proFirsTime), 'service');
        if (app()->request->isAjax) {
            return $this->renderPartial('_notice_list', array('model' => $result->data, 'pages' => $pages));

        }
        return $this->render('notice', array('model' => $result->data, 'pages' => $pages));
    }

    /**
     * 精品作业
     * @return string
     */
    public function actionQualityWork()
    {
        $this->layout = 'lay_user_new';
        $proFirsTime = microtime(true);
        $userId = (int)user()->id;

        //老师所教学科
        $teacherSubject = loginUser()->subjectID;
        $teacherDepartment = loginUser()->department;
        //默认消息类型
        $defaultMessage = SeHomeworkPlatformPushRecord::BASIC_HOMEWORK;

        if($teacherSubject == GradeModel::CHINESE_SUBJECT && $teacherDepartment==GradeModel::PRIMARY_SCHOOL) {
            $defaultMessage = SeHomeworkTeacher::READ_HOMEWORK;
        }

        if($teacherSubject == GradeModel::ENGLISH_SUBJECT && $teacherDepartment==GradeModel::PRIMARY_SCHOOL){
            $defaultMessage = SeHomeworkTeacher::LISTEN_HOMEWORK;
        }

        $homeworkType = app()->request->getParam('homeworkType',$defaultMessage);

        if($homeworkType == SeHomeworkTeacher::LISTEN_HOMEWORK){
            $homeworkType = [SeHomeworkTeacher::LISTEN_HOMEWORK,SeHomeworkTeacher::SPOKEN_HOMEWORK];
        }

        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;

        $time = strtotime(date('Y-m-d', strtotime('+1 day'))) * 1000;
        $hour = date('H:i',time());
        $tenHalf = '10:30';
        if($hour < $tenHalf){
            $time = strtotime(date('Y-m-d', time())) * 1000;
        }

        //获取当前老师所教年级
        $gradeInfoArr = SeClassMembers::getGradeInfoByUserId($userId);

        $defaultGradeId = key($gradeInfoArr);
        $gradeId = app()->request->get('gradeId', $defaultGradeId);

        $qualityHomeworkArr = [];
        $userInfo = SeUserinfo::getUserDetails($userId);
        if (!empty($userInfo)) {
            //查询用户所教的科目和版本
            $subjectId = $userInfo->subjectID;
            $version = $userInfo->textbookVersion;

            $query = new Query();
            $query->select("a.homeworkId,b.name,a.pushTime")
                ->from("se_homework_platform_push_record a")
                ->leftJoin("se_homework_platform b", 'a.homeworkId = b.id')
                ->where("a.subjectId = :subjectId and a.versionId = :versionId", [':subjectId' => $subjectId, ':versionId' => $version])
                ->andWhere(['<', 'a.pushTime', $time])
                ->andWhere(['a.homeworkType'=>$homeworkType]);

            if (!empty($gradeId)) {
                $query->andWhere(['a.gradeId' => $gradeId]);
            }
            $pages->totalCount = $query->count('*', Yii::$app->get('db_school'));
            $qualityHomeworkArr = $query->orderBy('a.pushTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->createCommand(Yii::$app->get('db_school'))->queryAll();
        }

        \Yii::info('教师系统消息 ' . (microtime(true) - $proFirsTime), 'service');
        if (app()->request->isAjax) {
            return $this->renderPartial('_homework_list', array('model' => $qualityHomeworkArr, 'pages' => $pages));
        }
        return $this->render('qualityWork', array('model' => $qualityHomeworkArr, 'gradeInfoArr' => $gradeInfoArr, 'pages' => $pages, 'gradeId' => $gradeId, 'homeworkType' => $homeworkType));
    }


    //修改是否已读状态、跳转相应的页面
    public function actionIsRead()
    {
        $messageID = app()->request->getParam('messageID');
        $messageType = app()->request->getParam('messageType');
        $objectID = app()->request->getParam('objectID');

        //修改已读状态
        $data = new pos_MessageSentService();
        $result = $data->isRead($messageID);

        //跳转页面
        switch ($messageType) {
            case 507003: //通知教师批改作业（学生提交作业）
                $classInfo = SeHomeworkRel::find()->where(['id' => $objectID])->one();
                if ($classInfo) {
                    $classId = $classInfo->classID;
                } else {
                    $this->notFound('该作业已被删除！');
                }
                return $this->redirect(url('/class/work-detail', array('classhworkid' => $objectID, 'classId' => $classId)));
                break;
            case 507004: //通知教师判卷（提交考试答案）
                return $this->redirect(url('teacher/exam/subject-details', array('examSubID' => $objectID)));
                break;
            case 507403: //试题推送消息
                return $this->redirect(url('teacher/managepaper/topic-push-result', array('questionTeamID' => $objectID)));
                break;
            case 507404: //完善试卷
                return $this->redirect(url('teacher/exam/subject-details', array('examSubID' => $objectID)));
                break;
            case 507005: //查看推送作业
                return $this->redirect(url('teacher/managetask/pushed-library-details', array('homeworkID' => $objectID)));
                break;
            case 507009: //班海消息
                $jsonResult = new JsonMessage();
                if (app()->request->isAjax) {
                    if ($result) {
                        $jsonResult->success = true;
                    } else {
                        $jsonResult->message = '标记失败';
                    }
                }
                return $this->renderJSON($jsonResult);
            default:
        }

    }

}
<?php
namespace frontend\modules\student\controllers;

use common\models\JsonMessage;
use common\clients\MessageSearchService;
use frontend\components\StudentBaseController;
use frontend\services\BaseService;
use frontend\services\pos\pos_MessageSentService;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: wenjianhua
 * Date: 2014/10/14
 * Time: 16:48
 */
class MessageController extends StudentBaseController
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


	public function actionIndex()
	{
		return $this->redirect(['notice']);
	}


    /**
     * 我的通知
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\InvalidParamException
     */
	public function actionNotice()
	{
		$classId = loginUser()->getFirstClass();
		$userId = user()->id;
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$data = new pos_MessageSentService();
		$result = $data->readerQuerySentMessageInfo($userId, '507', '507201', $pages->getPage() + 1, $pages->pageSize);

		$pages->totalCount = (int)$result->data->countSize;
		if (app()->request->isAjax) {
			return $this->renderPartial('_notice_list', array('model' => $result->data, 'pages' => $pages, 'classId' => $classId));

		}
		return $this->render('notice', array('model' => $result->data, 'pages' => $pages, 'classId' => $classId));
	}


    /**
     * 系统消息列表
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\InvalidParamException
     */
	public function actionSysMsg()
	{
		$classId = loginUser()->getFirstClass();
		$messageType = app()->request->getQueryParam('messageType', null);
		$userId = user()->id;
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$data = new pos_MessageSentService();
		$result = $data->readerQuerySentMessageInfo($userId, '508', $messageType, $pages->getPage() + 1, $pages->pageSize);

		$pages->totalCount = (int)$result->data->countSize;
		if (app()->request->isAjax) {
			return $this->renderPartial('_sys_msg_list', array('model' => $result->data, 'pages' => $pages, 'classId' => $classId));

		}
		return $this->render('sysmsg', array('model' => $result->data, 'pages' => $pages, 'classId' => $classId));
	}


    /**
     * 我的通知（删除一条消息）
     * @return string
     * @throws \Camcima\Exception\InvalidParameterException
     * @throws \yii\base\ExitException
     */
	public function actionDeleteNotice()
	{

		$jsonResult = new JsonMessage();
		$messageId = app()->request->getQueryParam('messageId');
		$data = new pos_MessageSentService();
		$result = $data->readerMessageDelet($messageId);
		if ($result->resCode == BaseService::successCode) {
			$jsonResult->success = true;
			$jsonResult->data = $result->data;
		} else {
			$jsonResult->success = false;
			$jsonResult->message = '删除失败';
		}
		return $this->renderJSON($jsonResult);

	}

    /**
     * 学校通知
     * @return mixed
     * @throws \yii\base\InvalidParamException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
	public function actionReceiverMsginfo()
	{
		$id = app()->request->get('id');
		$homMsg = new MessageSearchService();
		$messageModel = $homMsg->getMessageById($id);
		if ($messageModel->resCode == '000000') {
			$messageInfo = $messageModel->data->schlHomMsg;
			$url = '';
			$img = $messageInfo->urls;
			if (!empty($img)) {
				$url = explode(',', $img);
			}
			//修改已读状态
			$data = new pos_MessageSentService();
			$data->isRead($id);
		} else {
			$messageInfo = '';
			$url = '';
		}

		return $this->renderPartial('_noticeInfo_view', array('messageInfo' => $messageInfo, 'url' => $url));
	}


	//修改是否已读状态、跳转相应的页面
	public function actionIsRead()
	{
		$classId = loginUser()->getFirstClass();
		$messageId = app()->request->getQueryParam('messageID');
		$messageType = app()->request->getQueryParam('messageType');
		$objectId = app()->request->getQueryParam('objectID');

		//修改已读状态
		$data = new pos_MessageSentService();
		$result = $data->isRead($messageId);

		//跳转页面
		switch ($messageType) {
			//通知消息
			case 507201:    //家校联系消息（直接在消息列表显示全部）
				return $this->redirect(url('student/message/notice'));
				break;
			case 507001:    //作业消息
				return $this->redirect(url('classes/managetask/details', array('classId' => $classId, 'relId' => $objectId)));
				break;
			case 507402:    //考试通知消息
				return $this->redirect(url('student/exam/test-detail', array('examID' => $objectId)));
				break;
			case 507202:    //个人总评消息
				return $this->redirect(url('student/exam/test-detail', array('examID' => $objectId)));
				break;

			//系统消息
			case 507203:    //单科(科目)总评消息
				return $this->redirect(url('student/exam/test-detail', array('examID' => $objectId)));
				break;
			case 507204:    //本班总评消息
				return $this->redirect(url('student/exam/test-detail', array('examID' => $objectId)));
				break;
			case 507205:    //各科成绩消息
				return $this->redirect(url('student/exam/test-detail', array('examID' => $objectId)));
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
<?php
declare(strict_types=1);
namespace frontend\controllers;

use common\models\JsonMessage;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeQuestionResult;
use common\models\pos\SeSameQuestion;
use common\models\pos\SeUserinfo;
use common\clients\JfManageService;
use common\clients\KehaiUserService;
use frontend\components\BaseAuthController;


/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/26
 * Time: 11:12
 * 答疑公共页
 */
class AnswerController extends BaseAuthController
{
    /**
     * 回答问题
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
	public function actionResultQuestion()
	{
		$jsonResult = new JsonMessage();

		$userId = user()->id;
		$aqid = app()->request->post('aqid', 0);
		$answer = app()->request->post('answer', '');
		$imgPath = '';
		if(empty($answer)){
			$jsonResult->success = false;
			$jsonResult->message = '回答内容不能为空！';
		}else{
			$questionResultModel = new SeQuestionResult;
			//调用 保存回答
			$saveResult = $questionResultModel->addResultQuestion($userId,(int)$aqid,(string)$answer,(string)$imgPath);

			if ($saveResult) {
//             回复答疑增加积分
				$jfHelper=new JfManageService;
				$jfHelper->addJfXuemi('pos-request',$userId);
				$jsonResult->success = true;
				$jsonResult->message = '回答成功！';
			} else {

				$jsonResult->success = false;
				$jsonResult->message = '回答失败！';
			}
		}
		return $this->renderJSON($jsonResult);
	}

    /**
     *同问问题
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
	public function actionSameQuestion()
	{
		$jsonResult = new JsonMessage();
		$aqid = (int)app()->request->post('aqid', 0);
		$userId = (int)user()->id;

		$sameQuestionModel = new SeSameQuestion();
		//检查该用户是否同问过
		$selSame = $sameQuestionModel->checkSame($aqid, $userId);

		if(!empty($selSame)){
			$jsonResult->success = false;
			$jsonResult->message = '您已同问过该问题！';
		}else{
			//保存同问
			$saveSame = $sameQuestionModel->addSame($aqid,$userId);
			if ($saveSame) {
				$jfHelper=new JfManageService;
				$jfHelper->addJfXuemi('pos-identical',$userId);
				$jsonResult->success = true;
				$jsonResult->message = '同问成功！';
			} else {
				$jsonResult->success = false;
				$jsonResult->message = '同问失败！';
			}
		}
		return $this->renderJSON($jsonResult);
	}

    /**
     * 采用答案
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
	public function actionUseTheAnswer()
	{
		$jsonResult = new JsonMessage();
		$resultId = (int)app()->request->post('resultid');//获取回答的id

		$questionResultModel = new SeQuestionResult();

		//查询单个答案
		$resultDetails = $questionResultModel->getQuestionResultRelDetails($resultId);

		//答疑id
		$aqId = $resultDetails->rel_aqID;
		//回答人的userId
		$resultCreatorId = $resultDetails->creatorID;

		//权限，查询回答列表，防止一个答疑有多个最佳答案。
		$checkReply = $questionResultModel->checkQuestionResult((int)$aqId);
		if (empty($resultId)) {
			$jsonResult->success = false;
			$jsonResult->message = '请正确采用答案！';
		} elseif ($checkReply) {
			$jsonResult->success = false;
			$jsonResult->message = '已有采用过最佳答案！';
		} elseif (empty($resultDetails)) {
			$jsonResult->success = false;
			$jsonResult->message = '答案不存在，请刷新！';
		} else {

			//修改答案列表 设置最佳答案
			$useAnswer = $questionResultModel->updateUseAnswer($resultId);

			if ($useAnswer) {
				//采用成功，给回答者增加积分
				$jfHelper = new JfManageService;
				$jfHelper->addJfXuemi('pos-accept', $resultCreatorId);
				$jsonResult->success = true;
				$jsonResult->message = '采用成功！';
			} else {
				$jsonResult->success = false;
				$jsonResult->message = '采用失败！';
			}
		}
		return $this->renderJSON($jsonResult);
	}

    /**
     * 答疑详情
     * @throws \yii\base\InvalidParamException
     */
    public function actionAnswerDetail()
    {
        $aqId = app()->request->post('aqid', 0);
	    $answerModel = new SeAnswerQuestion();
	    $questionDetail = $answerModel->selectAnswerOne((int)$aqId);
        return $this->renderPartial('//publicView/answer/_answer_list_all', array('val' => $questionDetail));
    }

    /**
     * 答案列表
     * @return string
     * @throws \yii\base\InvalidParamException
     */

	public function actionReplyList(){
		$pages = 3;
		$aqId = (int)app()->request->post('apid');
		$questionResultModel = new SeQuestionResult();
		$answerModel = new SeAnswerQuestion();
		//查询回答列表
		$replyList = $questionResultModel->selectQuestionResultList($aqId,$pages);
//查询答案总数
		$replySum = $questionResultModel::getAnswerResultSum($aqId);

		//查询答疑单条问题
		$questionDetail = $answerModel->selectAnswerOne($aqId);
		return $this->renderPartial('//publicView/answer/_reply_list', ['model'=>$replyList,'question'=>$questionDetail, 'replySum'=>$replySum]);
	}

    /**
     * 获取用户信息
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionShowPerMsg(){
          $userID=app()->request->getBodyParam('userID');
          $source=app()->request->getBodyParam('source');
       if($source==1){
            $data=KehaiUserService::model()->getUserData($userID);
            if(!empty($data->list)) {
                return $this->renderPartial('//publicView/answer/kehai_per_msg', ['data' => $data]);
            }
        }
       $data= SeUserinfo::find()->where(['userID' => $userID])->one();
       return $this->renderPartial('//publicView/answer/show_per_msg',['data'=>$data,'userID'=>$userID]);


    }

}
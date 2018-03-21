<?php
declare(strict_types = 1);
namespace frontend\controllers;

use common\models\JsonMessage;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeQuestionResult;
use common\models\pos\SeSameQuestion;
use common\models\pos\SeUserinfo;
use common\clients\JfManageService;
use common\clients\KehaiUserService;
use frontend\components\BaseAuthController;
use frontend\components\helper\PinYinHelper;
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\StringHelper;


/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/26
 * Time: 11:12
 * 答疑公共页
 */

/**
 * Class AnswernewController
 * @package frontend\controllers
 */
class AnswernewController extends BaseAuthController
{

    /**
     * 用于打开一个回答的片段
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionResponseOpen()
    {
        $aqId = app()->request->get('aqId');
        return $this->renderPartial('//publicView/answer/_new_answer_question_response', ['aqId' => $aqId]);
    }

    /**
     * 回答问题
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionResultQuestion()
    {
        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $aqid = app()->request->post('aqid');//获取问题id
        $creatorID = app()->request->post('creatorID');//获取问题作者
        $answer = app()->request->post('answer');//获取回答内容
        $imgPath = app()->request->post('img_val');//获取图片路径
        //权限 查询内容是否为空
        if ($userId == $creatorID) {
            $jsonResult->success = false;
            $jsonResult->message = '您不能回答自己的问题！';
        } elseif (empty($answer) && empty($imgPath)) {
            $jsonResult->success = false;
            $jsonResult->message = '回答内容不能为空！';
        } else {
            $questionResultModel = new SeQuestionResult;
            //调用 保存回答
            $saveResult = $questionResultModel->addResultQuestion($userId, (int)$aqid, (string)$answer, (string)$imgPath);
            if ($saveResult) {
//             回复答疑增加积分
                $jfHelper = new JfManageService;
                $jfHelper->addJfXuemi('pos-request', $userId);
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
     * 同问问题
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionSameQuestion()
    {
        $jsonResult = new JsonMessage();
        $aqid = (int)app()->request->get('aqid', 0);//获取问题id
        $userId = (int)user()->id;

        $sameQuestionModel = new SeSameQuestion();
        //检查该用户是否同问过，同问过返回false，不予同问。
        $selSame = $sameQuestionModel->checkSame($aqid, $userId);

        if (!empty($selSame)) {
            $jsonResult->success = false;
            $jsonResult->message = '您已同问过该问题！';
        } else {
            //保存同问
            $saveSame = $sameQuestionModel->addSame($aqid, $userId);
            if ($saveSame) {
                $jfHelper = new JfManageService;
                $jfHelper->addJfXuemi('pos-identical', $userId);
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
     * 查询同问头像
     * 用户点击同问时，用来替换页面原同问头像列表，增加同问者头像
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionAlsoAskHead()
    {
        $aqId = app()->request->get('aqId');
        $alsoAsk = SeSameQuestion::selectSameQuestionAll((int)$aqId);
        return $this->renderPartial('//publicView/answer/_new_answer_question_alsoask_head', array('alsoAsk' => $alsoAsk));
    }

    /**
     * 采用答案
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
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
     * (目前用于 采用最佳答案 时 刷新 答疑列表的单条答疑数据)
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionAnswerDetail()
    {
        $aqId = app()->request->post('aqid', 0);
        $answerModel = new SeAnswerQuestion();
        $questionDetail = $answerModel->selectAnswerOne((int)$aqId);
        return $this->renderPartial('//publicView/answer/_new_answer_question_list_details', array('val' => $questionDetail));
    }

    /**
     * 答案列表
     * @return string
     * @throws \yii\base\InvalidParamException
     */

    public function actionReplyList()
    {
        $pages = 3;
        $aqId = (int)app()->request->post('apid');
        $questionResultModel = new SeQuestionResult();
        $answerModel = new SeAnswerQuestion();
        //查询回答列表
        $replyList = $questionResultModel->selectQuestionResultList($aqId, $pages);
        //查询答案总数
        $replySum = $questionResultModel::getAnswerResultSum($aqId);

        //查询答疑单条问题
        $questionDetail = $answerModel->selectAnswerOne($aqId);

        return $this->renderPartial('//publicView/answer/_new_answer_question_list_reply_list', ['model' => $replyList, 'question' => $questionDetail, 'replySum' => $replySum]);
    }

    /**
     * 获取用户信息
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionShowPerMsg()
    {
        $jsonResult = new JsonMessage();
        $userID = (int)app()->request->get('userID');
        $source = app()->request->get('source');
        //当source是0的时候是 班海的注册用户，当为1时是科海注册用户
        if ($source == 0) {
            $data = SeUserinfo::getUserDetails($userID);
            $schoolName = WebDataCache::getSchoolNameBySchoolId($data->schoolID);
            if ($data->type == 1) {
                $subjectName = WebDataCache::getDictionaryName($data->subjectID);
                //拼写js需要的json串 教师的
                $jsonResult->data = ['QRCode' => url('qrcode/gr/', ['id' => $data->userID, 'source' => $source]), 'headImg' => $data->headImgUrl, 'name' => $data->trueName, 'identity' => '教师', 'courseName' => StringHelper::truncate($subjectName, 1,'','utf-8'), 'courseClass' => PinYinHelper::firstChineseToPin($subjectName), 'stu_school' => '就职于&nbsp;&nbsp;' . $schoolName];
                $jsonResult->success = true;
            } else {
                //学生的
                $jsonResult->data = ['QRCode' => url('qrcode/gr/', ['id' => $data->userID, 'source' => $source]), 'headImg' => $data->headImgUrl, 'name' => $data->trueName, 'identity' => '学生', 'courseName' => '', 'courseClass' => '', 'stu_school' => '就读于&nbsp;&nbsp;' . $schoolName];
                $jsonResult->success = true;
            }

        } elseif ($source == 1) {
            //科海用户的信息，
            $data = KehaiUserService::model()->getUserData($userID);
//学生的
            if (empty($data->list)) {
                $jsonResult->data = [];
                $jsonResult->success = false;
            } else {
                $jsonResult->data = ['QRCode' => url('qrcode/gr/', ['id' => $data->userId, 'source' => $source]), 'name' => $data->nickName, 'identity' => '大学生', 'courseName' => '', 'courseClass' => '', 'stu_school' => '就读于&nbsp;&nbsp;' . $data->school];
                $jsonResult->success = true;
            }
        }
        return $this->renderJSON($jsonResult);

    }

    /**
     * 查询用户提交答疑次数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionCheckAnswer()
    {

        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $model = new SeAnswerQuestion();

        $checkAnswer = $model->checkAnswerNum($userId);
        if ($checkAnswer < 2) {
            $jsonResult->success = true;

        } else {
            $jsonResult->success = false;
            $jsonResult->message = '您今天已经提问过2次问题，请明天再提问！';
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 查询个人的答疑统计 提问 回答 被采纳数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionPersonageAnswerStatistics()
    {

        $userId = user()->id;

        $memberData = [];
        //个人提问总数
        $questionMember = SeAnswerQuestion::getUserAskQuestion($userId);
        //个人回答总数
        $questionResultMember = SeQuestionResult::getUserAnswerQuestion($userId);
        //被采纳数
        $questionResultIsUseMember = SeQuestionResult::getUserRelyQuestion($userId);
        $memberData[] = $questionMember;
        $memberData[] = $questionResultMember;
        $memberData[] = $questionResultIsUseMember;
        return $this->renderJSON($memberData);
    }

    /**
     * 查询提问数各科的提问数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionStatisticalGraph()
    {

        $userId = user()->id;
        $subjectList = SeAnswerQuestion::getStatisticalGraph($userId);
        $subList = [];
        $k = 0;
        foreach ($subjectList as $key => $value) {
            $subName = SubjectModel::model()->getName((int)$value['subjectID']);
            if (!empty($subName)) {
                $subList[$k]['name'] = $subName;
                $subList[$k]['value'] = $value['mem'];
                $k++;
            }
        }
        return $this->renderJSON($subList);


    }

    /**
     * 查询回答过的问题 各科数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionReplyStatSubject()
    {
        $userId = user()->id;
        $subjectList = SeAnswerQuestion::getReplyStatSubject($userId);

        $subList = [];
        $k = 0;
        foreach ($subjectList as $key => $value) {
            $subName = SubjectModel::model()->getName((int)$value['subjectID']);
            if (!empty($subName)) {
                $subList[$k]['name'] = $subName;
                $subList[$k]['value'] = $value['num'];
                $k++;
            }
        }
        return $this->renderJSON($subList);
    }

    /**
     * 查询回答过被采用的回答问题 各科数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionReplyIsUseSubject()
    {
        $userId = user()->id;
        $subjectList = SeAnswerQuestion::getReplyIsUseSubject($userId);

        $subList = [];
        $k = 0;
        foreach ($subjectList as $key => $value) {
            $subName = SubjectModel::model()->getName((int)$value['subjectID']);
            if (!empty($subName)) {
                $subList[$k]['name'] = $subName;
                $subList[$k]['value'] = $value['mem'];
                $k++;
            }
        }
        return $this->renderJSON($subList);
    }

    /**
     * 查询同问数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionAlsoAsk()
    {
        $aqId = app()->request->get('aqId');
        $data = SeSameQuestion::AlsoAsk((int)$aqId);
        return $this->renderJSON($data);
    }

    /**
     * 查询答案数
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionReplyNumber()
    {
        $aqId = app()->request->get('aqId');
        $data = SeQuestionResult::getAnswerResultSum((int)$aqId);
        return $this->renderJSON($data);
    }

    /**
     * 查询同问人
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionSelectSameQuestionAll()
    {
        $aqId = app()->request->get('aqId');
        $data = SeSameQuestion::selectSameQuestionAll((int)$aqId);
        return $this->renderPartial('//publicView/answer/_new_answer_question_list_details_alsoask', array('alsoAsk' => $data));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午3:30
 */

namespace mobileWeb\modules\web\modules\weakness\controllers;


use common\components\WebDataCache;
use common\helper\StringHelper;
use common\models\JsonMessage;
use common\models\pos\SeUserinfo;
use common\models\search\Es_testQuestion;
use common\clients\WeaknessService;
use mobileWeb\components\AuthController;
use Yii;

class ErrorQuestionsController extends AuthController
{
    public $layout = "//lay_static";

    /**
     * 学生短板题目列表
     * @return string
     */
    public function actionQuestionList()
    {
        $userId = (int)user()->id;
        $subjectId = (int)Yii::$app->request->get('subjectId', 0);
        $complexity = (int)Yii::$app->request->get('complexity', 0);
        $page = (int)Yii::$app->request->get('page', 1);
        $perPage = (int)Yii::$app->request->get('perPage', 10);
        $time = (string)Yii::$app->request->get('date');
        if (!$time) {
            $time = (string)date('Y-m', time());
        }
        $monthNum = date('m', strtotime($time));
        $beginTime = strtotime($time) * 1000;
        $endTime = mktime(23,59,59,date('m', strtotime($time))+1, 00) * 1000;
        $type = "with-video";

        //用户信息
        $userInfo = SeUserinfo::getUserDetails($userId);

        //获取科目名称
        $subjectName = WebDataCache::getSubjectNameById($subjectId);

        $jsonMessage = new JsonMessage();
        $model = new WeaknessService();
        $weaknessQuestionResult = $model->getQuestionList($userId, $subjectId, $complexity, $page, $perPage, $beginTime, $endTime, $type);
        if ($weaknessQuestionResult->code != 200) {
            return $this->notFound("加载错误，请重新加载！");
        }

        $weaknessQuestionList = $weaknessQuestionResult->body;
        $questionList = [];
        $content = '';
        $difficult = 0;
        if (count($weaknessQuestionList) > 0) {
            foreach ($weaknessQuestionList as &$question) {
                /** @var Es_testQuestion $questionModel */
                $questionModel = Es_testQuestion::getTestQuestionDetails($question->questionId);
                if ($questionModel != null) {
                    $content = $this->getQuestionContent($questionModel);
                    $difficult = $questionModel->complexity;
                }
                $question->content = $content;
                $question->difficult = $difficult;
                array_push($questionList, $question);
            }
        }

        if (Yii::$app->request->isAjax) {
            $jsonMessage->success = true;
            $jsonMessage->data = $questionList;
            return $this->renderJSON($jsonMessage);
        }

        return $this->render('question-list', ['questionList' => $questionList,
            'userInfo' => $userInfo,
            'subjectName' => $subjectName,
            'subjectId' => $subjectId,
            'complexity' => $complexity,
            'date' => $time,
            'monthNum' => $monthNum
        ]);
    }


    /**
     * 学生单个错题信息
     * @return string
     */
    public function actionQuestionInfo()
    {
        $userId = (int)user()->id;
        $questionId = (int)Yii::$app->request->get('questionId', 0);
        $time = (string)Yii::$app->request->get('date');
        if (!$time) {
            $time = (string)date('Y-m', time());
        }
        $beginTime = strtotime($time) * 1000;
        $endTime = mktime(23,59,59,date('m', strtotime($time))+1, 00) * 1000;

        if ($userId == 0 || $questionId == 0) {
            return $this->notFound('参数错误！');
        }

        $ansList = [];
        $ansImages = [];
        $videoInfo = null;
        $homeworkName = '';
        $model = new WeaknessService();
        $weaknessQuestionResult = $model->getQuestionInfo($userId, $questionId, $beginTime, $endTime);
        if ($weaknessQuestionResult->code != 200) {
            return $this->notFound("题目不存在！");
        }
        $weaknessQuestionInfo = $weaknessQuestionResult->body;

        if ($weaknessQuestionInfo != null) {
            $ansList = $weaknessQuestionInfo->ansList;
            $videoInfo = $weaknessQuestionInfo->videoInfo;
            $homeworkName = $weaknessQuestionInfo->homeworkName;
            $ansImages = $weaknessQuestionInfo->ansImages;
        }
        /** @var Es_testQuestion $questionInfo */
        $questionInfo = Es_testQuestion::getTestQuestionDetails($questionId);
        $complexity = 0;
        $content = '';
        $answer = '';
        $userAnswer = '';
        if ($questionInfo != null) {
            $complexity = $questionInfo->complexity;
            $content = $this->getQuestionContent($questionInfo);
            $answer = StringHelper::replacePath($questionInfo->getNewAnswerContent());
            $userAnswer = StringHelper::replacePath(implode('', $questionInfo->getUserAnswer($questionId, $ansList, $ansImages)));
        }
        $questionModel = new \stdClass();
        $questionModel->questionId = $questionId;
        $questionModel->content = $content;
        $questionModel->answer = $answer;
        $questionModel->userAnswer = $userAnswer;
        $questionModel->homeworkName = $homeworkName;

        return $this->render('question-info', ['questionModel' => $questionModel,
            'questionInfo' => $questionInfo,
            'complexity' => $complexity,
            'videoInfo' => $videoInfo
        ]);
    }


    /**
     * 组合小题
     * @param Es_testQuestion $questionModel
     * @return string
     */
    public function getQuestionContent(Es_testQuestion $questionModel)
    {

        $data = $this->renderPartial('//publicView/question/_itemQuestion', ['questionModel' => $questionModel]);
        return $data;
    }


}
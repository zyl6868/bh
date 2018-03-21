<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午4:57
 */

namespace mobileWeb\modules\web\modules\weakness\controllers;


use common\components\WebDataCache;
use common\models\JsonMessage;
use common\models\pos\SeUserinfo;
use common\models\search\Es_testQuestion;
use common\clients\WeaknessService;
use mobileWeb\components\AuthController;
use Yii;

class WeaknessKidsController extends AuthController
{
    public $layout = "//lay_static";


    /**
     * 学生知识点短板列表
     * @return string
     */
    public function actionKidsList()
    {

        $userId = (int)user()->id;
        $subjectId = (int)Yii::$app->request->get('subjectId', 0);
        $page = (int)Yii::$app->request->get('page', 1);
        $perPage = (int)Yii::$app->request->get('perPage', 10);
        $time = (string)Yii::$app->request->get('date');
        if (!$time) {
            $time = (string)date('Y-m', time());
        }
        $beginTime = strtotime($time) * 1000;
        $endTime = mktime(23,59,59,date('m', strtotime($time))+1, 00) * 1000;
        $type = "with-video";

        if ($userId == 0) {
            return $this->notFound('参数错误！');
        }

        //用户信息
        $userInfo = SeUserinfo::getUserDetails($userId);

        //获取科目名称
        $subjectName = WebDataCache::getSubjectNameById($subjectId);

        $jsonMessage = new JsonMessage();

        $monthNum = date('m', strtotime($time));
        $kidList = [];
        $model = new WeaknessService();
        $kidListResult = $model->getWeaknessKidList($userId, $subjectId, $page, $perPage, $beginTime, $endTime, $type);

        if ($kidListResult->code == 200) {
            $kidList = $kidListResult->body;
        }

        if (Yii::$app->request->isAjax) {
            $jsonMessage->success = true;
            $jsonMessage->data = $kidList;
            return $this->renderJSON($jsonMessage);
        }

        return $this->render('kids-list', ['kidList' => $kidList,
            'userInfo' => $userInfo,
            'subjectName' => $subjectName,
            'subjectId' => $subjectId,
            'date' => $time,
            'monthNum' => $monthNum
        ]);
    }


    /**
     * 学生单个知识点短板题目列表
     * @return string
     */
    public function actionKidQuestionList()
    {
        $userId = (int)user()->id;
        $kid = (int)Yii::$app->request->get('kid', 0);
        $page = (int)Yii::$app->request->get('page', 1);
        $perPage = (int)Yii::$app->request->get('perPage', 10);
        $time = (string)Yii::$app->request->get('date');
        if (!$time) {
            $time = (string)date('Y-m', time());
        }
        $beginTime = strtotime($time) * 1000;
        $endTime = mktime(23,59,59,date('m', strtotime($time))+1, 00) * 1000;
        $type = "with-video";

        if ($kid == 0) {
            return $this->notFound("参数错误！");
        }

        $jsonMessage = new JsonMessage();
        $model = new WeaknessService();
        $weaknessKidResult = $model->getKidQuestionList($userId, $kid, $page, $perPage, $beginTime, $endTime, $type);
        if ($weaknessKidResult->code != 200) {
            return $this->notFound("知识点不存在！");
        }
        $weaknessKidInfo = $weaknessKidResult->body;

        if ($weaknessKidInfo == null) {
            return $this->notFound("不存在此作业!");
        }

        $questionList = [];
        $knowledgeInfo = $weaknessKidInfo->knowledgeInfo;
        $kidQuestionList = $weaknessKidInfo->questions->data;
        if (count($kidQuestionList) > 0) {
            foreach ($kidQuestionList as &$question) {
                /** @var Es_testQuestion $questionModel */
                $questionModel = Es_testQuestion::getTestQuestionDetails($question->questionId);
                if ($questionModel != null) {
                    $question->content = $this->getQuestionContent($questionModel);
                    $question->difficult = $questionModel->complexity;
                    array_push($questionList, $question);
                }
            }
        }

        if (Yii::$app->request->isAjax) {
            $jsonMessage->success = true;
            $jsonMessage->data = $questionList;
            return $this->renderJSON($jsonMessage);
        }

        return $this->render('kid-question-list', ['knowledgeInfo' => $knowledgeInfo,
            'kidQuestionList' => $questionList,
            'date' => $time,
            'kid' => $kid
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
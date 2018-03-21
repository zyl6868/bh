<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午2:28
 */

namespace mobileWeb\modules\web\modules\homework\controllers;


use common\helper\StringHelper;
use common\models\search\Es_testQuestion;
use common\clients\HomeworkService;
use mobileWeb\components\AuthController;
use Yii;

class MyHomeworkController extends AuthController
{
    public $layout = '//lay_static';

    /**
     * 学生作答且有精讲作业视频的精品作业
     * @return string
     */
    public function actionHomeworkList()
    {
        $userId = (int)user()->id;
        $time = (string)Yii::$app->request->get('date');
        if (!$time) {
            $time = (string)date('Y-m', time());
        }
        $beginTime = $time . '-01 00:00:00';
        if ($userId == 0) {
            return $this->notFound("参数不正确");
        }
        $monthNum = date('m', strtotime($time));
        $model = new HomeworkService();
        $homeworkResult = $model->getHomeworkList($userId, $beginTime);
        if ($homeworkResult->code != 200) {
            return $this->notFound("作业不存在！");
        }
        $homeworkList = $homeworkResult->body;

        return $this->render('homework-list', ['homeworkList' => $homeworkList, 'monthNum' => $monthNum]);
    }


    /**
     * 作业报告,查看某份作业的详情 正确率 错误题目
     * @return string
     */
    public function actionHomeworkInfo()
    {
        $homeworkAnswerId = Yii::$app->request->get('homeworkAnswerId', 0);
        if ($homeworkAnswerId == 0) {
            return $this->notFound("参数不正确");
        }
        $model = new HomeworkService();
        $homeworkInfoResult = $model->getHomeworkInfo($homeworkAnswerId);

        if ($homeworkInfoResult->code != 200) {
            return $this->notFound("作业不存在！");
        }
        $homeworkInfo = $homeworkInfoResult->body;
        $questionList = [];
        $questions = $homeworkInfo->questions;
        $ansImages = $homeworkInfo->url;
        if (count($questions) > 0) {
            foreach ($questions as $question) {
                $questionModel = new \stdClass();
                $questionId = $question->questionId;
                $ansList = $question->ansList;
                /** @var Es_testQuestion $questionInfo */
                $questionInfo = Es_testQuestion::getTestQuestionDetails($questionId);
                if ($questionInfo == null) {
                    continue;
                }

                //拼题干
                $questionContent = $this->getQuestionContent($questionInfo);
                //拼正确答案
                $questionAnswer = StringHelper::replacePath($questionInfo->getNewAnswerContent());
                //拼学生作答答案
                $questionUserAnswer = StringHelper::replacePath(implode('', $questionInfo->getUserAnswer($questionId, $ansList, $ansImages)));

                //放到新模型
                $questionModel->id = $questionId;
                $questionModel->content = $questionContent;
                $questionModel->answer = $questionAnswer;
                $questionModel->userAnswer = $questionUserAnswer;
                $questionModel->startTimePoint = $question->startTimePoint;
                $questionModel->classmateWrongNum = $question->classmateWrongNum;

                $questionList[] = $questionModel;
            }
        }

        return $this->render('homework-info', ['homeworkInfo' => $homeworkInfo, 'questionList' => $questionList]);
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
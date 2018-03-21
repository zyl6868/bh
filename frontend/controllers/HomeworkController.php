<?php

namespace frontend\controllers;

use common\controller\YiiController;
use common\models\pos\SeHomeworkPlatform;
use common\models\pos\SeHomeworkQuestion;
use common\models\pos\SeHomeworkQuestionPlatform;
use common\models\pos\SeHomeworkTeacher;
use common\models\sanhai\ShTestquestion;
use Yii;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-12-11
 * Time: 下午4:03
 */
class HomeworkController extends YiiController
{
    const PLATFORM_HOMEWORK_TYPE = 1;
    const TEACHER_HOMEWORK_TYPE = 2;
    const ELE_HOMEWORK_TYPE = 1;
    const UPLOAD_HOMEWORK_TYPE = 0;

    public $layout = 'lay_homework';

    public function actionInfo()
    {
        $homeworkId = Yii::$app->request->get('id');
        $type = Yii::$app->request->get('type', self::PLATFORM_HOMEWORK_TYPE);


        if ($type == self::PLATFORM_HOMEWORK_TYPE) {
            return $this->redirect(['platform-homework','homeworkId'=>$homeworkId]);
        }

        return $this->redirect(['teacher-homework','homeworkId'=>$homeworkId]);
    }


    /**
     * 平台作业展示
     * @param int $homeworkId
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function actionPlatformHomework(int $homeworkId)
    {
        $homeworkData = SeHomeworkPlatform::getHomeworkPlatformPortion($homeworkId);
//        根据homeworkID查询questionid
        $questionList = SeHomeworkQuestionPlatform::getHomeworkQuePlatformQuestionIdAll($homeworkId);
        if (empty($questionList)) {
            return $this->notFound('未找到该作业！');
        }
        //        查询题目的具体内容
        $homeworkResult = [];
        foreach ($questionList as $v) {
            $oneHomework = ShTestquestion::getTestQuestionDetails_Cache((int)$v['questionId']);
            $homeworkResult[] = $oneHomework;
        }


        return $this->render('ele', ['homeworkData' => $homeworkData,
            'homeworkResult' => $homeworkResult,
        ]);
    }

    /**
     * 老师作业展示
     * @param int $homeworkId
     * @return string
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function actionTeacherHomework(int $homeworkId)
    {

        $homeworkData = SeHomeworkTeacher::getHomeworkTeacherDetails($homeworkId);

        if ($homeworkData == null){
            return $this->notFound('未找到该作业！');
        }

        $homeworkResult = [];
        $getType = $homeworkData->getType;

        if ($getType == self::ELE_HOMEWORK_TYPE){

            //根据homeworkID查询questionid
            $questionList = $homeworkData->getHomeworkQuestion()->select('questionId')->asArray()->all();

            //  查询题目的具体内容
            /** @var SeHomeworkQuestion $questionList */
            foreach ($questionList as $v) {
                //查询题详情
                $oneHomework = ShTestquestion::getTestQuestionDetails_Cache((int)$v['questionId']);
                $homeworkResult[] = $oneHomework;
            }
            return $this->render('ele', ['homeworkData' => $homeworkData, 'homeworkResult' => $homeworkResult]);

        }
        //纸质作业
        $imageList = $homeworkData->getHomeworkImages()->all();
        return $this->render('upload', ['homeworkData' => $homeworkData, 'imageList' => $imageList]);

    }
}
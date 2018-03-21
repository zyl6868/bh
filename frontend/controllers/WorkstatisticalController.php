<?php
declare(strict_types=1);
namespace frontend\controllers;

use common\helper\DateTimeHelper;
use common\models\pos\SeClassMembers;
use common\models\pos\SeHomeworkAnswerInfo;
use common\models\pos\SeHomeworkAnswerQuestionAll;
use common\models\pos\SeHomeworkAnswerQuestionMain;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use common\models\sanhai\ShTestquestion;
use frontend\components\BaseAuthController;
use common\models\dicmodels\DegreeModel;

class WorkstatisticalController extends BaseAuthController
{
    public $layout = 'lay_new_class_v2';

    //总体分析
    /**
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionWorkStatisticalAll()
    {
        $proFirstime = microtime(true);
        $relId = app()->request->get('relId');
        $result = SeHomeworkRel::find()->where(['id' => $relId])->one();
        if (empty($result)) {
            return $this->notFound('该作业已被删除！');
        }
        $this->getClassModel((int)$result->classID);

        //查询作业
        $query = SeHomeworkAnswerInfo::find()->where(['relId' => $relId]);
        //截止时间
        $deadlineTime = strtotime(date('Y-m-d 23:59:59', DateTimeHelper::timestampDiv1000($result->deadlineTime))) * 1000;
        //超时提交
        $overtimeInfo = $query->andWhere(['>', 'uploadTime', $deadlineTime])->answerStatus()->all();
        $overtimeId = array();
        foreach ($overtimeInfo as $v) {
            $overtimeId[] = $v->studentID;
        }
        //作业信息
        $homeWorkTeacher = $result->getHomeWorkTeacher()->one();

        //查询已答学生
        $answerStuList = $result->getHomeworkAnswerInfo()->answerStatus()->all();
        $answerdId = array();
        foreach ($answerStuList as $v) {
            $answerdId[] = $v->studentID;
        }
        //查询班级学生
        $studentList = SeClassMembers::find()->where(['classID' => $result->classID, 'identity' => '20403'])->all();
        $allId = array();
        foreach ($studentList as $v1) {
            $allId[] = $v1->userID;
        }
        //未答的学生
        $noAnswerdId = array();
        foreach ($allId as $v) {
            if (!in_array($v, $answerdId)) {
                $noAnswerdId[] = $v;
            }
        }
        //查询优良中差

        $result = SeHomeworkAnswerInfo::getDb()->createCommand('SELECT correctLevel,count(*) as levelCount from se_homeworkAnswerInfo WHERE relId = :relId  AND isCheck = 1 GROUP BY correctLevel', [':relId' => $relId])->queryAll();
        $level = [];
        foreach ($result as $key => $v) {
            $level[$v['correctLevel']] = $v['levelCount'];
        }
        \Yii::info('总体分析 ' . (microtime(true) - $proFirstime), 'service');
        return $this->render('work_statistical_all', ['relId' => $relId, 'overtimeId' => $overtimeId, 'homeWorkTeacher' => $homeWorkTeacher, 'noAnswerdId' => $noAnswerdId, 'deadlineTime' => $deadlineTime, 'level' => $level]);

    }

    /**
     * 题目分析
     * @param int $relId
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionWorkStatisticalTopic(int $relId)
    {
        $proFirstime = microtime(true);
        $result = SeHomeworkRel::find()->where(['id' => $relId])->one();
        if (empty($result)) {
            return $this->notFound('不存在该作业！');
        }

        $this->getClassModel((int)$result->classID);
        $homeWorkTeacher = $result->getHomeWorkTeacher()->one();
        $homeworkTeacherOne = SeHomeworkTeacher::getOneByRel($relId);
        //是否有学生完成该作业
        $isFinishHomework = SeHomeworkAnswerInfo::find()->where(['relId' => $relId])->answerStatus()->one();

        //生成答题卡（X轴）
        $homeworkAnswerAll = SeHomeworkAnswerQuestionAll::find()->where(['relId' => $relId])->andWhere(['>', 'correctResult', 0])->select('questionID')->distinct()->orderBy('questionID')->column();
        $objective = [];
        $subjective = [];
        $questionInfoList = ShTestquestion::find()->where(['id' => $homeworkAnswerAll])->all();
        foreach ($questionInfoList as $questionModel) {
            $showType = $questionModel->isMajorQuestion();
            $arrQuestionId = $homeworkTeacherOne->getQuestionNo((int)$questionModel->id);
            $arrQuestionTrueId = $questionModel->id;
            if ($showType == 0) {
                $objective[$arrQuestionId] = $arrQuestionTrueId;
            } else {
                $subjective[$arrQuestionId] = $arrQuestionTrueId;
            }
        }
        ksort($objective);
        ksort($subjective);
        $objectiveArr = []; //转换后的题目id (客观题)
        $objectiveTrueArr = [];    //真实的题目id (客观题)
        $subjectiveArr = []; //转换后的题目id (主观题)
        $subjectiveTrueArr = [];    //真实的题目id (主观题)
        foreach ($objective as $key => $val) {
            $objectiveArr[] = $key . '题';
            $objectiveTrueArr[] = $val;
        }

        foreach ($subjective as $i => $item) {
            $subjectiveArr[] = $i . '题';
            $subjectiveTrueArr[] = $item;
        }

        //对应的正确率(Y轴)
        $objectiveAnswer = [];      //客观题正确率
        $subjectiveAnswer = [];     //
        //获取所有人的每道题的正确数
        $questionRightNum = SeHomeworkAnswerQuestionAll::getQuestionRightNum($relId);
        $questionRight = [];
        foreach ($questionRightNum as $val) {
            $questionRight[$val['questionID']] = $val['num'];
        }
        //获取所有人的每道题的半对数
        $questionHalfRightNum = SeHomeworkAnswerQuestionAll::getQuestionHalfRightNum($relId);
        foreach ($questionHalfRightNum as $val) {
            if(isset($questionRight[$val['questionID']])){
                $questionRight[$val['questionID']] += $val['num'] / 2;
            }else{
                $questionRight[$val['questionID']] = $val['num']/2;
            }
        }
        //获取该作业主观题总人数
        $subjectiveNum = SeHomeworkAnswerInfo::getFinishHomeworkTotalNum($relId);
        //获取该作业客观题总人数
        $objectiveNum = SeHomeworkAnswerInfo::getUploadHomeworkNum($relId);
        //客观题的正确率
        foreach ($objective as $objectiveId) {
            if (array_key_exists($objectiveId, $questionRight)) {
                $rate = sprintf('%.2f', ($questionRight[$objectiveId] / ($objectiveNum ?: 1)) * 100);
            } else {
                $rate = 0;
            }
            $objectiveAnswer[] = $rate;
        }
        //主观题的正确率
        foreach ($subjective as $subjectiveId) {
            if (array_key_exists($subjectiveId, $questionRight)) {
                $rate = sprintf('%.2f', ($questionRight[$subjectiveId] / ($subjectiveNum ?: 1)) * 100);
            } else {
                $rate = 0;
            }
            $subjectiveAnswer[] = $rate;
        }

        /**
         * 题目难度正确率
         */
        $homeworkQuestions = SeHomeworkAnswerQuestionMain::getDb()->createCommand('SELECT  t.complexity,m.correctResult,count(tID) as countTid from schoolservice.se_homeworkAnswerQuestionMain as m INNER JOIN teachresource.sh_testquestion as t on m.questionID=t.id ' .
            ' where  m.relId = :relId and m.correctResult > 0  group by t.complexity,m.correctResult', [':relId' => $relId])->queryAll();

        //难易程度（X轴）
        $totalCount = 0;

        $arr = [];
        foreach ($homeworkQuestions as $complexity => $complexityCount) {
            $totalCount += $complexityCount['countTid'];

            if (!array_key_exists($complexityCount['complexity'], $arr)) {
                if (empty($complexityCount['complexity'])) {
                    continue;
                }
                $complexity = $complexityCount['complexity'];
                $sum = from($homeworkQuestions)->sum(function ($v) use ($complexity) {
                    if ($v['complexity'] == $complexity) {
                        return $v['countTid'];
                    } else {
                        return 0;
                    }
                });

                $persum = from($homeworkQuestions)->sum(function ($v) use ($complexity) {
                    if ($v['complexity'] == $complexity && $v['correctResult'] == 3) {
                        return $v['countTid'];
                    } else {
                        return 0;
                    }
                });
                $persumHalf = from($homeworkQuestions)->sum(function ($v) use ($complexity) {
                    if ($v['complexity'] == $complexity && $v['correctResult'] == 2) {
                        return $v['countTid'];
                    } else {
                        return 0;
                    }
                });
                $persum += $persumHalf / 2;
                $complexityName = DegreeModel::model()->getName($complexity);
                $arr[$complexityCount['complexity']] = ['name' => $complexityName, 'per' => $sum > 0 ? sprintf('%.2f', $persum / $sum * 100) : 0.00, 'persum' => $persum, 'sum' => $sum];
            }
        }


        $complexityNameArr = from($arr)->select(function ($v) {
            return $v['name'];
        })->toList();
        $complexityRateArr = from($arr)->select(function ($v) {
            return $v['per'];
        })->toList();
        $complexityPersumArr = from($arr)->select(function ($v) {
            return $v['persum'];
        })->toList();
        $complexitySumArr = from($arr)->select(function ($v) {
            return $v['sum'];
        })->toList();
        \Yii::info('题目分析 ' . (microtime(true) - $proFirstime), 'service');
        return $this->render('work_statistical_topic',
            ['relId' => $relId,
                'complexityPersumArr' => $complexityPersumArr,
                'complexitySumArr' => $complexitySumArr,
                'homeWorkTeacher' => $homeWorkTeacher,
                'objectiveArr' => $objectiveArr,
                'objectiveTrueArr' => $objectiveTrueArr,
                'subjectiveArr' => $subjectiveArr,
                'subjectiveTrueArr' => $subjectiveTrueArr,
                'objectiveAnswer' => $objectiveAnswer,
                'subjectiveAnswer' => $subjectiveAnswer,
                'complexityNameArr' => $complexityNameArr,
                'complexityRateArr' => $complexityRateArr,
                'isFinishHomework' => $isFinishHomework
            ]);
    }

    //显示题目详情
    public function actionQuestionInfo()
    {
        $id = app()->request->getParam('questionId', '');
        $relId = app()->request->getParam('relId', '');
        $questionResult = ShTestquestion::getTestQuestionDetails_Cache((int)$id);
        //求回答选项的比例
        $options = SeHomeworkAnswerQuestionAll::getDb()->createCommand('select answerOption,count(aid) as optionCount  from  se_homeworkAnswerQuestionAll  where questionID=:questionID and   relId=:relId  group by answerOption', ['questionID' => $id, ':relId' => $relId])->queryAll();

        $showType = $questionResult->getQuestionShowType();

        $allOptions = [];
        $optionCountSum = 0;
        foreach ($options as $item) {
            $allOptions[$item['answerOption']] = $item['optionCount'];
            $optionCountSum += $item['optionCount'];
        }
        //求当前人回答的选项
        $answerOption = app()->request->getParam('answerOption', '');
        $student = app()->request->getParam('student', '');
        return $this->renderPartial('question_content', ['questionResult' => $questionResult, 'relId' => $relId, 'allOptions' => $allOptions, 'optionCountSum' => $optionCountSum, 'showType' => $showType, 'answerOption' => $answerOption, 'student' => $student]);
    }

    //学生分析
    public function actionWorkStatisticalStudent($relId)
    {
        $proFirstime = microtime(true);


        $result = SeHomeworkRel::find()->where(['id' => $relId])->one();
        if (empty($result)) {
            return $this->notFound('');
        }
        $this->getClassModel((int)$result->classID);
        $homeWorkTeacher = $result->getHomeWorkTeacher()->one();

        //根据relId查询当前作业所有提交了答案的学生
        $homeworkAnswerInfoArr = SeHomeworkAnswerInfo::find()->select('homeworkAnswerID,studentID,correctRate')->where(['relId' => $relId, 'isCheck' => 1])->all();

        $orderStudent = [];
        $questionArray = [];

        foreach($homeworkAnswerInfoArr as $v){
            $orderStudent[$v['studentID']] = ['studentId' => $v['studentID'], 'per' => $v['correctRate']];
        }

        if ($homeworkAnswerInfoArr) {
            //查询学生的作业
            $questionArray = SeHomeworkAnswerQuestionAll::find()->select('questionID')->where(['relId' => $relId, 'studentID' => $homeworkAnswerInfoArr[0]->studentID])->asArray()->all();
        }


        //根据正确率排序
        usort($orderStudent, function ($a, $b) {
            return $a['per'] < $b['per'];
        });

        //根据relId查询homeworkId
        $homeworkID = $result->homeworkId;
        //根据homeworkID查询题目*/
        $homeworkResult = SeHomeworkTeacher::find()->where(['id' => $homeworkID])->limit(1)->one();

        //根据questionID获取对应的序号，并将序号升序排序
        $questionIdResult = [];
        foreach ($questionArray as $v) {
            $questionIdResult[$v['questionID']] = $homeworkResult->getQuestionNo((int)$v['questionID']);
        }
        asort($questionIdResult);

        \Yii::info('学生分析 ' . (microtime(true) - $proFirstime), 'service');
        return $this->render('work_statistical_student', ['homeworkAnswerID' => $homeworkAnswerInfoArr, 'relId' => $relId, 'orderStudent' => $orderStudent, 'questionIdResult' => $questionIdResult, 'homeworkResult' => $homeworkResult, 'homeWorkTeacher' => $homeWorkTeacher]);


    }

    /**
     * 语音作业展示
     * @param $relId
     * @return string
     */
    public function actionWorkStatisticalAudio($relId){

        $proFirstime = microtime(true);
        $result = SeHomeworkRel::find()->where(['id' => $relId])->one();
        if (empty($result)) {
            return $this->notFound('');
        }
        $this->getClassModel((int)$result->classID);

        //作业信息
        $homeWorkTeacher = $result->getHomeWorkTeacher()->one();

        //截止时间
        $deadlineTime = strtotime(date('Y-m-d 23:59:59', DateTimeHelper::timestampDiv1000($result->deadlineTime))) * 1000;
        //超时提交
        $overtimeInfo = SeHomeworkAnswerInfo::find()->where(['relId' => $relId])->andWhere(['>', 'uploadTime', $deadlineTime])->answerStatus()->all();
        $overtimeId = array();
        foreach ($overtimeInfo as $v) {
            $overtimeId[] = $v->studentID;
        }

        //查询已答学生
        $answerStuList = $result->getHomeworkAnswerInfo()->answerStatus()->all();
        $answerdId = array();
        foreach ($answerStuList as $v) {
            $answerdId[] = $v->studentID;
        }
        //查询班级学生
        $studentList = SeClassMembers::find()->where(['classID' => $result->classID, 'identity' => '20403'])->all();
        $allId = array();
        foreach ($studentList as $v1) {
            $allId[] = $v1->userID;
        }
        //未答的学生
        $noAnswerdId = array();
        foreach ($allId as $v) {
            if (!in_array($v, $answerdId)) {
                $noAnswerdId[] = $v;
            }
        }


        //根据relId查询当前作业所有提交了答案的学生
        $homeworkAnswerInfoArr = SeHomeworkAnswerInfo::find()->select('homeworkAnswerID,studentID,correctRate')->andWhere(['relId' => $relId,'isCheck' => 1])->orderBy('uploadTime')->all();

        $questionArray = [];

        if ($homeworkAnswerInfoArr) {
            //查询学生的作业
            $questionArray = SeHomeworkAnswerQuestionAll::find()->select('questionID')->where(['relId' => $relId, 'studentID' => $homeworkAnswerInfoArr[0]->studentID])->asArray()->all();
        }

        //根据relId查询homeworkId
        $homeworkID = $result->homeworkId;
        //根据homeworkID查询题目*/
        $homeworkResult = SeHomeworkTeacher::find()->where(['id' => $homeworkID])->limit(1)->one();

        //根据questionID获取对应的序号，并将序号升序排序
        $questionIdResult = [];
        foreach ($questionArray as $v) {
            $questionIdResult[$v['questionID']] = $homeworkResult->getQuestionNo((int)$v['questionID']);
        }
        asort($questionIdResult);

        \Yii::info('学生分析 ' . (microtime(true) - $proFirstime), 'service');
        return $this->render('work_statistical_audio', [
            'homeworkAnswerID' => $homeworkAnswerInfoArr,
            'relId' => $relId,
            'questionIdResult' => $questionIdResult,
            'homeworkResult' => $homeworkResult,
            'homeWorkTeacher' => $homeWorkTeacher,
            'noAnswerdId' => $noAnswerdId,
            'deadlineTime' => $deadlineTime,
            'overtimeId' => $overtimeId
        ]);


    }

}
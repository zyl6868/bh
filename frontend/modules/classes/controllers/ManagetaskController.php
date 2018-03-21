<?php
declare(strict_types=1);
namespace frontend\modules\classes\controllers;

use common\models\pos\SeClass;
use common\models\pos\SeHomeworkAnswerInfo;
use common\models\pos\SeHomeworkAnswerQuestionAll;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use common\models\sanhai\ShTestquestion;
use frontend\components\ClassesBaseController;
use common\components\WebDataKey;
use Yii;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-11-18
 * Time: 上午10:08
 */
class ManagetaskController extends ClassesBaseController
{
    public $layout = '@app/views/layouts/lay_new_class_v2';

    /**
     *作业详情
     * @param  integer $classId 班级ID
     * @param integer $relId 关联作业ID
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ExitException
     * @throws \yii\web\HttpException
     */
    public function actionDetails(int $classId, int $relId)
    {
        /** @var SeClass $classModel */
        $classModel = $this->getClassModel($classId);
        if (loginUser()->isTeacher()) {
            return $this->notFound('你没有权限查看该班级', 403);
        }
        /** @var SeHomeworkRel $homeworkRelModel */
        $homeworkRelModel = SeHomeworkRel::getOneHomeworkRelDetails($relId);
        if (empty($homeworkRelModel) || ($homeworkRelModel->classID != $classModel->classID)) {
            return $this->notFound('不存在该作业');
        }

        //作业的基本信息

        /** @var SeHomeworkTeacher $homeWorkTeacherModel */
        $homeWorkTeacherModel = $homeworkRelModel->getHomeWorkTeacher()->one();
        if (empty($homeWorkTeacherModel)) {
            $this->notFound('该作业已被删除！');
        }

        //查询学生答案
        /** @var SeHomeworkAnswerInfo $answerInfoModel */
        $answerInfoModel = $homeworkRelModel->getHomeworkAnswerInfoByUserId(user()->id);


        $isUploadAnswer = 0;

        if (!empty($answerInfoModel)) {
            $isUploadAnswer = $answerInfoModel->isUploadAnswer;
        }


        $getType = $homeWorkTeacherModel->getType;  //1：电子 ，0：纸质

        //判断作业类型并且判断电子作业是否批改
        if ($getType == 1) {
            if ($isUploadAnswer) {
                return $this->eleAnswered($homeworkRelModel, $homeWorkTeacherModel, $answerInfoModel);
            } elseif ($isUploadAnswer == 0) {
                return $this->eleAnswering($homeworkRelModel, $homeWorkTeacherModel);
            }

        } elseif ($getType == 0) {
            return $this->paperAnswering($homeworkRelModel, $homeWorkTeacherModel, $answerInfoModel, $isUploadAnswer);
        }

    }

    /**
     * 学生答题（电子作业）
     * @param SeHomeworkRel $homeworkRelModel
     * @param SeHomeworkTeacher $homeWorkTeacherModel
     * @return string
     * @throws \yii\base\InvalidParamException
     * @internal param $answerInfoModel
     */
    protected function eleAnswering(SeHomeworkRel $homeworkRelModel, SeHomeworkTeacher $homeWorkTeacherModel)
    {

        //是否已经答过此作业
        $isAnswered = false;
        //作业下的题目
        $homeworkQuestionList = $homeWorkTeacherModel->getHomeworkQuestionCache();
        //教师作业 补充内容的语音
        $homeworkRelAudio = $homeworkRelModel->audioUrl;
        //主观题，客观题
        $subjective = [];
        $objective = [];

        $ids = [];
        foreach ($homeworkQuestionList as $val) {
            $ids[] = $val->questionId;
        }
        //判断有没有小题
        $minIds = [];
        $isMajorQuestion = ShTestquestion::find()->where(['mainQusId' => $ids])->exists();
        if ($isMajorQuestion) {
            $minIds = ShTestquestion::find()->where(['mainQusId' => $ids])->select('id')->column();
            $maxIds = ShTestquestion::find()->where(['mainQusId' => $ids])->select('mainQusId')->column();
            $ids = array_diff($ids, $maxIds);
        }
        $arrids = array_merge($ids, $minIds);
        foreach ($arrids as $v) {
            $questionResult = ShTestquestion::getTestQuestionDetails_Cache((int)$v);
            if (isset($questionResult)) {
                if ($questionResult->isMajorQuestion()) {
                    $subjective[] = $questionResult->id;
                } else {
                    $objective[] = $questionResult->id;
                }
            }
        }
        //主观题排序
        $subjectives = [];
        foreach ($subjective as $val) {
            $subjectives[$homeWorkTeacherModel->getQuestionNo((int)$val)] = $val;
        }
        ksort($subjectives);
        //客观题排序
        $objectives = [];
        foreach ($objective as $val) {
            $objectives[$homeWorkTeacherModel->getQuestionNo((int)$val)] = $val;
        }
        ksort($objectives);

        return $this->render('eleanswering', array(
            'homeworkRelModel' => $homeworkRelModel,
            'homeworkData' => $homeWorkTeacherModel,
            'deadlineTime' => $homeworkRelModel->deadlineTime,
            'homeworkQuestion' => $homeworkQuestionList,
            'subjective' => $subjectives,
            'objective' => $objectives,
            'isAnswered' => $isAnswered,
            'homeworkRelAudio' => $homeworkRelAudio
        ));

    }


    /**
     * 答题完毕 新
     * @param SeHomeworkRel $homeworkRelModel
     * @param SeHomeworkTeacher $homeworkTeacherModel
     * @param SeHomeworkAnswerInfo $AnswerInfoModel
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    protected function eleAnswered(SeHomeworkRel $homeworkRelModel, SeHomeworkTeacher $homeworkTeacherModel, SeHomeworkAnswerInfo $AnswerInfoModel)
    {
        $homeworkID = $homeworkRelModel->homeworkId;
        //作业下的题目
        $homeworkQuestionList = $homeworkTeacherModel->getHomeworkQuestionCache();
        //教师作业 补充内容的语音
        $homeworkRelAudio = $homeworkRelModel->audioUrl;

        //题目ID展示
        /** @var SeHomeworkAnswerQuestionAll[] $homeworkQuestionIdResult */
        $homeworkQuestionIdResult = $AnswerInfoModel->getHomeworkAnswerQuestionAll()->orderBy('questionId')->all();
        //主观题、客观题
        $subjective = [];
        $objective = [];
        $objectiveAnswer = [];

        foreach ($homeworkQuestionIdResult as $v) {
            $questionInfo = ShTestquestion::getTestQuestionDetails_Cache((int)$v->questionID);
            if (isset($questionInfo)) {
                $no = $homeworkTeacherModel->getQuestionNo((int)$v->questionID);
                if ($questionInfo->isMajorQuestion()) {
                    $subjective[$no] = $v;
                } else {
                    $objective[$no] = $v;
                    $objectiveAnswer[$v->questionID] = $v;
                }
            }
        }
        ksort($subjective);
        ksort($objective);


        /**
         * 梯队
         */
//        $teamData = $this->teamShow($AnswerInfoModel, $homeworkTeacherModel,(int)$homeworkID);

        return $this->render('eleanswered',
            ['homeworkData' => $homeworkTeacherModel,
                'deadlineTime' => $homeworkRelModel->deadlineTime,
                'homeworkQuestion' => $homeworkQuestionList,
                'subjective' => $subjective,
                'objective' => $objective,
                'isAnswered' => $AnswerInfoModel,
                'objectiveAnswer' => $objectiveAnswer,
                'homeworkQuestionIdResult' => $homeworkQuestionIdResult,
                'homeworkRelAudio' => $homeworkRelAudio,

            ]);
    }

    /**
     * 梯队展示
     * @param SeHomeworkAnswerInfo $isAnswered
     * @param SeHomeworkTeacher $homeworkData
     * @param integer $homeworkID 作业id
     * @return array|mixed
     */
    protected function teamShow(SeHomeworkAnswerInfo $isAnswered, SeHomeworkTeacher $homeworkData, int $homeworkID)
    {

        $cache = Yii::$app->cache;
        $key = WebDataKey::HOMEWORK_ANSWER_TEAMDATA_SHOW . $homeworkID . '_' . user()->id;
        $data = $cache->get($key);

        if ($data === false) {
            if ($isAnswered->isCheck && $homeworkData->homeworkType != SeHomeworkTeacher::READ_HOMEWORK && $homeworkData->homeworkType != SeHomeworkTeacher::SPOKEN_HOMEWORK) {

                //当前用户所在的梯队
                $nowTeamNum = (int)$isAnswered->correctRate;
                if ($nowTeamNum == 100) {
                    $teamNum = 1;
                } elseif ($nowTeamNum >= 80 && $nowTeamNum < 100) {
                    $teamNum = 2;
                } elseif ($nowTeamNum >= 60 && $nowTeamNum < 80) {
                    $teamNum = 3;
                } elseif ($nowTeamNum >= 40 && $nowTeamNum < 60) {
                    $teamNum = 4;
                } else {
                    $teamNum = 5;
                }

                // 全国学生答题总人数:$finishTotalCount ；当前学生前面的学生数:$overCount   $homeworkData->homeworkPlatformId > 0则来源于平台
                $finishTotalCount = 0;
                $overCount = 0;
                if ($homeworkData->homeworkPlatformId > 0) {
                    $homeworkTeacher = SeHomeworkTeacher::getPlatformHomeworkTeacherNum((int)$homeworkData->homeworkPlatformId);

                    foreach ($homeworkTeacher as $platform) {
                        $homeworkRelAll = SeHomeworkRel::getRelData((int)$platform->id);
                        foreach ($homeworkRelAll as $relId) {
                            $finishCount = SeHomeworkAnswerInfo::getFinishHomeworkTotalNum((int)$relId['id']);
                            $finishTotalCount += $finishCount;

                            $over = SeHomeworkAnswerInfo::getFinishHomeworkOverNum((int)$relId['id'], $nowTeamNum);
                            $overCount += $over;
                        }
                    }
                } else {
                    $homeworkRelAll = SeHomeworkRel::getRelData($homeworkID);
                    foreach ($homeworkRelAll as $relId) {
                        $finishCount = SeHomeworkAnswerInfo::getFinishHomeworkTotalNum((int)$relId['id']);
                        $finishTotalCount += $finishCount;

                        $over = SeHomeworkAnswerInfo::getFinishHomeworkOverNum((int)$relId['id'], $nowTeamNum);
                        $overCount += $over;
                    }

                }

                $teamData = [];
                $teamData['finishTotalCount'] = $finishTotalCount;          //全国答题总人数
                $teamData['overCount'] = $overCount;                        //前面的人数(正确率比当前用户高的)
                $teamData['teamNum'] = $teamNum;                            //当前所在的梯队
                $data = $teamData;
                $cache->set($key, $data, 600);

            } else {
                $teamData = [];
                $teamData['finishTotalCount'] = 0;
                $teamData['overCount'] = 0;
                $teamData['teamNum'] = 5;
                $data = $teamData;
            }

        }
        return $data;
    }


    /**
     * 学生答题（纸质作业）
     * @param SeHomeworkRel $homeworkRel
     * @param SeHomeworkTeacher $homeworkData
     * @param SeHomeworkAnswerInfo $answerInfoModel
     * @param integer $isUploadedAnswer 是否有答案
     * @return string
     * @throws \yii\base\InvalidParamException
     * @internal param SeHomeworkAnswerInfo $answerInfo
     */
    protected function paperAnswering(SeHomeworkRel $homeworkRel, SeHomeworkTeacher $homeworkData, SeHomeworkAnswerInfo $answerInfoModel=null, int $isUploadedAnswer)
    {
        //教师作业 补充内容的语音
        //答题卡中的语音
        //
        $answerImageArray = [];
        $isCheck = 0;

        $homeworkRelAudio = $homeworkRel->audioUrl;
        if (!empty($answerInfoModel)) {
            $isCheck = $answerInfoModel->isCheck;
            $answerImageArray = $answerInfoModel->getHomeworkAnswerDetailImage()->select('imageUrl')->column();
        }

        return $this->render('paperanswering',
            ['homeworkData' => $homeworkData,
                'isUploadedAnswer' => $isUploadedAnswer,
                'answerImageArray' => $answerImageArray,
                'isCheck' => $isCheck,
                'answerInfo' => $answerInfoModel,
                'homeworkRelAudio' => $homeworkRelAudio,
            ]);
    }



}
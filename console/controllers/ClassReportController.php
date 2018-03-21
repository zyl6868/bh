<?php
namespace console\controllers;

use common\helper\DateTimeHelper;
use common\models\pos\SeClassMembers;
use common\models\pos\SeHomeworkAnswerInfo;
use common\models\pos\SeHomeworkClassDayReport;
use common\models\pos\SeHomeworkClassReport;
use common\models\pos\SeHomeworkRel;
use common\models\pos\SeHomeworkTeacher;
use Yii;
use yii\console\Controller;
use yii\db\Exception;
use yii\db\Transaction;
use yii\helpers\Console;

ini_set('memory_limit','1024M');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/7
 * Time: 10:48
 */
class ClassReportController extends Controller
{

    /**
     *生成昨天班级作业日报表数据
     */
    public function actionCreateDayReport()
    {

        $nowDate = Date('Y-m-d', time());

        //$thisDate = $nowDate . '-01';

        $lastDate = date('Y-m-d', strtotime("$nowDate-1 day"));

        $thisDate = date('Y-m-d 23:59:59', strtotime("$nowDate-1 day"));

        $lastTime = strtotime($lastDate) * 1000;

        $thisTime = strtotime($thisDate) * 1000;

        $homeworkRelList = SeHomeworkRel::find()
            ->select(['se_homework_rel.id','classID','homeworkId','se_homework_rel.createTime','memberTotal'])
            ->where(['>', 'se_homework_rel.createTime', $lastTime])
            ->andWhere(['<', 'se_homework_rel.createTime', $thisTime])
            ->innerJoinWith('homeWorkTeacher')
            ->orderBy('se_homework_rel.classID,se_homework_teacher.subjectId')->all();

        $dataArray = $this->ManageData($homeworkRelList);

        $this->insterDate($lastDate, $dataArray);

    }

    /**
     *手动生成班级作业报表历史数据
     */
    public function actionCreateHisDayReport($start='2017-09-02',$end='2017-09-02')
    {

        $this->stdout("beginTime:" . date('y-m-d H:i:s', time()) . "\r\n", Console::FG_YELLOW);
        for ($startTime = strtotime($start); $startTime <= strtotime($end); $startTime += 86400) {

            $nowTime = date('Y-m-d H:i:s',$startTime);
            $yesterdayBegin = date('Y-m-d 00:00:00', strtotime("$nowTime -1 day"));
            $yesterdayEnd = date('Y-m-d 23:59:59', strtotime("$nowTime -1 day"));

            $beginTime = strtotime($yesterdayBegin) * 1000;
            $endTime = strtotime($yesterdayEnd) * 1000;


            $this->stdout("统计日期:" . date("Y-m-d H:i:s", $startTime) . "\r\n", Console::FG_YELLOW);

            $relHomeworkResult = SeHomeworkRel::find()
                ->select(['se_homework_rel.id','classID','homeworkId','se_homework_rel.createTime','memberTotal'])
                ->where(['>', 'se_homework_rel.createTime', $beginTime])
                ->andWhere(['<', 'se_homework_rel.createTime', $endTime])
                ->innerJoinWith('homeWorkTeacher')
                ->orderBy('se_homework_rel.classID,se_homework_teacher.subjectId')->all();

            $dataArray = $this->ManageData($relHomeworkResult);

            $this->insterDate($yesterdayBegin, $dataArray);

            Yii::$app->get('db_school')->close();
            SeHomeworkClassDayReport::getDb()->close();
        }
        $this->stdout("endTime:" . date('Y-m-d H:i:s', time()) . "\r\n", Console::FG_YELLOW);
    }

    /**
     * 班级作业月报告
     */
    public function actionCreateMonthReport(){

        $nowDate = Date('Y-m', time());

        $thisDate = $nowDate . '-01';

        $monthBegin = (string)date('Y-m-d', strtotime("$thisDate-1 month"));

        $monthEnd = (string)date('Y-m-d 23:59:59', strtotime("$thisDate-1 day"));

        $isExisted = SeHomeworkClassReport::find()->where(['between', 'generateTime', $monthBegin, $monthEnd])->exists();

        if (!$isExisted) {

            $monthReport = SeHomeworkClassDayReport::getClassStatistic($monthBegin,$monthEnd);

            foreach ($monthReport as $item){
                SeHomeworkClassReport::instertData($item);
            }

        }

    }

    /**
     * 创建历史班级作业月报告
     * @param string $month
     */
    public function actionCreateHisMonthReport($month='2017-08'){

        $thisDate = $month . '-01';

        $monthBegin = (string)date('Y-m-d', strtotime("$thisDate-1 month"));

        $monthEnd = (string)date('Y-m-d 23:59:59', strtotime("$thisDate-1 day"));

        $isExisted = SeHomeworkClassReport::find()->where(['between', 'generateTime', $monthBegin, $monthEnd])->exists();

        if (!$isExisted) {

            $monthReport = SeHomeworkClassDayReport::getClassStatistic($monthBegin,$monthEnd);

            foreach ($monthReport as $item){
                SeHomeworkClassReport::instertData($item);
            }

        }

    }


    /**
     * 根据se_homework_rel和se_homework_teacher 查出的结果变成需要的数据处理结果
     * @param SeHomeworkRel[] $homeworkRelList
     * @param $reportArray
     * @return array
     */
    public function ManageData($homeworkRelList)
    {
        $reportArray = [];
        foreach ($homeworkRelList as $k => $v) {

            if( !isset($reportArray[$v->classID])){
                $reportArray[$v->classID]=[];
            }
            $reportArray[$v->classID][]= $v;
        }

        $subjectId = 0;
        $dataArray = [];
        foreach ($reportArray as $v) {

            $relArray = [];
            $memberTotalArray = [];
            /** @var SeHomeworkRel $value */

            foreach ($v as $key => $value) {
                $classID = $value->classID;

                /** @var SeHomeworkTeacher $homeWorkTeacher */
                $homeWorkTeacher=  $value->getHomeWorkTeacher()->limit(1)->one();
                if ($subjectId != $homeWorkTeacher->subjectId) {
                    if (!empty($relArray)) {
                        array_push($dataArray, ['generateTime' => date('Y-m-d', DateTimeHelper::timestampDiv1000($v[$key - 1]->createTime)), 'classID' => $v[$key - 1]->classID, 'subjectID' => $v[$key - 1]->getHomeWorkTeacher()->limit(1)->one()->subjectId, 'relID' => $relArray, 'memberTotal' => $memberTotalArray]);
                    }
                    $relArray = [];
                    $memberTotalArray = [];
                    $subjectId = $homeWorkTeacher->subjectId;
                }
                array_push($relArray, $value->id);
                array_push($memberTotalArray, $value->memberTotal);
                if ($key == count($v) - 1) {
                    array_push($dataArray, ['generateTime' => date('Y-m-d', DateTimeHelper::timestampDiv1000($value->createTime)), 'classID' => $classID, 'subjectID' => $homeWorkTeacher->subjectId, 'relID' => $relArray, 'memberTotal' => $memberTotalArray]);
                }
            }
        }

        return $dataArray;
    }


    /**
     * 数据库插入数据
     * @param $yesterdayBegin
     * @param $dataArray
     */
    public function insterDate($yesterdayBegin, $dataArray)
    {

        //$thisMonth = date("Y-m-d 23:59:59", strtotime("$lastDate +1 month -1 day"));
        $yesterdayEnd = date("Y-m-d 23:59:59", strtotime($yesterdayBegin));

        /** @var Transaction $transaction */
        $transaction = Yii::$app->db_school->beginTransaction();
        try {
            $isExisted = SeHomeworkClassDayReport::find()->where(['between', 'generateTime', $yesterdayBegin, $yesterdayEnd])->exists();
            if (!$isExisted) {
                foreach ($dataArray as $v) {

                    $answerInfoQuery = SeHomeworkAnswerInfo::find()->where(['relId' => $v['relID']]);
                    $finishNum = $answerInfoQuery->count();

                    $homeworkAnswerData = SeHomeworkAnswerInfo::find()->select(['correctLevel','count(homeworkAnswerID) num'])->where(['relId' => $v['relID'],'isCheck' => 1])->groupBy('correctLevel')->asArray()->all();

                    $excellentNum = 0;
                    $goodNum = 0;
                    $middleNum = 0;
                    $badNum = 0;
                    $totalNum = 0;
                    foreach ($homeworkAnswerData as $answerData){

                        if($answerData['correctLevel'] == 4){
                            $excellentNum =$answerData['num'];
                        }
                        if($answerData['correctLevel'] == 3){
                            $goodNum =$answerData['num'];
                        }
                        if($answerData['correctLevel'] == 2){
                            $middleNum =$answerData['num'];
                        }
                        if($answerData['correctLevel'] == 1){
                            $badNum =$answerData['num'];
                        }
                    }

                    foreach ($v['memberTotal'] as $value) {
                        $totalNum += $value;
                    }
                    $classReportModel = new SeHomeworkClassDayReport();
                    $classReportModel->badNum = $badNum;
                    $classReportModel->excellentNum = $excellentNum;
                    $classReportModel->middleNum = $middleNum;
                    $classReportModel->goodNum = $goodNum;
                    $classReportModel->subjectId = $v['subjectID'];
                    $classReportModel->classId = $v['classID'];
                    $classReportModel->totalNum = $totalNum;
                    $classReportModel->finishNum = $finishNum;
                    $classReportModel->createTime = DateTimeHelper::timestampX1000();
                    $classReportModel->generateTime = $v['generateTime'];
                    $classReportModel->save();

                    //$this->stdout("id:" . $classReportModel->sid . '-----' . ++$k ."\r\n", Console::FG_YELLOW);
                }

            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            \Yii::error('作业报表生成日数据失败错误信息' . '------' . $e->getMessage());
        }
    }


    /**
     *更新se_homework_rel 表的memberTotal字段
     */
    public function actionUpdateHisMember()
    {

        $relResult = SeHomeworkRel::find()->batch(100);
        foreach ($relResult as $v) {
            foreach ($v as $value) {
                $classMemNum = SeClassMembers::getClassNumByClassId((int)$value->classID, SeClassMembers::STUDENT);
                $value->memberTotal = $classMemNum;
                $value->save();
            }

        }
    }

}
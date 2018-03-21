<?php
declare(strict_types=1);
namespace frontend\modules\classstatistics\controllers;

use common\models\pos\SeExamClass;
use common\models\pos\SeExamReportOverline;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamSubject;
use frontend\components\ClassesBaseController;

class OnlinescoreController extends ClassesBaseController
{
    public $layout = '@app/views/layouts/lay_new_classstatistic_v2';
    public $enableCsrfValidation = false;


    /**
     * 上线分数
     * @param integer $classId
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */

    public function actionIndex(int $classId){
        $proFirstime = microtime(true);
        $this->getClassModel($classId);
        $schoolExamId = (int)app()->request->get('examId');
        $selClassId =(int)app()->request->get('selClassId',0);
        /**
         * 表格
         */
        //分数线
        $seExamSubject = SeExamSubject::find()->where(['schoolExamId'=>$schoolExamId])->orderBy('subjectId asc')->all();

        //班级数据展示
        $overlineList = SeExamReportOverline::find()->where(['schoolExamId'=>$schoolExamId])->orderBy('classId,subjectId asc')->all();

        $overlineArr = [];
        foreach($overlineList as $key=>$overline){
            $overlineArr[$overline->classId]['totalOverLineNum'] = $overlineList[$key]->bothOverLineNum + $overlineList[$key]->singleNotOverLineNum;
            $overlineArr[$overline->classId]['subject'][$overline->subjectId]['bothOverLineNum'] = $overline->bothOverLineNum;
            $overlineArr[$overline->classId]['subject'][$overline->subjectId]['singleNotOverLineNum'] = $overline->singleNotOverLineNum;
            $overlineCount = $overline->bothOverLineNum + $overline->singleNotOverLineNum;
            $overlineArr[$overline->classId]['subject'][$overline->subjectId]['contributionRate'] = $overlineCount==0?$overlineCount:$overline->bothOverLineNum/$overlineCount;
        }

        //全校总计
        $overLineReport = SeExamReportOverline::findBySql('SELECT subjectId , SUM(bothOverLineNum) bothOverLineNum  ,SUM(singleNotOverLineNum) singleNotOverLineNum  FROM se_exam_reportOverline ' .
            'WHERE schoolExamId = :examId GROUP BY subjectId',[':examId'=>$schoolExamId])->orderBy('subjectId')->all();

        $totalOverlineArr = [];
        if(empty($overLineReport)){
            $totalOverlineArr['totalOverLine'] = 0;
            $totalOverlineArr['subject'] = [];
        }else{
            $totalOverlineArr['totalOverLine'] = $overLineReport[0]->bothOverLineNum+$overLineReport[0]->singleNotOverLineNum;
        }
        foreach($overLineReport as $report){
            $totalOverlineArr['subject'][$report->subjectId]['bothOverLineNumTotal'] = $report->bothOverLineNum;
            $totalOverlineArr['subject'][$report->subjectId]['singleNotOverLineNumTotal'] = $report->singleNotOverLineNum;
            $totalOverLine= $report->bothOverLineNum+ $report->singleNotOverLineNum;
            $totalOverlineArr['subject'][$report->subjectId]['totalcontributionRate'] = $totalOverLine==0?$totalOverLine:$report->bothOverLineNum/$totalOverLine;
        }
        //查询考试标题
        $examSchoolData= SeExamSchool::find()->where(['schoolExamId'=>$schoolExamId])->one();
        if(!empty($examSchoolData)){
            $examName = $examSchoolData->examName;
        }
        /**
         * 图表
         */
        //查询本次考试全部班级
        $examClass = SeExamClass::find()->where(['schoolExamId'=>$schoolExamId])->all();

        //上线数图表数据
        $onlineNum = $this->onlineNum($schoolExamId,$selClassId);

        \Yii::info('上线分数 '.(microtime(true)-$proFirstime),'service');
        if(app()->request->isAjax){
            return $this->renderPartial('statistics',['examId'=>$schoolExamId,'examClass'=>$examClass,'onlineNum'=>$onlineNum]);
        }

        return $this->render('index',['examId'=>$schoolExamId,'examClass'=>$examClass,'onlineNum'=>$onlineNum,'classId'=>$classId,'selClassId'=>$selClassId,

            'seExamSubject'=>$seExamSubject ,'data'=>$overlineArr ,'totalOverlineArr'=>$totalOverlineArr,'examName'=>$examName]);

    }

    /**
     * @param integer $examId
     * @param integer $classId
     * @return array
     * 上线数图表数据
     */
    public function onlineNum(int $examId,int $classId){

        //查询科目
       $subjectId = SeExamSubject::find()->select('subjectId')->where(['schoolExamId'=>$examId])->all();
        $onlineNum = [];
        foreach($subjectId as $key => $subject){
            $onlineNum[$key]['name'] = $subject->subjectId;
            if(empty($classId)){
                $examReport = SeExamReportOverline::findBySql('SELECT subjectId,SUM(bothOverLineNum) bothOverLineNum ,SUM(singleOverLineNum) singleOverLineNum ,SUM(singleNotOverLineNum) singleNotOverLineNum ,SUM(bothNotOverLineNum) bothNotOverLineNum FROM se_exam_reportOverline ' .
                    'WHERE schoolExamId = :examId GROUP BY subjectId',[':examId'=>$examId])->all();
            }else{
                $examReport = SeExamReportOverline::findBySql('SELECT subjectId,bothOverLineNum ,singleOverLineNum ,singleNotOverLineNum ,bothNotOverLineNum FROM se_exam_reportOverline ' .
                    'WHERE schoolExamId = :examId AND classId = :classId',[':examId'=>$examId,':classId'=>$classId])->all();

            }
            foreach($examReport as $val){
                if($subject->subjectId == $val->subjectId){
                    $onlineNum[$key]['shuang_s'] = $val->bothOverLineNum;
                    $onlineNum[$key]['dan'] = $val->singleNotOverLineNum;
                    $onlineNum[$key]['zong'] = $val->singleOverLineNum;
                    $onlineNum[$key]['shuang_x'] = $val->bothNotOverLineNum;
                }
            }
        }

    return $onlineNum;
    }
}
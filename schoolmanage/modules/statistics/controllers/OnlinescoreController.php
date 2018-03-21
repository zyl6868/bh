<?php
declare(strict_types=1);
namespace schoolmanage\modules\statistics\controllers;

use common\models\pos\SeExamClass;
use common\models\pos\SeExamReportOverline;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamSubject;
use schoolmanage\components\SchoolManageBaseAuthController;

class OnlinescoreController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_statistics_index';
    public $enableCsrfValidation = false;


    /**
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * 上线分数
     */

    public function actionIndex(){

        $schoolExamId = (int)app()->request->get('examId');
        $classId = (int)app()->request->get('classId',0);

        $this->getSeExamSchoolModel($schoolExamId);
        /**
         * 表格
         */
        //分数线
        $seExamSubject = SeExamSubject::find()->where(['schoolExamId'=>$schoolExamId])->orderBy('subjectId asc')->all();

        //班级数据展示
        $overlineList = SeExamReportOverline::find()->where(['schoolExamId'=>$schoolExamId])->orderBy('subjectId asc')->all();

        $overlineArr = [];
        foreach($overlineList as $key=>$overline){
            $overlineArr[$overline->classId]['totalOverLineNum'] = $overlineList[$key]->bothOverLineNum + $overlineList[$key]->singleNotOverLineNum;
            $overlineArr[$overline->classId]['subject'][$overline->subjectId]['bothOverLineNum'] = $overline->bothOverLineNum;
            $overlineArr[$overline->classId]['subject'][$overline->subjectId]['singleNotOverLineNum'] = $overline->singleNotOverLineNum;
            $overlineCount = $overline->bothOverLineNum + $overline->singleNotOverLineNum;
            $overlineArr[$overline->classId]['subject'][$overline->subjectId]['contributionRate'] = $overlineCount==0?$overlineCount:$overline->bothOverLineNum/$overlineCount;
        }

        //全校总计
        $overLineReport = SeExamReportOverline::findBySql("SELECT subjectId , SUM(bothOverLineNum) bothOverLineNum  ,SUM(singleNotOverLineNum) singleNotOverLineNum  FROM se_exam_reportOverline ".
            "WHERE schoolExamId = :examId GROUP BY subjectId",[':examId'=>$schoolExamId])->orderBy('subjectId')->all();

        $totalOverlineArr = [];
        if(empty($overLineReport)){
            $totalOverlineArr['totalOverLine'] = 0;
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
        $onlineNum = $this->onlineNum($schoolExamId,$classId);

        if(app()->request->isAjax){
            return $this->renderPartial('statistics',['examId'=>$schoolExamId,'examClass'=>$examClass,'onlineNum'=>$onlineNum]);
        }

        return $this->render('index',['examId'=>$schoolExamId,'examClass'=>$examClass,'onlineNum'=>$onlineNum,

            'seExamSubject'=>$seExamSubject ,'data'=>$overlineArr ,'totalOverlineArr'=>$totalOverlineArr,'examName'=>$examName]);

    }


    /**
     * 上线数图表数据
     * @param int $examId 考试ID
     * @param int $classId 班级ID
     * @return array
     */
    public function onlineNum(int $examId, int $classId){

        //查询科目
       $subjectId = SeExamSubject::find()->select('subjectId')->where(['schoolExamId'=>$examId])->all();
        $onlineNum = [];
        foreach($subjectId as $key => $subject){
            $onlineNum[$key]['name'] = $subject->subjectId;
            if(empty($classId)){
                $examReport = SeExamReportOverline::findBySql("SELECT subjectId,SUM(bothOverLineNum) bothOverLineNum ,SUM(singleOverLineNum) singleOverLineNum ,SUM(singleNotOverLineNum) singleNotOverLineNum ,SUM(bothNotOverLineNum) bothNotOverLineNum FROM se_exam_reportOverline ".
                    "WHERE schoolExamId = :examId GROUP BY subjectId",[':examId'=>$examId])->all();
            }else{
                $examReport = SeExamReportOverline::findBySql("SELECT subjectId,bothOverLineNum ,singleOverLineNum ,singleNotOverLineNum ,bothNotOverLineNum FROM se_exam_reportOverline ".
                    "WHERE schoolExamId = :examId AND classId = :classId",[':examId'=>$examId,':classId'=>$classId])->all();

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
<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 16:47
 */

namespace frontend\modules\classstatistics\controllers;

use common\business\homework\ClassContrastModel;
use common\helper\ExcelHelper;
use common\helper\MathHelper;
use common\models\pos\SeClass;
use common\models\pos\SeExamClass;
use common\models\pos\SeExamPersonalScore;
use common\models\pos\SeExamReportBaseInfo;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamSubject;
use frontend\components\ClassesBaseController;
use schoolmanage\components\helper\GradeHelper;
use yii\data\Pagination;

class DefaultController extends ClassesBaseController
{
    public $layout = '@app/views/layouts/lay_new_classstatistic_v2';
    public $enableCsrfValidation = false;

    /**
     * 班级统计首页
     * @param integer $classId
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionIndex(int $classId)
    {
        $proFirstime = microtime(true);
        $this->getClassModel($classId);
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;

        $year = app()->request->get('examYear', null); //获取 年份
        $examType = app()->request->get('examType', null); //获取考试类型

        $examClassData = SeExamClass::find()->where(['classId'=>$classId])->all();

        $classData = SeClass::find()->where(['classId'=>$classId])->one();
        $department = (string)$classData->department;
        $gradeId = $classData->gradeID;
        $schoolId = $classData->schoolID;

        $gradeArr = explode(',',(string)$gradeId);
        //根据年级 获取 年份列表
        $yearArr = GradeHelper::getYearList($gradeArr, $schoolId,$department);

        if(empty($examClassData)){
            return $this->render('exam_blank', [
                'yearArr'=>$yearArr,
                'classId' => $classId
            ]);
        }

        $schoolExamId = [];
        foreach($examClassData as $examClass){
            $schoolExamId[] = $examClass->schoolExamId;
        }

        $examSchoolQuery = SeExamSchool::find()->where(['in','schoolExamId',$schoolExamId]);

        //年份筛选
        if (!empty($year)) {
            $examSchoolQuery->andWhere(['schoolYear' => $year]);
        }
        //考试筛选
        if (!empty($examType)) {
            $examSchoolQuery->andWhere(['examType' => $examType]);
        }

        $pages->totalCount = $examSchoolQuery->count();
        $examSchoolModel = $examSchoolQuery->orderBy('createTime desc')
            ->andWhere(['reportStatus' => 2])
            ->offset($pages->getOffset())
            ->limit($pages->getLimit())
            ->all();


        \Yii::info('班级统计 '.(microtime(true)-$proFirstime),'service');
        if (app()->request->isAjax) {
            return $this->renderPartial('_index_exam_right_list',
                ['examSchoolModel' => $examSchoolModel,'classId'=>$classId,'pages' => $pages]);
        }
        return $this->render('index', [
            'examSchoolModel' => $examSchoolModel,
            'classId'=>$classId,
            'yearArr'=>$yearArr,
            'examType'=>$examType,
            'pages' => $pages
        ]);
    }

    /**
     * @param integer $classId
     * @return string 统计概览
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * 统计概览
     */
    public function actionOverview(int $classId)
    {
        $proFirstime = microtime(true);
        $schoolExamId = (int)app()->request->get('examId');

        $subjectId = (int)app()->request->get('subjectId', '');
        $this->getClassModel($classId);

        //查询班级
        $examClass = SeExamClass::find()->where(['schoolExamId' => $schoolExamId])->all();
        //查询当前考试下科目
        $seExamSubject = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->all();

        $rankListDesc=[];
        $rankListAsc=[];

        if (!empty($classId) && !empty($subjectId)) { //单年级，单科目
            $data = SeExamReportBaseInfo::getSingleClassSingleSubjectInfo($schoolExamId, $classId, $subjectId);
            $seExamReprotBaseInfoList = $data['seExamReprotBaseInfoList'];
            $rankListDesc = $data['rankListDesc'];
            $rankListAsc = $data['rankListAsc'];

        } elseif (empty($classId) && !empty($subjectId)) { //全部年级单科目
            $seExamReprotBaseInfoList = SeExamReportBaseInfo::getAllClassSingleSubjectInfo($schoolExamId, $subjectId);
            $rankListDesc = [];
            $rankListAsc = [];
        } elseif (!empty($classId) && empty($subjectId)) { //单年级全部科目
            $seExamReprotBaseInfoList = SeExamReportBaseInfo::getSingleClassAllSubjectInfo($schoolExamId, $classId);
        } else {  //全部年级全部科目

            $seExamReprotBaseInfoList = SeExamReportBaseInfo::getAllClassAllSubjectInfo($schoolExamId);

        }

        //查询考试标题
        $examSchoolData = SeExamSchool::find()->where(['schoolExamId' => $schoolExamId])->one();
        if (!empty($examSchoolData)) {
            $examName = $examSchoolData->examName;
        }

        //班级总分分数段占比
        $scoreSectionCount = $this->classTotalScore($schoolExamId, $classId, $subjectId);
        $section = [];
        $count = [];
        $allCount = 0;
        foreach ($scoreSectionCount as $v) {
            $allCount += $v['total'];
        }

        foreach ($scoreSectionCount as $k => $v) {
            if($k == 0){
                $section[] = '[' . $v['min'] . ',' . $v['max'] . ']';
            }else{
                $section[] = '(' . $v['min'] . ',' . $v['max'] . ']';
            }
            $count[] = sprintf('%.2f', MathHelper::division($v['total'], $allCount) * 100);
        }
        \Yii::info('统计概览 '.(microtime(true)-$proFirstime),'service');
        if (app()->request->isAjax) {
            if (!empty($subjectId)) {
                return $this->renderPartial('_score_overview_info', [
                    'seExamReprotBaseInfoList' => $seExamReprotBaseInfoList,
                    'subjectId' => $subjectId,
                    'classId' => $classId,
                    'examId' => $schoolExamId,
                    'section' => $section,
                    'count' => $count,
                    'rankListDesc' => $rankListDesc,
                    'rankListAsc' => $rankListAsc
                ]);
            } else {
                return $this->renderPartial('_score_overview_info', [
                    'seExamReprotBaseInfoList' => $seExamReprotBaseInfoList,
                    'subjectId' => $subjectId,
                    'classId' => $classId,
                    'examId' => $schoolExamId,
                    'section' => $section,
                    'count' => $count,
                ]);
            }

        }

        return $this->render('score_overview', [
            'seExamReprotBaseInfoList' => $seExamReprotBaseInfoList,
            'examClass' => $examClass,
            'seExamSubject' => $seExamSubject,
            'subjectId' => $subjectId,
            'classId' => $classId,
            'examId' => $schoolExamId,
            'section' => $section,
            'count' => $count,
            'examName' => $examName
        ]);
    }

    /**
     * 班级总分分数段占比
     * @param integer $examId   学校考试id
     * @param integer $classId 班级id
     * @param integer $subjectId 科目id
     * @return array
     */

    public function classTotalScore($examId, $classId, $subjectId)
    {


        $examClassModel = SeExamClass::find()->where(['schoolExamId' => $examId]);
        if (!empty($classId)) {
            $examClassModel->andWhere(['classId' => $classId]);
        }
        $examClassData = $examClassModel->all();
        $data = [];
        foreach ($examClassData as $v) {
            $personalScore = SeExamPersonalScore::find()->where(['classExamId' => $v->classExamId])->all();
            foreach ($personalScore as $v1) {
                if (!empty($subjectId)) {

                    $data[] = ExcelHelper::getSubjectScore($subjectId, $v1);

                } else {
                    $data[] = $v1->totalScore;
                }

            }
        }
        if (!empty($subjectId)) {
            $examSubject = SeExamSubject::find()->where(['schoolExamId' => $examId, 'subjectId' => $subjectId])->one();
            if (!empty($examSubject)) {
                $totalScore = $examSubject->fullScore;
            }
            $scoreSection = 10;

            $scoreSectionCount = $this->scoreSectionCount($data, $scoreSection, $totalScore);
        } else {
            $examSubject = SeExamSubject::find()->select(['fullScore'])->where(['schoolExamId' => $examId])->all();
            $totalScore = 0;
            if (!empty($examSubject)) {
                foreach ($examSubject as $v) {
                    $totalScore += $v->fullScore;
                }
            }
            $scoreSection = 50;
            $scoreSectionCount = $this->scoreSectionCount($data, $scoreSection, $totalScore);
        }

        //data : ['[0,50]','[50,100]','[100,150]','[150,200]','[200,250]','[250,300]']


        return $scoreSectionCount;

    }


    /**
     * 班级对比
     * @param integer $classId
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionClassesContrast(int $classId)
    {
        $proFirstime = microtime(true);
        $this->getClassModel($classId);
        $schoolExamId = (int)app()->request->get('examId');
        $subjectId = (int)app()->request->get('subjectId');
        $num = app()->request->get('num');


        $examSchool = SeExamSchool::find()->where(['schoolExamId' => $schoolExamId])->one();
        $class = SeExamClass::find()->where(['schoolExamId' => $schoolExamId])->select('classExamId,schoolExamId,classId')->all();
        //显示科目
        $subject = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->select('subjectId')->column();
        $classModel=new ClassContrastModel();
        $subList = $classModel->showSubject($subject);

        if (empty($subjectId)) {
            //总成绩
            $dataList = $classModel->classSumScore($class, $schoolExamId);
            //优良率
            $contrastList = $classModel->classGoodNum($class, $schoolExamId);
            //及格率
            $passList = $classModel->classPassList($class, $schoolExamId);
            //低分率
            $lowList = $classModel->classLowList($class, $schoolExamId);
            //高分人数对比
            $topList = $classModel->classTopList($class, $schoolExamId);
            //不及格人数对比
            $lowScoreList = $classModel->classNoPassList($class, $schoolExamId);
        } else {
            //单科成绩
            $dataList = $classModel->subjectScoreSum($subjectId, $schoolExamId);
            //优良率
            $contrastList = $classModel->subjectExcellent($schoolExamId, $subjectId);
            //及格率
            $passList = $classModel->subjectNoPass($schoolExamId, $subjectId);
            //低分率
            $lowList = $classModel->subjectLow($schoolExamId, $subjectId);
            //高分人数对比
            $topList = $classModel->subjectTopList($schoolExamId, $subjectId);
            //单科不及格人数对比
            $lowScoreList = $classModel->subjectLowList($schoolExamId, $subjectId);
        }
        \Yii::info('班级对比 '.(microtime(true)-$proFirstime),'service');
        if (app()->request->isAjax) {
            if ($num == 1) {
                return $this->renderPartial('_average_class', ['dataList' => $dataList]);
            } elseif ($num == 2) {
                return $this->renderPartial('_three_contrast_class', ['contrastList' => $contrastList,'passList' => $passList,'lowList' => $lowList]);
            } elseif ($num == 3) {
                return $this->renderPartial('_top_low_class', ['topList' => $topList,'lowScoreList' => $lowScoreList]);
            }

        }
        return $this->render('classes_contrast', [
            'examSchool' => $examSchool,
            'examId' => $schoolExamId,
            'subList' => $subList,
            'dataList' => $dataList,
            'contrastList' => $contrastList,
            'passList' => $passList,
            'lowList' => $lowList,
            'topList' => $topList,
            'classId'=>$classId,
            'lowScoreList' => $lowScoreList]);
    }


    /**
     *
     * 每个分数段的人数
     * @param  $data ,
     * @param  $scoreSection
     * @param $totalScore
     * @return array

     */
    public function scoreSectionCount($data, $scoreSection, $totalScore)
    {
        $num = ceil($totalScore / $scoreSection);
        $scoreSectionData = [];
        for ($i = 0; $i < $num; $i++) {
            $min = $scoreSection * $i;
            $max = $scoreSection * ($i + 1);
            $total = 0;
            if ($i == 0) {
                foreach ($data as $v) {
                    if ($v >= $min && $v <= $max) {
                        ++$total;
                    }
                }
            } else {
                foreach ($data as $v) {
                    if ($i == $num - 1) {
                        $max = $totalScore;
                    }
                    if ($v > $min && $v <= $max) {
                        ++$total;
                    }
                }
            }

            $scoreSectionData[] = ['min' => $min, 'max' => $max, 'total' => $total];
        }

        return $scoreSectionData;
    }

}
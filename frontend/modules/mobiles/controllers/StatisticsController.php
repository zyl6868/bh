<?php
namespace frontend\modules\mobiles\controllers;
use common\controller\YiiController;
use common\business\homework\ClassContrastModel;
use common\business\homework\TeacherContrastModel;
use common\models\pos\SeExamClass;
use common\models\pos\SeExamSchool;

/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 14-11-17
 * Time: 下午3:23
 */
class StatisticsController extends YiiController
{

    public $layout = 'lay_mobile';

    /**
     * @param int $schoolExamId
     * @param string $viewType
     * @param int $subjectId
     * @param int $classId
     * @return string
     * @throws \yii\web\HttpException
     */
    public function  actionIndex($schoolExamId=0,$viewType='',$subjectId=0,$classId=0)
    {
        //学校考试
        $examSchool = SeExamSchool::find()->where(['schoolExamId' => $schoolExamId])->one();
        $class = SeExamClass::find()->where(['schoolExamId' => $schoolExamId])->select('classExamId,schoolExamId,classId')->all();
        if (empty($examSchool)) {
            return $this->notFound('考试不存在');
        }

        $classModel = new ClassContrastModel();
        $teacherModel=new TeacherContrastModel();
        if(!empty($subjectId)){
            $allData=$teacherModel->teacherData($subjectId,$schoolExamId);
            $list=$teacherModel->pubTeacherList($allData,$schoolExamId,$subjectId);
        }

        if (empty($subjectId)) {
            switch ($viewType) {
                //班级平均分对比
                case 'classes_avg';
                    $classAvgList = $classModel->classSumScore($class, $schoolExamId);
                    break;
                //班级对比优良率
                case 'classes_high';
                    $classGood = $classModel->classGoodNum($class, $schoolExamId);
                    break;
                //班级对比及格率
                case 'classes_middle';
                    $classPass = $classModel->classPassList($class, $schoolExamId);
                    break;
                //班级对比低分率
                case 'classes_low';
                    $classLow = $classModel->classLowList($class, $schoolExamId);
                    break;
                //班级对比高分人数
                case 'classes_high_num';
                    $classTop = $classModel->classTopList($class, $schoolExamId);
                    break;
                //班级对比不及格人数
                case 'classes_low_num';
                    $classNoPass = $classModel->classNoPassList($class, $schoolExamId);
                    break;
                default;
                    return '没有数据';
            }

        } else {
            switch ($viewType) {
                //班级单科平均分对比
                case 'classes_avg';
                    $classAvgList = $classModel->subjectScoreSum($subjectId, $schoolExamId);
                    break;
                //班级单科对比优良率
                case 'classes_high';
                    $classGood = $classModel->subjectExcellent($schoolExamId, $subjectId);
                    break;
                //班级单科对比及格率
                case 'classes_middle';
                    $classPass = $classModel->subjectNoPass($schoolExamId, $subjectId);
                    break;
                //班级单科对比低分率
                case 'classes_low';
                    $classLow = $classModel->subjectLow($schoolExamId, $subjectId);
                    break;
                //班级单科对比高分人数
                case 'classes_high_num';
                    $classTop = $classModel->subjectTopList($schoolExamId, $subjectId);
                    break;
                //班级单科对比不及格人数
                case 'classes_low_num';
                    $classNoPass = $classModel->subjectLowList($schoolExamId, $subjectId);
                    break;
                //教师对比优良率
                case 'teachers_high';
                    $teacherGood=$teacherModel->goodNumList($list);
                    break;
                //教师对比及格率
                case 'teachers_middle';
                    $teacherPass=$teacherModel->noPassList($list);
                    break;
                //教师对比低分率
                case 'teachers_low';
                    $teacherLow=$teacherModel->lowList($list);
                    break;
                //教师对比班级平均上线人数
                case 'teachers_average_online';
                    $teacherOverLine=$teacherModel->overLineNum($list);
                    break;
                default;
                    return '没有数据';
            }

        }

        switch($viewType){
            //班级平均分
            case 'classes_avg';
                return $this->render('class_average', ['classAvgList' => $classAvgList]);
            //班级优良率
            case 'classes_high';
                return $this->render('class_good', ['classGood' => $classGood]);
            //班级及格率
            case 'classes_middle';
                return $this->render('class_pass', ['classPass' => $classPass]);
            //班级低分率
            case 'classes_low';
                return $this->render('class_low', ['classLow' => $classLow]);
            //班级高分人数
            case 'classes_high_num';
                return $this->render('class_top', ['classTop' => $classTop]);
            //班级不及格人数
            case 'classes_low_num';
                return $this->render('class_nopass', ['classNoPass' => $classNoPass]);
            //教师对比优良率
            case 'teachers_high';
                return $this->render('teacher_good',['teacherGood'=>$teacherGood]);
            //教师对比及格率
            case 'teachers_middle';
                return $this->render('teacher_pass',['teacherPass'=>$teacherPass]);
            //教师对比低分率
            case 'teachers_low';
                return $this->render('teacher_low',['teacherLow'=>$teacherLow]);
            //教师对比班级平均上线人数
            case 'teachers_average_online';
                return $this->render('teacher_number',['teacherOverLine'=>$teacherOverLine]);
            default;
                return $this->render('index');
        }

    }

}
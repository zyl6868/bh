<?php
declare(strict_types=1);
namespace schoolmanage\modules\statistics\controllers;

use common\business\homework\TeacherContrastModel;
use common\models\pos\SeExamSchool;
use common\models\pos\SeExamSubject;
use schoolmanage\components\SchoolManageBaseAuthController;

class TeachercontrastController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_statistics_index';
    public $enableCsrfValidation = false;

    /**
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\InvalidParamException
     * 教师对比
     */
    public function actionIndex(){

        $schoolExamId = (int)app()->request->get('examId');
        $this->getSeExamSchoolModel($schoolExamId);
        $examResult=SeExamSchool::find()->where(['schoolExamId'=>$schoolExamId])->one();
        $subjectResult=SeExamSubject::find()->where(['schoolExamId'=>$schoolExamId])->select('subjectId')->all();
            return $this->render('teacher_contrast',['examId'=>$schoolExamId,
                'examResult'=>$examResult,
                'subjectResult'=>$subjectResult
            ]);

    }

    /**
     * 根据科目获取老师和班级
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     */
    public function actionGetTeacherAndClassList(){
        $subjectId = (int)app()->request->getBodyParam('subjectId');
        $schoolExamId = (int)app()->request->getBodyParam('schoolExamId');
        $this->getSeExamSchoolModel($schoolExamId);

        $teacherModel = new TeacherContrastModel();
        $allDataArray = $teacherModel->teacherData($subjectId,$schoolExamId);

        return $this->renderPartial('teacher_and_class_list',['allDataArray'=>$allDataArray]);
    }

    /*
     * 三率对比
     * @return array
     */
    public function actionTeacherContrast(){
        $dataResult = app()->request->getBodyParam('dataResult');
        $examId = (int)app()->request->getBodyParam('schoolExamId');
        $subjectId = (int)app()->request->getBodyParam('subjectId');
        $this->getSeExamSchoolModel($examId);

        $model = new TeacherContrastModel();
        $list = $model->pubList($dataResult,$examId,$subjectId);

        //优良率对比
        $goodNumList = $model->goodNumList($list);
        //及格率
        $passList = $model->noPassList($list);
        // 低分率
        $lowList = $model->lowList($list);
        $overLineNum = $model->overLineNum($list);
        return  $this->renderPartial('_class_echarts',['goodNumList'=>$goodNumList,
            'passList'=>$passList,
            'lowList'=>$lowList,
           'overLineNum'=>$overLineNum
        ]);
    }



}
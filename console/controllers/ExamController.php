<?php
namespace  console\controllers;
use common\helper\DateTimeHelper;
use common\models\pos\SeExamSchool;
use common\models\pos\SeSchoolInfo;
use schoolmanage\components\helper\GradeHelper;
use yii\console\Controller;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/22
 * Time: 10:30
 */
class ExamController extends Controller{


    /**
     *更新seExamSchool表joinYear字段
     */
    public function actionAddJoinYear(){

        $examResult = SeExamSchool::find()->where(['joinYear'=>null])->limit(1000000)->batch(100);

          $i=0;
        foreach($examResult as $examList){

            foreach($examList as $v){

                $schoolId = $v->schoolId;

                $lengthOfSchooling = SeSchoolInfo::find()->where(['schoolID' => $schoolId])->limit(1)->one()->lengthOfSchooling;

                $comingYear = GradeHelper::getComingYearByGrade($v->gradeId, $lengthOfSchooling,DateTimeHelper::timestampDiv1000($v->createTime));

                $v->joinYear = $comingYear;

               var_dump($v->save());
                $i++;
                echo $i;
            }
        }

    }
}
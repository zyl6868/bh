<?php
namespace console\controllers;
use common\models\pos\SeHomeworkAnswerInfo;
use common\models\pos\SeHomeworkAnswerQuestionAll;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/7
 * Time: 10:48
 */
class HomeworkAnswerInfoSyncController extends  Controller{


    /**
     * se_homeworkAnswerInfo 表添加字段correctRate
     *更新se_homeworkAnswerInfo 表的memberTotal字段
     */
    public function actionUpdateCorrentRate(){

        $Result=SeHomeworkAnswerInfo::find()->batch(100);
        foreach($Result as $v){
            foreach($v as $value){

                $questionAllQuery = SeHomeworkAnswerQuestionAll::find()->where(['homeworkAnswerID'=>$value->homeworkAnswerID ,'studentID'=>$value->studentID]);
                $questionAllTotalCount = $questionAllQuery->count();
                $questionAllCorrectCount = $questionAllQuery->andWhere(['correctResult'=>3])->count();
                $correctRate = 0;
                if($questionAllTotalCount != 0){
                    $correctRate = sprintf("%.4f", $questionAllCorrectCount/$questionAllTotalCount)*100;
                }
                $value->correctRate = $correctRate;
                $value->save();
            }

        }
    }



}
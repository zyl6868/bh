<?php
namespace console\controllers;
use common\helper\DateTimeHelper;
use common\models\pos\SeHomeworkAnswerImage;
use common\models\pos\SeHomeworkAnswerQuestionPic;
use yii\console\Controller;
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/11/21
 * Time: 12:00
 */
class ManagetaskController extends  controller{
    public function actionAnswerPicImport(){
          $originalAnswerResult=SeHomeworkAnswerQuestionPic::find()->select('homeworkAnswerID,answerUrl')->all();
        $result=true;
        foreach($originalAnswerResult as $k=>$v){
            echo $k;
            $isExist=SeHomeworkAnswerImage::find()->where(['homeworkAnswerID'=>$v->homeworkAnswerID,'url'=>$v->answerUrl])->exists();
            $newAnswerModel=new SeHomeworkAnswerImage();
            if(!$isExist){
            $newAnswerModel->homeworkAnswerID=$v->homeworkAnswerID;
            $newAnswerModel->url=$v->answerUrl;
            $newAnswerModel->createTime=(string)DateTimeHelper::timestampX1000();
            if(!$newAnswerModel->save()){
                $result=false;
                break;
            }
        }
        }
        echo  $result;
    }
    public function actionTest(){
        echo 111;
    }
}
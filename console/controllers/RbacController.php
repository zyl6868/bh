<?php
namespace console\controllers;

use common\models\pos\SeAnswerQuestion;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {

    }
    public function actionTest(){
  $answerQuestionList=   SeAnswerQuestion::find()->all();
        echo time();
        foreach($answerQuestionList as $item)
        {
        echo      $item->aqName;

        }

        echo time();
    }
}
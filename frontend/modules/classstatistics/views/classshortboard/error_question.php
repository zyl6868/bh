<?php

use yii\helpers\Html;
use yii\helpers\Url;


if(!empty($testQuestionList)){
    foreach($testQuestionList as $value){
        $item = $value['questionDetails'];
        $num = $value['num'];
        echo $this->render('_itemPreviewType', ['item' => $item, 'num' => $num]);
    }
}
?>
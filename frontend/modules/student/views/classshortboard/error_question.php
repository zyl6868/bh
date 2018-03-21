<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 2016/10/11
 * Time: 10:10
 */
if(!empty($testQuestionList)){
    foreach($testQuestionList as $value){
        $item = $value['questionDetails'];
        $num = $value['num'];
        echo $this->render('_itemPreviewType', ['item' => $item, 'num' => $num]);
    }
}
?>
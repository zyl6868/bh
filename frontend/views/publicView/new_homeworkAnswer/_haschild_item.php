<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/14
 * Time: 14:44
 */

?>

<?php
if(!isset($objectiveAnswer)){
    $objectiveAnswer=null;
}
if ($childList) {
    foreach ($childList as $key => $i) {
        echo $this->render('//publicView/new_homeworkAnswer/_itemChildAnswerType', ['item' => $i, 'no' => $key + 1, 'mainId' => $mainId, 'isAnswered'=>$isAnswered , 'homeworkData' => $homeworkData,'objectiveAnswer' => $objectiveAnswer]);
    }
 }
?>

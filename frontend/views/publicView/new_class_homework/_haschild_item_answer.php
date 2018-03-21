<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 11:50
 */
?>

<?php    if (!empty($childList)) {
    ?>
    <div class="quest sub_quest">
        <?php
        foreach ($childList as $key => $i) {
            echo $this->render('//publicView/new_class_homework/_itemChildAnswerType', ['item' => $i, 'no' => $key + 1, 'mainId' => $mainId, 'homeworkData' => $homeworkData]);
        }
        ?>
    </div>
<?php } ?>
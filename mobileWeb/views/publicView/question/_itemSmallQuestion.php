<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 11:52
 */
/* @var $this yii\web\View */
/* @var $item common\models\sanhai\ShTestquestion*/
/*
49  209	题型显示	1	单选题	1
50	209	题型显示	2	多选题	1
51	209	题型显示	3	填空题	1
52	209	题型显示	4	问答题	1
53	209	题型显示	5	应用题	1
96	209	题型显示	7	阅读理解	1
95	209	题型显示	6	完形填空	1
*/

use common\models\sanhai\ShTestquestion;
use frontend\components\helper\StringHelper;

if (!isset($no)) {
    $no = '';
}
$showType = $item->showType;
?>

<div class="pd25 small">

    <div class="Q_title clearfix">
        <p><?php echo StringHelper::htmlPurifier($item->processContent()) ?></p>
    </div>

    <?php if ($showType == ShTestquestion::QUESTION_DAN_XUAN_TI || $showType == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
        <div class="Q_cont">
            <?php
            if ($item->jsonAnswer != '' && $item->jsonAnswer != null) {
                echo $item->homeworkQuestionContent();
            }
            ?>
        </div>
    <?php } ?>
    <?php if ($showType == ShTestquestion::QUESTION_PAN_DUAN_TI) { ?>
        <div class="Q_cont">
            <?php
            echo $item->getJudgeQuestionContent();
            ?>
        </div>
    <?php } ?>
    <?php if ($showType == ShTestquestion::QUESTION_KE_PAN_LIAN_XIAN_TI) { ?>
        <div class="Q_cont">
            <?php
            echo $item->getConnectionQuestionContent();
            ?>
        </div>
    <?php } ?>


</div>


<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/11
 * Time: 19:02
 */
/* @var $this yii\web\View */
/* @var $questionModel common\models\sanhai\ShTestquestion*/
use common\helper\StringHelper;
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;

$showType = $questionModel->getQuestionShowType();
?>
<div class="pd25 big">

    <div class="Q_title clearfix">
        <p><?php echo $questionModel->processContent() ?></p>
    </div>

    <?php if ($showType == ShTestquestion::QUESTION_DAN_XUAN_TI || $showType == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
        <div class="Q_cont">
            <?php
            if ($questionModel->jsonAnswer != '' && $questionModel->jsonAnswer != null) {
                echo $questionModel->homeworkQuestionContent();
            }
            ?>
        </div>
    <?php } ?>

    <?php if ($showType == ShTestquestion::QUESTION_PAN_DUAN_TI) { ?>
        <div class="Q_cont">
            <?php
            echo $questionModel->getJudgeQuestionContent();
            ?>
        </div>
    <?php } ?>


    <?php if ($showType == ShTestquestion::QUESTION_KE_PAN_LIAN_XIAN_TI) { ?>
        <div class="Q_cont">
            <?php
            echo $questionModel->getConnectionQuestionContent();
            ?>
        </div>
    <?php } ?>

    <?php if ($showType == ShTestquestion::QUESTION_KE_PAN_YING_YONG_TI ||$showType == ShTestquestion::QUESTION_BU_KE_PAN_YING_YONG_TI) { ?>
        <?php
        $smallQuestion = $questionModel->getQuestionChildCache();
        if (!empty($smallQuestion)) {
            echo $this->render('//publicView/questionInterface/_itemListQuestion', ['smallQuestion' => $smallQuestion]);}
        ?>
    <?php } ?>


    <div class="A_cont">
        <p><em>答案：</em><?php echo StringHelper::replacePath($questionModel->getNewAnswerContent()); ?></p>
    </div>
</div>


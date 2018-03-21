<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/14
 * Time: 15:11
 */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;

$showType = $item->getQuestionShowType();
$isMaster = $item->getQuestionChildCache();
?>
<div id="<?= $item->id ?>" class="quest sub_quest">
    <div class="sUI_pannel quest_title">
        <div class="pannel_l"><h5>
                <b><?php echo $homeworkData->getQuestionNo($item->id) ?></b><?= !empty($item->tqtid) ? WebDataCache::getQuestionTypename((int)$item->tqtid) : '' ?>
            </h5></div>
    </div>
    <div class="pd25">

        <div class="Q_title clearfix">
            <p><?php echo StringHelper::htmlPurifier($item->processContent()) ?></p>
        </div>

        <?php if ($showType == ShTestquestion::QUESTION_DAN_XUAN_TI || $showType == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
            <div class="Q_cont">
                <?php
                if ($item->jsonAnswer != '' && $item->jsonAnswer != null) {
                    echo   $item->homeworkQuestionContent();
                }
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
</div>



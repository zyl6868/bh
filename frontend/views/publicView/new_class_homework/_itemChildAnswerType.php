<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 11:52
 */

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
use common\components\WebDataCache;

if (!isset($no)) {
    $no = '';
}
/** @var common\models\sanhai\ShTestquestion $item */
if(!empty($item)){
    /** @var common\models\sanhai\ShTestquestion $item */
    $showType = $item->getQuestionShowType();
?>

    <div class="sUI_pannel quest_title">
        <div class="pannel_l">
            <h5>
                <b><?php echo $homeworkData->getQuestionNo($item->id) ?></b><?= !empty($item->tqtid) ? WebDataCache::getQuestionTypename((int)$item->tqtid) : '' ?>
            </h5>
        </div>
    </div>
    <div class="pd25">

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
<?php }?>

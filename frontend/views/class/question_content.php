<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/11/20
 * Time: 11:59
 */
use common\components\WebDataCache;

?>
<i class="v_r_arrow"></i>
<div class="testPaperView">
    <div class="paper">
        <?php echo $this->render('//publicView/questionPreview/_itemPreviewType', array('item' => $questionResult)); ?>
        <div class="answerArea">
            <p><em>答案：</em><?php echo $questionResult->getNewAnswerContent(); ?></p>

                <?php if (!empty($questionResult->analytical) && trim(strip_tags($questionResult->analytical)) != '略') { ?>
                    <p><em>解析：</em> <?= $questionResult->analytical; ?>
                <?php } ?></p>

        </div>
    </div>
</div>

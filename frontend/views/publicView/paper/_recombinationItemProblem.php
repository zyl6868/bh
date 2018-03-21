<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-12-12
 * Time: 下午4:14
 */
use common\components\WebDataCache;

?>

<div class="paper">
    <button type="button" id="<?php   echo $item->id; ?>" pid="Q_<?php echo $item->tqtid ?>"
            class="editBtn addBtn">组卷
    </button>
    <?php echo $this->render('//publicView/paperReview/_itemProblemType', array('item' => $item)); ?>
    <div class="btnArea clearfix"><span class="openAnswerBtn fl">查看答案与解析<i class="open"></i></span> <span
            class="r_btnArea fr"><?php if ($item->complexity) { ?> 难度:
                <em><?php  echo WebDataCache::getDictionaryName($item->complexity); ?></em><?php } ?>
            &nbsp;&nbsp;&nbsp;<?php if ($item->operater) { ?> 录入:<?php echo WebDataCache::getTrueNameByuserId($item->operater); ?><?php } ?></span>
    </div>
    <div class="answerArea hide">
        <p><em>答案:</em>
            <span><?php echo $this->render('//publicView/paper/_itemProblemAnswer', array('item' => $item)); ?></span>
        </p>

        <p><em>解析:</em>
            <?php echo $item->analytical; ?>
        </p>
    </div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-12-12
 * Time: 下午4:14
 */
use frontend\components\helper\StringHelper;

?>
<!--选择题-->

<!--<div class="testpaper">-->
<!--    --><?php //echo $this->render('//publicView/paper/_itemProblemType', array('item' => $item)); ?>
<!--    <div class="btnArea clearfix"><span class="openAnswerBtn fl">查看答案与解析<i-->
<!--                class="open"></i></span> <span-->
<!--            class="r_btnArea fr">难度:<em>--><?php //echo $item->complexityText ?><!--</em>&nbsp;&nbsp;&nbsp;</span>-->
<!--    </div>-->
<!--    <div class="answerArea hide">-->
<!--        <p><em>答案:</em>-->
<!--            <span>--><?php //echo $this->render('//publicView/paper/_itemProblemAnswer', array('item' => $item)); ?><!--</span>-->
<!--        </p>-->
<!---->
<!--        <p><em>解析:</em>-->
<!--       8668593     --><?php //echo $item->analytical; ?>
<!--        </p>-->
<!--    </div>-->
<!--</div>-->




<div class="testPaperView pr"><!--选择题-->
    <div class="paperArea">
        <div class="paper">
            <?php if($item->operater ==user()->id){ ?>
                <span class="font14 provenance">我的试题库</span>
           <?php  }else{ ?>
                <span class="font14 provenance">平台试题库</span>
           <?php  }?>

    <?php echo $this->render('//publicView/paper/_itemProblemType', array('item' => $item)); ?>
    <div class="btnArea clearfix"><span class="openAnswerBtn fl">查看答案与解析<i
                class="open"></i></span> <span
            class="r_btnArea fr">难度:<em><?php echo $item->complexityText ?></em>&nbsp;&nbsp;&nbsp;</span>
    </div>
    <div class="answerArea hide">
        <p><em>答案:</em>
            <span><?php echo $this->render('//publicView/paper/_itemProblemAnswer', array('item' => $item)); ?></span>
        </p>

        <p><em>解析:</em>
            <?php echo StringHelper::htmlPurifier($item->analytical); ?>
        </p>
    </div>
        </div>
    </div>
</div>
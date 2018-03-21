<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-12-12
 * Time: 下午4:14
 */
use frontend\components\helper\StringHelper;

?>
<div class="paperArea">
<div class="paper" style="padding-left:20px;">
    <?php echo $this->render('//publicView/online/_itemProblemType', array('item' => $item,'homeworkAnswerID'=>$homeworkAnswerID)); ?>
    <div class="btnArea clearfix"><span class="openAnswerBtn fl">查看答案与解析<i class="open"></i></span> <span
            class="r_btnArea fr">难度:<em><?php echo $item->complexityText ; ?></em>&nbsp;&nbsp;&nbsp;录入:<?php echo $item->operaterName; ?></span>
    </div>
    <div class="answerArea hide">
        <p><em>答案:</em>
            <span><?php echo $this->render('//publicView/online/_itemProblemAnswer', array('item' => $item)); ?></span>
        </p>

        <p><em>解析:</em>

            <?php
			if(!empty($item->questionList)){
				foreach ($item->questionList as $val) {
					echo StringHelper::htmlPurifier($val->analytical);
				}
			}else{
				echo StringHelper::htmlPurifier($item->analytical);
			}
			?>
        </p>
    </div>
</div>
<hr>
</div>
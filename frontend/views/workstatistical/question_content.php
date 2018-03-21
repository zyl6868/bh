<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/11/20
 * Time: 11:59
 */
use common\models\sanhai\ShTestquestion;
use common\components\WebDataCache;

?>
<div class="testPaper">
<div class="testPaperView">
<div class="paper">
    <div class="quest" data-content-id="<?= $questionResult->id ?>">
        <div class="sUI_pannel quest_title">
            <div class="pannel_l">
                <span class="Q_t_info">
                    <em>试题编号：<?php echo $questionResult->id ?></em>
                </span>
            </div>
            <div class="pannel_r"></div>
        </div>

        <?php echo  $this->render('//publicView/topic_preview/_itemPreviewDetail',['item'=>$questionResult]) ?>

        <?php if($showType ==ShTestquestion::QUESTION_DAN_XUAN_TI || $showType == ShTestquestion::QUESTION_DUO_XUAN_TI ):?>
            <?php if(!empty($student)):?>
                <div class="stu_answer">Ta的答案:
                    <span>
                        <?php
                        if(empty($answerOption) && $answerOption !== '0'){
                            echo "未答";
                        }else {
                            $answerOption = explode(',', $answerOption);
                            foreach ($answerOption as $option) {
                                echo \frontend\components\helper\LetterHelper::getLetter($option);
                            }
                        }
                        ?>
                    </span>
                </div>
            <?php else:?>
                <div class="answerAnaly">答案分析:
                    <?php foreach($allOptions as $key => $v):?>
                        <span><?php
                            if(empty($key) && $key !== 0){
                                echo "未答";
                            }else {
                                $options = explode(',',$key);
                                foreach($options as $option){
                                    echo \frontend\components\helper\LetterHelper::getLetter($option);
                                }
                            }
                            ?><br>
                            <b><?php echo sprintf("%.1f", ($v/$optionCountSum)*100)?>%</b>
                        </span>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        <?php endif;?>
    </div>
</div>
</div>
</div>

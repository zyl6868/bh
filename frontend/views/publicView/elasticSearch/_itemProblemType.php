<?php

/* @var $this yii\web\View */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-12-12
 * Time: 下午4:14
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
?>

<?php
if ($item->showType ==null) {
    ViewHelper::emptyView();
}else{?>
    <h5>题 <?php echo $item->id ?></h5>
    <h6> <?php if($item->year):?>
            【<?php echo $item->year ?>
            年】
        <?php endif; ?>&nbsp;<?php echo WebDataCache::getDictionaryName($item->provenance) ?>  <?php echo WebDataCache::getDictionaryName($item->tqtid) ?></h6>
    <?php if ($item->showType == ShTestquestion::QUESTION_DAN_XUAN_TI || $item->showType == ShTestquestion::QUESTION_DUO_XUAN_TI) {
        ?>
        <p><?php echo StringHelper::htmlPurifier($item->content) ?></p>
        <div class="checkArea">
            <?php
            $childQuestion=$item->getQuestionChildCache();
            if(!empty($childQuestion)){
                ?>
                <ul class="sub_Q_List">
                    <li>
                        <?php
                        foreach ($childQuestion as $key => $i) {
                            echo $this->render('//publicView/elasticSearch/_itemChildProblemType', array('item' => $i, 'no' => $key+1));
                        }
                        ?>
                    </li>
                </ul>
            <?php }else{?>
                <?php
                $result = json_decode($item->answerOption);
                $result= empty($result)?array():$result;
                try {

                    $select = (from($result)->select(function ($v) {
                        if( isset($v->id) && isset( $v->content)){
                            return '<label><em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;' . StringHelper::htmlPurifier($v->content).'</label>';
                        }
                        return '';
                    }, '$k')->toArray());
                    foreach($select as $v1)
                    {
                        echo  $v1;
                    }
                }catch(Exception $e) {
                    \Yii::error('多选题答案备选项失败错误信息' . '------' . $e->getMessage());
                }  }
            ?>
        </div>
    <?php } ?>

    <?php if ($item->showType == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
        <p><?php echo StringHelper::htmlPurifier($item->content); ?></p>
        <div class="checkArea">
            <?php if(empty($item->smallQuestion)) { ?>
            <?php } else {
                foreach ($item->smallQuestion as $key => $i) {
                    ?>
                    <p><label><?php echo $key+1 ?>、<?php echo  StringHelper::htmlPurifier($i->content) ?> </label></p>
                <?php }
            }
            ?>
        </div>
    <?php } ?>


    <?php if ($item->showType == ShTestquestion::QUESTION_JIE_DA_TI ) { ?>
        <p><?php echo StringHelper::htmlPurifier($item->content) ?></p>
        <?php
        $childQuestion=$item->getQuestionChildCache();
        if(!empty($childQuestion)){
            ?>
            <ul class="sub_Q_List">
                <li>
                    <?php
                    foreach ($childQuestion as $key => $i) {
                        echo $this->render('//publicView/elasticSearch/_itemChildProblemType', array('item' => $i, 'no' => $key+1));
                    }
                    ?>
                </li>
            </ul>
        <?php }?>
    <?php } ?>

    <?php
    if ($item->showType == ShTestquestion::QUESTION_PAN_DUAN_TI) { ?>
        <p><?php echo $item->content ?></p>
        <?php
        $childQuestion=$item->getQuestionChildCache();
        if(!empty($childQuestion)){
            ?>
            <ul class="sub_Q_List">
                <li>
                    <?php
                    foreach ($childQuestion as $key => $i) {
                        echo $this->render('//publicView/elasticSearch/_itemChildProblemType', array('item' => $i, 'no' => $key+1));
                    }
                    ?>
                </li>
            </ul>
        <?php }
    }
   } ?>


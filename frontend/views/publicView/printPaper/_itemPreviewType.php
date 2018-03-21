<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 15-1-13
 * Time: 下午5:08
 */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\StringHelper;

?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI || $item->showTypeId == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>

   <p> <strong>题<?php  echo   $no?:''  ?>、</strong><?php echo $item->content ?></p>
    <p>
        <?php
        $result = json_decode($item->answerOption);
        $result=$result==null?array():$result;
        $select = (from($result)->each(function ($v) {
            echo    ''.LetterHelper::getLetter($v->id) . '、' . StringHelper::html_strip_tags(['p','br'], $v->content).'          ';
        }, '$k'));
        ?>
    </p>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
    <strong>题<?php  echo   $no?:''  ?>、</strong><?php echo $item->content ?>
    <p>
        <?php if (empty($item->childQues)) { ?>
            <p><label>填空</label><input type="text" class="text" name="item[<?php $item->questionId ?>]" title=""/></p>
        <?php } else {
            foreach ($item->childQues as $key => $i) {
                ?>
                <p><label><?php echo $key+1 ?>、<?php echo  $i->content ?> </label><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p>
            <?php }
        }
        ?>
    </p>
<?php } ?>


<?php if ($item->showTypeId == ShTestquestion::QUESTION_JIE_DA_TI) { ?>
    <p>
    <strong>题<?php  echo   $no?:''  ?>、</strong>
    <strong> <?php if(isset($item->questiontypename)){echo $item->questiontypename;} ?></strong></p>
    <?php echo $item->content ?>
    <ul class="sub_Q_List">
        <li>
            <?php
            if (isset($item->childQues)) {
                foreach ($item->childQues as $key => $i) {
                    echo $this->render('//publicView/printPaper/_itemChildPreviewType', array('item' => $i, 'no' => $key + 1));
                }
            }
            ?>
        </li>
    </ul>
<?php } ?>


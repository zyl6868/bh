<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 15-1-13
 * Time: 下午5:08
 */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;

?>

<?php if ($item->showTypeId ==null) {
   ViewHelper::emptyView();
}?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI || $item->showTypeId == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
    <h5>题 <?php echo $item->questionId ?></h5>
    <h6>【<?php echo $item->year ?>
        年】 <?php if(isset($item->provenanceName)){echo $item->provenanceName;} ?>  <?php if(isset($item->questiontypename)){echo $item->questiontypename;} ?></h6>
    <p><?php echo $item->content ?></p>
    <div class="checkArea">
        <?php
        $result = json_decode($item->answerOption);
        $result=$result==null?array():$result;
        $select = (from($result)->select(function ($v) {
	        return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content.'</p>';
        }, '$k')->toArray());
        if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
            echo Html::radioList('item[' . $item->questionId . ']', '', $select, array('separator' => '','class'=>'radio','encode'=>false));
        } else {
            echo Html::checkboxList('item[' . $item->questionId . ']', '', $select, array('separator' => '','class'=>'checkbox','encode'=>false));
        }
        ?>
    </div>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
    <h5>题 <?php echo $item->questionId ?></h5>
    <h6>【<?php echo $item->year ?>
        年】 <?php if(isset($item->provenanceName)){echo $item->provenanceName;} ?>  <?php if(isset($item->questiontypename)){echo $item->questiontypename;} ?></h6>
    <p><?php echo $item->content ?></p>
    <div class="checkArea">
        <?php if (empty($item->childQues)) { ?>
            <p><label>填空</label><input type="text" class="text" name="item[<?php $item->questionId ?>]" title=""/></p>
        <?php } else {
            foreach ($item->childQues as $key => $i) {
                ?>
                <p><label><?php echo $key+1 ?>、<?php echo  $i->content ?> </label><input type="text" class="text" name="item[<?php $i->questionId ?>]"/></p>
            <?php }
        }
        ?>
    </div>
<?php } ?>


<?php if ($item->showTypeId == ShTestquestion::QUESTION_JIE_DA_TI ) { ?>
    <h5>题 <?php echo $item->questionId ?></h5>
    <h6>【<?php echo $item->year ?>
        年】 <?php if(isset($item->provenanceName)){echo $item->provenanceName;} ?>  <?php if(isset($item->questiontypename)){echo $item->questiontypename;} ?></h6>
    <p><?php echo $item->content ?></p>
    <ul class="sub_Q_List">
        <li>
            <?php
            if (isset($item->childQues)) {
                foreach ($item->childQues as $key => $i) {
                    echo $this->render('//publicView/paper/_itemChildPreviewType', array('item' => $i, 'no' => $key + 1));
                }
            }
            ?>
        </li>
    </ul>
<?php } ?>



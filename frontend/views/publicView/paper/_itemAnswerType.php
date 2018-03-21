<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-12-15
 * Time: 下午6:44
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
    <div class="bigTitle">
        <input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
        <input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
        <h5>题 <?php echo $item->questionId ?></h5>
        <h6>【<?php echo $item->year ?>
            年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
        <p><?php echo $item->content ?></p>
        <div class="checkArea">
            <?php
            $result = json_decode($item->answerOption);
            $result=$result==null?array():$result;
            $select = (from($result)->select(function ($v) {
	            return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content .'</p>';
            }, '$k')->toArray());
            if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                echo Html::radioList('item[' . $item->questionId . ']', '', $select, array('separator' => '','class'=>'radio','encode'=>false));
            } else {
                echo Html::checkboxList('item[' . $item->questionId . ']', '', $select, array('separator' => '', 'class'=>'checkbox','encode'=>false));
            }
            ?>
        </div>
    </div>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
    <div class="bigTitle">
        <input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
        <input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
        <h5>题 <?php echo $item->questionId ?></h5>
        <h6>【<?php echo $item->year ?>
            年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
        <p><?php echo $item->content ?></p>
        <div class="checkArea">
            <?php if (empty($item->childQues)) { ?>
                <label>回答:</label>
                <p class="addPic">
                    <a href="javascript:" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>
                    <?php
                    $t2 = new frontend\widgets\xupload\models\XUploadForm;
                    echo  \frontend\widgets\xupload\XUploadSimple::widget( array(
                        'url' => \Yii::$app->urlManager->createUrl("upload/header"),
                        'model' => $t2,
                        'attribute' => 'file',
                        'autoUpload' => true,
                        'multiple' => true,
                        'options' => array(
							'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
                            "done" => new \yii\web\JsExpression('done'),
                            "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')

                        ),
                        'htmlOptions' => array(
                            'id' => 't'.$item->questionId,
                        )
                    ));
                    ?>

                </p>
                <ul class="addPicUl addImage clearfix">

                </ul>
            <?php } else {
                foreach ($item->childQues as $key => $i) {
                    ?>
                    <div class="middleTitle">
                        <input type="hidden" class="middleTitleID" value="<?php echo $i->questionId?>">
                    <p><label><?php echo $key+1 ?>、<?php echo  $i->content ?> </label>
                        <p class="addPic">
                            <a href="javascript:;" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>
                            <?php
                            $t2 = new frontend\widgets\xupload\models\XUploadForm;
                            echo  \frontend\widgets\xupload\XUploadSimple::widget( array(
                                'url' => \Yii::$app->urlManager->createUrl("upload/header"),
                                'model' => $t2,
                                'attribute' => 'file',
                                'autoUpload' => true,
                                'multiple' => true,
                                'options' => array(
									'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
                                    "done" => new \yii\web\JsExpression('done'),
                                    "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')

                                ),
                                'htmlOptions' => array(
                                    'id' => 't'.$i->questionId,
                                )
                            ));
                            ?>

                        </p>
                        <ul class="addPicUl addImage clearfix">

                        </ul>
                    </p>
                    </div>
                <?php }
            }
            ?>
        </div>
    </div>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_JIE_DA_TI ) { ?>
    <div class="bigTitle">
        <input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
        <input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
        <h5>题 <?php echo $item->questionId ?></h5>
        <h6>【<?php echo $item->year ?>
            年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
        <p><?php echo $item->content ?></p>
        <ul class="sub_Q_List">
            <li>
                <?php if (empty($item->childQues)) { ?>
                    <label>回答:</label>
                    <p class="addPic">
                        <a href="javascript:;" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>
                        <?php
                        $t2 = new frontend\widgets\xupload\models\XUploadForm;
                        echo  \frontend\widgets\xupload\XUploadSimple::widget( array(
                            'url' => \Yii::$app->urlManager->createUrl("upload/header"),
                            'model' => $t2,
                            'attribute' => 'file',
                            'autoUpload' => true,
                            'multiple' => true,
                            'options' => array(
                                'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
                                "done" => new \yii\web\JsExpression('done'),
                                "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')

                            ),
                            'htmlOptions' => array(
                                'id' => 't'.$item->questionId,
                            )
                        ));
                        ?>

                    </p>
                    <ul class="addPicUl addImage clearfix">

                    </ul>
                <?php } else {

                foreach ($item->childQues as $key => $i) {
                    echo $this->render('//publicView/paper/_itemChildAnswerType', array('item' => $i, 'no' => $key+1));
                } }
                ?>
            </li>
        </ul>
    </div>
<?php } ?>

<script>
    done = function (e, data) {

        $.each(data.result, function (index, file) {
            if (!file.error) {
                $(e.target).parent().next(".addImage").append('<li><img   src="' + file.url + '" alt="" height="48" width="50"><i></i><input class="url" type="hidden" value="' + file.url + '" /></li>  ');
            }
            else {
                alert(file.error);
            }

        });

    }
</script>
<style>
    .addPic{ width: 120px;}
    .addImage{ clear: both;}
    .addImage li{ background: none; float: left;}
    .addImage li i{ right: -9px;}

</style>


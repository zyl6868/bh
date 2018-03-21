<?php

/**
 * @var BaseAuthController $this
 */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\LetterHelper;
use yii\helpers\Html;

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

if (!isset($no)) {
    $no = '';
}
?>
<div class="middleTitle">
<?php if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI || $item->showTypeId == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
    <input type="hidden" class="middleTitleID" value="<?php echo $item->questionId ?>" />
    <input type="hidden" class="type" value="<?php echo $item->showTypeId?>">
    <p>小题<?php echo $no ?>: <?php echo $item->content; ?></p>
    <div class="checkArea">
        <?php
        $result = json_decode($item->answerOption);
        $select = (from($result)->select(function ($v) {
	        return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content .'</p>';
        }, '$k')->toArray());
        if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
            echo Html::radioList('item[' . $item->questionId . ']', '', $select, array('separator' => '','class'=>'radio',"encode"=>false));

        } else {
            echo Html::checkboxList('item[' . $item->questionId . ']', '', $select, array('separator' => '', 'class'=>'checkbox',"encode"=>false));

        }
        ?>
    </div>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
    <input type="hidden" class="middleTitleID" value="<?php echo $item->questionId?>">
    <input type="hidden" class="type" value="<?php echo $item->showTypeId?>">
    <p>小题<?php echo $no ?>: <?php echo $item-> content ?></p>
    <div class="checkArea">
        <?php if (empty($item->childQues)) { ?>
            <p><label></label>
            <p class="addPic">
<!--                <a href="javascript:" class="uploadBtn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>-->
				<button type="button" class="uploadBtn">上传答案</button>
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
			<dl class="addPicUl addImage userAnswerList clearfix">
				<dt>您上传的答案:</dt>

			</dl>
            </p>
        <?php } else {
            foreach ($item->childQues as $key => $i) {
                ?>
                <div class="smallTitle">
                    <input type="hidden" class="smallTitleID" value="<?php echo $i->questionId?>"/>
                <p><label><?php echo $key+1 ?>、<?php echo  $i-> content ?> </label>
                    <p class="addPic">
<!--                        <a href="javascript:" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>-->
						<button type="button" class="uploadBtn">上传答案</button>
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
					<dl class="addPicUl addImage userAnswerList clearfix">
						<dt>您上传的答案:</dt>

					</dl>
                </p>
                </div>
            <?php }
        }
        ?>
    </div>
<?php } ?>

</div>



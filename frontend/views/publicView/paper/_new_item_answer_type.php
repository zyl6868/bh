<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/17
 * Time: 15:27
 * 	49  209	题型显示	1	单选题	1
	50	209	题型显示	2	多选题	1
	51	209	题型显示	3	填空题	1
	52	209	题型显示	4	问答题	1
	53	209	题型显示	5	应用题	1
	96	209	题型显示	7	阅读理解	1
	95	209	题型显示	6	完形填空	1
 */
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<?php if ($item->showTypeId ==null) {
	ViewHelper::emptyView();
}?>
<?php
if (!isset($number)) {
	$number = '';
}
?>
<?php if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI || $item->showTypeId == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
	<div class="paper">

		<input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
		<input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
		<h5>题 <?php echo $item->questionId;?> </h5>
		<h6>【<?php echo $item->year ?>年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
		<p><?php echo $item->content ?></p>
		<div class="checkArea">
            <?php
            $showTypeId = $item->showTypeId;
            $op_list = array(
                '0'=>array('id'=>'0','content'=>'A'),
                '1'=>array('id'=>'1','content'=>'B'),
                '2'=>array('id'=>'2','content'=>'C'),
                '3'=>array('id'=>'3','content'=>'D')
            );
            if($item->answerOption == ''){?>
                <?php

                if($showTypeId == '1'){
                    echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
                }elseif($showTypeId == '2'){
                    echo '<li><div class="checkArea">'.Html::checkboxList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
                }
                ?>
            <?php }elseif($item->answerOption == null){?>
                <?php

                if($showTypeId == '1'){
                    echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
                }elseif($showTypeId == '2'){
                    echo '<li><div class="checkArea">'.Html::checkboxList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
                }
                ?>
            <?php }elseif($item->answerOption == '[]'){?>
                <?php

                if($showTypeId == '1'){
                    echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
                }elseif($showTypeId == '2'){
                    echo '<li><div class="checkArea">'.Html::checkboxList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
                }
                ?>
            <?php }else{?>
                <?php
                $result = json_decode($item->answerOption);
                $result=$result==null?array():$result;
                $select = (from($result)->select(function ($v) {
                    return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content.'</p>';
                }, '$k')->toArray());
                if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                    echo Html::radioList('item[' . $item->questionId . ']', '', $select, array('separator' => '','class'=>'radio','encode'=>false));
                } else {
                    echo Html::checkboxList('item[' . $item->questionId . ']', '', $select, array('separator' => '', 'class' =>'checkbox','encode'=>false));
                }
                ?>
            <?php }?>

		</div>
		<br>
		<div style="clear: both"></div>


	</div>
	<hr>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI) { ?>
	<div class="paper">
		<input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
		<input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
		<h5>题 <?php echo  $item->questionId;?></h5>
		<h6>【<?php echo $item->year ?>年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
		<p><?php echo $item->content ?></p>
		<div class="checkArea">
			<?php if (empty($item->childQues)) { ?>
				<label>回答:</label>
				<p class="addPic">
<!--					<a href="javascript:" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>-->
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
			<?php } else { if (isset($item->childQues)){
				foreach ($item->childQues as $key => $i) {
					?>
					<div class="middleTitle">
						<input type="hidden" class="middleTitleID" value="<?php echo $i->questionId?>">
						<p><label><?php echo $key+1 ?>、<?php echo  $i->content ?> </label>
						<p class="addPic">
<!--							<a href="javascript:;" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>-->
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
				<?php }}
			}
			?>
		</div>
	</div>
	<hr>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_JIE_DA_TI ) { ?>
	<div class="paper">
		<input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
		<input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
		<h5>题 <?php echo  $item->questionId;?></h5>
		<h6>【<?php echo $item->year ?>年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
		<p><?php echo $item->content ?></p>
		<ul class="sub_Q_List">
			<li>
				<?php if (empty($item->childQues)) { ?>
					<label>回答:</label>
					<p class="addPic">
<!--						<a href="javascript:;" class="id_btn mini_btn" style="color:#FFF;background: red; width: 80px; text-align: center">上传答案</a>-->
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
				<?php } else {

					foreach ($item->childQues as $key => $i) {
						echo $this->render('//publicView/paper/_itemChildAnswerType', array('item' => $i, 'no' => $key+1));
					} }
				?>
			</li>
		</ul>
	</div>
	<hr>
<?php } ?>

<?php if ($item->showTypeId == ShTestquestion::QUESTION_PAN_DUAN_TI) { ?>
    <div class="paper">

        <input type="hidden" class="bigType" value="<?php echo $item->showTypeId?>">
        <input type="hidden" class="bigTitleID" value="<?php echo $item->questionId?>" />
        <h5>题 <?php echo $item->questionId;?> </h5>
        <h6>【<?php echo $item->year ?>年】 <?php echo $item->provenanceName ?>  <?php echo $item->questiontypename ?></h6>
        <p><?php echo $item->content ?></p>
        <div class="checkArea">
            <?php
            $showTypeId = $item->showTypeId;
            $op_list = array(
                '0'=>array('id'=>'0','content'=>'错'),
                '1'=>array('id'=>'1','content'=>'对'),
            );
            if($item->answerOption == ''){

                    echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
           }elseif($item->answerOption == null){

                    echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';
               }elseif($item->answerOption == '[]'){


                    echo '<li><div class="checkArea">'.Html::radioList("answer[$item->questionId]",'',ArrayHelper::map($op_list,'id','content'),
                            ['class'=>"radio alternative",'qid'=>$item->questionId,'tpid'=>$item->showTypeId,'separator'=>'&nbsp;','encode'=>false]).'</div></li>';


           }else{?>
                <?php
                $result = json_decode($item->answerOption);
                $result=$result==null?array():$result;
                $select = (from($result)->select(function ($v) {
                    return '<em>'.LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content.'</p>';
                }, '$k')->toArray());
                if ($item->showTypeId == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                    echo Html::radioList('item[' . $item->questionId . ']', '', $select, array('separator' => '','class'=>'radio','encode'=>false));
                } else {
                    echo Html::checkboxList('item[' . $item->questionId . ']', '', $select, array('separator' => '', 'class' =>'checkbox','encode'=>false));
                }
                ?>
            <?php }?>

        </div>
        <br>
        <div style="clear: both"></div>


    </div>
    <hr>
<?php } ?>


<script>
$(function(){

        $(".fancybox").fancybox();
	$('#item_<?php echo $item->questionId; ?> input').live("click", function(){
		$(this).parents(".checkArea").siblings(".userAnswerList").children('dd').remove();
		var radioId = $(this).val();
		if(radioId == 0){
			$(this).parents(".checkArea").siblings(".userAnswerList").append("<dd>A</dd>");
		}
		if(radioId == 1){
			$(this).parents(".checkArea").siblings(".userAnswerList").append("<dd>B</dd>");
		}
		if(radioId == 2){
			$(this).parents(".checkArea").siblings(".userAnswerList").append("<dd>C</dd>");
		}
		if(radioId == 3){
			$(this).parents(".checkArea").siblings(".userAnswerList").append("<dd>D</dd>");
		}
	})
})
</script>
<script>
	done = function (e, data) {
		$.each(data.result, function (index, file) {
			if (!file.error) {
				$(e.target).parent().next(".addImage").append('<dd style="position: relative" class="fl"><a class="fancybox"  href="'+file.url + '" ><img src="' + file.url + '" alt="" height="90" width="120"></a><i style=""  class="delBtn"></i><input class="url" type="hidden" value="' + file.url + '" />  </dd>');
			}
			else {
				alert(file.error);
			}
		});
	}
</script>

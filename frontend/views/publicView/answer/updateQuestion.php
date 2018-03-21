<?php
/**
 * Created by Unizk.
 * User: ysd
 * Date: 14-10-31
 * Time: 下午2:41
 */
/* @var $this yii\web\View */
use frontend\components\CHtmlExt;

use frontend\widgets\xupload\models\XUploadForm;
use frontend\widgets\xupload\XUploadRequire;

use yii\web\JsExpression;

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "补充问题";
$this->blocks['requireModule'] = 'app/answer_question/add_question';

$backend_asset = BH_CDN_RES.'/static';
$this->registerCssFile($backend_asset . '/css/add_question.min.css' . RESOURCES_VER);

/** @var frontend\modules\teacher\models\teaQuestionPackForm $model */
?>

<script type="text/javascript">
	$(function () {
		$("#qa_modify").click(function () {
			var img_num = $('.up_test_list.clearfix li').length;
			if (img_num > 7) {
				popBox.errorBox("最多上传6张图片!");
				return false;
			}

			var title_num = UE.getEditor('editor').getContentTxt().length;
			if (title_num > 1000) {
				popBox.errorBox("详情描述超过1000字!");
				return false;
			}

			return true;
		});
		//用于禁止多次提交
		$("form").submit(function () {
			$(":submit", this).attr("disabled", "disabled");
		});
	})
</script>

<div class="cont24">
	<div class="grid24">
		<div class="mag_title">
			<a href="javascript:;" onclick="window.history.go(-1)" class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
			<h4>修改问题</h4>
		</div>
		<?php

		$form = ActiveForm::begin(array('enableClientScript' => false, 'id' => "answer_form"))
		?>
		<div class="content">
			<div class="replen_list form_list clearfix">
				<div class="formL">
					<label for="takeffice"><i class="red">*</i>问题标题：</label>
				</div>
				<div class="textareaBox pr">
					<textarea id="takeffice" style="margin-bottom: 30px;" class="re_input_box JS_textarea takeffice"
					          readonly><?php echo $result->aqName; ?></textarea>

				</div>
			</div>
			<div class="replen_list textareaBox_pro2 form_list clearfix" style="border:none">
				<div class="formL">
					<label><i class="red"></i>详情描述：</label>
				</div>
				<div class="textareaBox pr">
					<textarea id="content" onkeyup="checkLength1(this);" style="width:100%; height:120px"
					          class="text validate[maxSize[1000]]"
					          name="<?php echo Html::getInputName($model, 'detail') ?>"><?php echo $result->aqDetail; ?></textarea>
					<?php echo CHtmlExt::validationEngineError($model, 'detail') ?>

				</div>
			</div>
			<div class="form_list UPF">
				<div class="row">
					<div class="formL">
						<label><i class="red"></i>添加图片:</label>
						<span class="gray_d">最多可添加6张图片</span>
					</div>
					<div class="UPloadFil">
						<?php
						$t1 = new XUploadForm;
						/** @var $this BaseController */
						echo XUploadRequire::widget(array(
								'url' => Yii::$app->urlManager->createUrl("upload/pic"),
								'model' => $t1,
								'attribute' => 'file',
								'autoUpload' => true,
								'multiple' => true,
								'options' => array(
										'acceptFileTypes' => new JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
										"done" => new JsExpression('doneTwo'),
										'maxFileSize' => 4194304,
										"processfail" => new JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')

								),
								'htmlOptions' => array(
										'id' => 'imgupload',
										'class' => 'fileupload',
								)
						));
						?>
						<ul class="clearfix addPicUl">
							<?php
							$images = $result->imgUri;
							if (isset($images) && !empty($images)) {
								$image = explode(',', $images);
								foreach ($image as $val) {
									?>
									<li><input type="hidden" name="imgurls[]" value="<?= $val; ?>">
										<img src="<?= resCdn($val); ?>" alt="">
										<i class="remove_images"></i>
									</li>
								<?php }
							} ?>
							<li id="addimage" class="upload_FileBtn">
								<u class="more"></u>
								<label for="imgupload">
									<div></div>
								</label>
								还可以添加<span id="img_num" class="gray_d">6</span>张
								</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="replen_list form_list clearfix">

				<ul class="che_thr">

				</ul>
			</div>
			<p class="submit_b">
				<button type="submit" class="btn40 w140 bg_blue" id="qa_modify">确认修改</button>
			</p>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<!--主体end-->
<!---->
<script type="text/javascript">
	$(function () {
		k = 0;
		doneTwo = function (e, data) {
			$.each(data.result, function (index, file) {
				k++;
				if (file.error) {
					popBox.errorBox(file.error);
					return;
				}
				var liSize = $('.UPloadFil').find('li').size();
				if (liSize >= 7) {
					require(['popBox'], function (popBox) {
						popBox.errorBox('最多传6张图片');
					});
					return false;
				}
				$('<li><input type="hidden" id="imgurls" name="imgurls[]" value="' + file.url + '" /><i class="remove_images"></i> <img src="' + file.url + '" alt="" height="118" width="178"></li>').insertBefore("#addimage");
			});

			require(['app/answer_question/add_question'], function (add_question) {
				add_question.leftPicCal();
			});
		};
	})
</script>
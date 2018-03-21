<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/7/29
 * Time: 14:12
 */
use frontend\components\BaseController;
use frontend\components\CHtmlExt;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "提问问题";
$this->blocks['requireModule'] = 'app/answer_question/add_question';
$backend_asset = BH_CDN_RES . '/static';
$this->registerCssFile($backend_asset . '/css/add_question.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);

/** @var frontend\modules\teacher\models\teaQuestionPackForm $model */
?>
<script type="text/javascript">
	$(function () {
		$('.resultList').delegate('li', 'click', function () {
			$(this).addClass('ac').siblings().removeClass('ac');
		});
		$("#qa_add").click(function () {
			require(['popBox'], function (popBox) {
				var subtype = $('#type').val();
				if (subtype == '') {
					popBox.errorBox("科目不能为空!");
					return false;
				}
				var headline = $.trim($("#takeffice").val());

				if (headline == "" || headline == null || headline.length == 0) {
					popBox.errorBox("问题标题不能为空!");
					return false;
				} else if (headline.length > 140) {
					popBox.errorBox("问题标题超过140字!");
					return false;
				}

				var title_num = $("#content").val();
				if (title_num.length > 1000) {
					popBox.errorBox("详情描述超过1000字!");
					return false;
				}

				var img_num = $('.up_test_list.clearfix li').length;
				if (img_num > 7) {
					popBox.errorBox("最多上传6张图片!");
					return false;
				}

				var checked = $(".sendto_world").is(':checked');
				if (checked == false) {
					popBox.errorBox('请选择要提交到的平台！');
					return false;
				}

				//查询当天提问
				$.get("<?php echo Url::to("/answernew/check-answer"); ?>", {}, function (result) {
					if (result.success) {
						//用于禁止多次提交
						$("form").submit(function () {
							$(":button", this).attr("disabled", "disabled");
						});

						popBox.successBox("提问成功！");
						$form = $('#answer_form');
						$form.attr('method', 'post').attr("action", "<?php echo app()->request->url?>").submit();
					} else {
						popBox.errorBox(result.message);
						return false;
					}

				});
			});
			return true;
		});

		//科目列表
		$('.resultList li').bind('click', function () {
			var type = $(this).attr('type');
			$('#type').val(type);
		});

		//抛向宇宙
		$('#sendto_world').click(function () {
			if ($("[name = more_idea]:checkbox").attr("checked")) {
				$(this).val(1);
				$(this).attr('checked', true);
			} else {
				$(this).val(0);
				$(this).attr('checked', false);
			}
		});
	});
</script>
<script type="text/javascript">
	/*剩余数字*/
	function checkLength(which) {
		var maxChars = 140;
		if (which.value.length > maxChars)
			which.value = which.value.substring(0, maxChars);
		var curr = maxChars - which.value.length;
		document.getElementById("chLeft").innerHTML = curr.toString();
	}

	function checkLength1(which) {
		var maxChars = 1000;
		if (which.value.length > maxChars)
			which.value = which.value.substring(0, maxChars);
		var curr = maxChars - which.value.length;
		document.getElementById("chLeft1").innerHTML = curr.toString();
	}
</script>
<div class="cont24">
	<div class="grid24">
		<div class="mag_title">
			<a href="javascript:;" onclick="window.history.go(-1)"
			   class="btn btn30 icoBtn_back gobackBtn bg_gray"><i></i>返回</a>
			<h4>提问题</h4>
		</div>
		<?php $form = ActiveForm::begin(array('enableClientScript' => false, 'id' => "answer_form")) ?>
		<div class="content">
			<div class="form_list clearfix" style="">
				<div class="row" style=" margin-top:30px;">
					<div class="formL">
						<label><i class="red">*</i>选择科目：</label>
					</div>
					<div class="formR">
						<ul class="resultList clearfix">
							<?php
							$department = loginUser()->getModel()->department;
							$subjectArray = SubjectModel::model()->getSubjectByDepartmentListData($department);
							foreach ($subjectArray as $key => $val) {
								?>
								<li type="<?= $key ?>">
									<a href="javascript:;"><?= $val ?></a>
								</li>
							<?php } ?>
							<input type="hidden" value="" name="type" id="type">
						</ul>
					</div>
				</div>
			</div>
			<div class="replen_list form_list clearfix">
				<div class="formL">
					<label for="takeffice"><i class="red">*</i>问题标题：</label>
				</div>
				<div class="textareaBox pr">

					<textarea class="textarea" id="takeffice" onkeyup="checkLength(this);"
					          name="<?php echo Html::getInputName($model, 'title') ?>"
					          placeholder="请输入您的问题标题···"></textarea>
					<span class="placeholder"></span>
					<?php echo CHtmlExt::validationEngineError($model, 'title') ?>
					<div class="btnArea">
						<em class="txtCount">你还可以输入 <b class="num" id="chLeft">140</b> 字</em>
					</div>

				</div>
			</div>
			<div class="replen_list textareaBox_pro2 form_list clearfix" style="border:none">
				<div class="formL">
					<label><i class="red"></i>详情描述：</label>
				</div>
				<div class="textareaBox pr">
					<textarea id="content" onkeyup="checkLength1(this);" style="width:100%; height:120px"
					          class="text validate[maxSize[1000]]"
					          name="<?php echo Html::getInputName($model, 'detail') ?>"></textarea>
					<?php echo CHtmlExt::validationEngineError($model, 'detail') ?>
					<div class="btnArea">
						<em class="txtCount">你还可以输入 <b class="num" id="chLeft1">1000</b> 字</em>
					</div>
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
						$t1 = new frontend\widgets\xupload\models\XUploadForm;
						/** @var $this BaseController */
						echo \frontend\widgets\xupload\XUploadRequire::widget(array(
							'url' => Yii::$app->urlManager->createUrl("upload/pic"),
							'model' => $t1,
							'attribute' => 'file',
							'autoUpload' => true,
							'multiple' => true,
							'options' => array(
								'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
								"done" => new \yii\web\JsExpression('doneTwo'),
								'maxFileSize' => 4194304,
								"processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')

							),
							'htmlOptions' => array(
								'id' => 'imgupload',
								'class' => 'fileupload',
							)
						));
						?>
						<ul class="clearfix addPicUl">
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
				<div class="formL">
					<label><i class="red">*</i>提交到：</label>
				</div>
				<ul class="che_thr" id="check-box">
					<li class="to_left">
						<input data-id="1" type="checkbox" value="1" name="more_idea" class="sendto_world" id="sendto1"
						       checked>
						<label for="sendto1">联盟</label>
					</li>
					<li>
						<input data-id="3" type="checkbox" value="3" name="more_idea" class="sendto_world" id="sendto3">
						<label for="sendto3">班级</label>
					</li>
				</ul>
			</div>
			<p class="submit_b">
				<button type="button" id="qa_add" class="btn40 w140 bg_blue">抛出问题</button>
			</p>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<!--主体end-->
<!---->
<script type="text/javascript">
	$(function () {
		doneTwo = function (e, data) {
			$.each(data.result, function (index, file) {
				if (file.error) {
					require(['popBox'], function (popBox) {
						popBox.errorBox(file.error);
					});
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

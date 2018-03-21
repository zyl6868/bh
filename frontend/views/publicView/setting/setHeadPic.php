<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/3
 * Time: 13:33
 */
/* @var $this yii\web\View */

use yii\web\View;

$this->title = "个人设置-修改头像";
$this->blocks['requireModule'] = 'app/personal_settings/upload_Pic';

$backend_asset = BH_CDN_RES.'/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);

$this->registerCssFile($backend_asset . "/js/lib/Jcrop/css/jquery.Jcrop.css" . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile($backend_asset . '/js/lib/Jcrop/js/jquery.Jcrop.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);

?>
<script type="text/javascript" xmlns="http://www.w3.org/1999/html">

	done = function (e, data) {
		$.each(data.result, function (index, file) {
			if (file.error) {
				require(['popBox'], function (popBox) {
					popBox.alertBox(file.error);
				});
				return;
			}
			img = file;
			//给隐藏表单赋值
			$("#xuwanting").css({'width': 'auto', 'height': 'auto'});
			$("#xuwanting").attr("src", file.url);
			$('.faceIcon').val(file.url);
			setTimeout(function () {
				require(['popBox'], function (popBox) {
					popBox.uploadPic();
				});
			}, 300);
		})
	};

	$(function () {
		//    上传图片完成后的处理
		$(".save").click(function () {
			var url = '<?php echo url("ajax/image-pic")?>';
			var x = $('#jcrop_x1').val();
			var y = $('#jcrop_y1').val();
			var width = $('#jcrop_w').val();
			var height = $('#jcrop_h').val();
			//没有裁剪
			if (x == 0) {
				x = 0;
			}
			if (y == 0) {
				y = 0;
			}
			if (width == 0) {
				width = 500;
			}
			if (height == 0) {
				height = 500;
			}
			$.post(url, {name: img.url, x: x, y: y, width: width, height: height}, function (data) {
				if (data.success) {
					require(['popBox'], function (popBox) {
						popBox.successBox("修改成功");
					});
					setTimeout(function () {
						location.reload();
					}, 1800);
				}
				else {
					require(['popBox'], function (popBox) {
						popBox.errorBox("修改失败");
					});
				}
			});
		});
	});
</script>
<!--主体-->
<div class="cont24">
	<div class="grid24 main" id="requireModule" rel="app/personal_settings/upload_Pic" data-script="upload_Pic">
		<!--主体-->
		<div class="grid_19 main_r">
			<div class="main_cont userSetup upload_Pic">
				<div class="tab">
					<?php echo $this->render('//publicView/setting/_set_href'); ?>
					<div id="preview-pane" class="tabCont clearfix ">
						<div class="instructions">
							如果您还没有设置自己的头像，系统会显示为默认头像。<br>为了使其他用户更方便快捷的找到您，班海强烈建议您上传一张新照片作为您的个人头像。
						</div>
						<div class="picEditBar fl">
							<div id="uploadBtn" class="fileinput-button"
							     style="width:120px; border-radius:3px" title="上传图片">
                                <span class="fileinput-button uploading">
                                    <span class="id_btn Continue">选择图片</span>
	                                <?php
	                                $t1 = new frontend\widgets\xupload\models\XUploadForm;
	                                /** @var $this BaseController */
	                                echo \frontend\widgets\xupload\XUploadRequire::widget(array(
		                                'url' => Yii::$app->urlManager->createUrl("upload/header"),
		                                'model' => $t1,
		                                'attribute' => 'file',
		                                'autoUpload' => true,
		                                'multiple' => false,
		                                'options' => array(
			                                'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
			                                'maxFileSize' => 2097152,
			                                "done" => new \yii\web\JsExpression('done'),
			                                "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')
		                                ),
		                                'htmlOptions' => array(
			                                'id' => 'imgupload',
			                                'class' => 'fileupload',
		                                )
	                                ));
	                                ?>
                                </span>
							</div>
							<div class="default_pic">
								<div class="imgBar">
									<img class="xuwanting" id="xuwanting"
									     src="<?php echo BH_CDN_RES.'/pub'; ?>/images/head_pic.png"
									     style="">
								</div>
								<input class="faceIcon" type="hidden"/>
								<input type="hidden" id="jcrop_x1">
								<input type="hidden" id="jcrop_y1">
								<input type="hidden" id="jcrop_x2">
								<input type="hidden" id="jcrop_y2">
								<input type="hidden" id="jcrop_w">
								<input type="hidden" id="jcrop_h">
							</div>
							<div class="btnBar">
								<button type="button" class="bg_blue btn40 w140 save" id="save">保存头像</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="button" onclick="location.reload()" class="bg_blue_l btn40 w140">重新选择
								</button>
							</div>
						</div>
						<div class="pic_clipBar preview-container fl">
							<h5>头像效果预览</h5>

							<div class="imgsBox230">
								<div id="preview_box230" class="clip_img clip_img230">
									<img id="crop_preview230" title="230*230像素" height="230" width="230"
									     src="<?php echo BH_CDN_RES.'/pub'; ?>/images/head_pic_230.png">
								</div>
								<p>大头像230*230</p>
							</div>

							<div class="imgsBox70">
								<div id="preview_box70" class="clip_img clip_img70">
									<img id="crop_preview70" title="70*70像素" height="70" width="70"
									     src="<?php echo BH_CDN_RES.'/pub'; ?>/images/head_pic_70.png">
								</div>
								<p>中头像70*70</p>
							</div>

							<div class="imgsBox40">
								<div id="preview_box50" class="clip_img clip_img40">
									<img id="crop_preview50" title="40*40像素" height="40" width="40"
									     src="<?php echo BH_CDN_RES.'/pub'; ?>/images/head_pic_50.png">
								</div>
								<p>小头像40*40</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--主体end-->

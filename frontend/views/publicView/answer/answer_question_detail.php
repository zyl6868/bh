<?php
use common\helper\DateTimeHelper;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClass;
use frontend\components\helper\AnswerHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;
use common\components\WebDataKey;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
$this->title = "答疑详情页";
$this->blocks['requireModule'] = 'app/answer_question/answerQ_ask_detail';
$backend_asset = BH_CDN_RES . '/static';
$this->registerCssFile(BH_CDN_RES . '/static/js/lib/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->registerCssFile($backend_asset . '/css/answerQ_ask_detail.min.css' . RESOURCES_VER);

//答案数
/** @var SeAnswerQuestion $answerQuestionModel */
$replyNumber = AnswerHelper::ReplyNumber($answerQuestionModel->aqID);
//同问数
$alsoAsk = AnswerHelper::AlsoAsk($answerQuestionModel->aqID);

?>
<script>
	function checkLength1(which) {
		var maxChars = 1000;
		if (which.value.length > maxChars)
			which.value = which.value.substring(0, maxChars);
		var curr = maxChars - which.value.length;
		document.getElementById("chLeft1").innerHTML = curr.toString();
	}
</script>
<div class="main clearfix  col1200 classes_answering_question" id="requireModule"
     rel="app/classes/classes_answering_question" data-script="classes_answering_question">
	<div class="container col910 alpha no_bg">
		<div class="container">
			<ul class="QA_list">
				<li class="QA_li solve">
					<div class="sUI_pannel userInfo quest_detail">
						<dl class="pannel_l">
							<dt>
								<img class="icon_card"
								     src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($answerQuestionModel->creatorID), 70, 70); ?>"
								     data-type="header" onerror="userDefImg(this);"
								     creatorID="<?= $answerQuestionModel->creatorID ?>" source="0">
							</dt>
							<dd>
								<h5><?php echo $answerQuestionModel->creatorName; ?></h5>

								<div class="resolve_sates">
									<?php if ($answerQuestionModel->isSolved == 0) {
										$class = 'unresolved';
										$solved = '未解决';
									} elseif ($answerQuestionModel->isSolved == 1) {
										$class = 'resolved';
										$solved = '已解决';
									} ?>
									<u class="<?php echo $class; ?>"></u><span><?php echo $solved; ?></span>
								</div>
								<ul class="sates_parameter">
									<li><?php echo SubjectModel::model()->getName((int)$answerQuestionModel->subjectID) . "&nbsp"; ?></li>
									<li><?php echo date("Y年m月d日 H:i", DateTimeHelper::timestampDiv1000($answerQuestionModel->createTime)); ?></li>
								</ul>
							</dd>
						</dl>
						<div class="pannel_r">
							<?php if ($answerQuestionModel->creatorID == user()->id) { ?>
								<?php if (loginUser()->isTeacher()) { ?>
									<a href="<?php echo url('teacher/answer/update-question', array('aqId' => $answerQuestionModel->aqID)) ?>">修改</a>
								<?php } elseif (loginUser()->isStudent()) { ?>
									<a href="<?php echo url('student/answer/update-question', array('aqId' => $answerQuestionModel->aqID)) ?>">修改</a>
								<?php }
							} ?>
							<a href="#answerCntPoint">回答</a>
							<a href="javascript:;" class="quiz_btn_add" aqID="<?php echo $answerQuestionModel->aqID; ?>"
							   user="<?php echo $answerQuestionModel->creatorID; ?>" userId="<?php echo user()->id; ?>">同问</a>
						</div>
					</div>
					<div class="pd15">
						<div class="pannel_l">
							<h4 style="font-weight:600"><?php echo Html::encode($answerQuestionModel->aqName); ?></h4>
						</div>
					</div>
					<div class="QA_txt">
						<?php echo StringHelper::htmlPurifier($answerQuestionModel->aqDetail); ?>
					</div>

					<p class="clearfix">
						<?php
						//分离图片
						$img = ImagePathHelper::getPicUrlArray($answerQuestionModel->imgUri);
						foreach ($img as $k => $imgSrc) {
							?>
							<a class="fancybox subject_imgs" href="<?php echo resCdn($imgSrc); ?>"
							   data-fancybox-group="gallery">
								<img src="<?php echo ImagePathHelper::imgThumbnail($imgSrc, 120, 90); ?>" alt="">
							</a>
						<?php } ?>
					</p>

					<div id="classes_sel_list" class="sUI_formList sUI_formList_min classes_file_list classes_sel_list">
						<div id="AllSubjects" class="row" style="overflow: hidden;">
							<div class="moreContShow asker_bar" id="head_img">
								<em class="comeFrom"><em id="alsoAskNum"><?php echo $alsoAsk; ?></em>人同问：</em>
								<?php if ($alsoAsk > 20) { ?>
									<a class="showMoreBtn" href="javascript:;">更多<i></i></a>
								<?php }
								echo $this->render('_new_answer_question_list_details_alsoask', ['val' => $answerQuestionModel]);
								?>

							</div>
						</div>
					</div>
				</li>
				<li class="answer">
					<p class="count">共计：
						<span class="blue"><?php echo $replyNumber; ?></span>
						个答案
					</p>
					<?php
					echo $this->render('//publicView/answer/_new_answer_details_list', ['answerQuestionModel' => $answerQuestionModel, 'replyListArr' => $replyListArr, 'isuse' => $isuse, 'pages' => $pages]);

					?>
				</li>
			</ul>
		</div>

		<div class="main_pl clearfix">
			<div class="replen_list textareaBox_pro2 form_list clearfix" style="border:none">
				<div class="formL">
					<label>您的答案：</label>
				</div>

				<div class="textareaBox pr"><a name="answerCntPoint"></a>
                    <textarea id="textarea_content" onkeyup="checkLength1(this);" placeholder="请输入您对本题的解析···"
                              style="width:99%; height:120px" class="text validate[maxSize[1000]]"
                              name="answerCnt"></textarea>

					<div class="btnArea" style="">
						<em class="txtCount">你还可以输入 <b class="num" id="chLeft1">1000</b> 字</em>
					</div>
				</div>
				<div class="UPloadFil">
					<ul class="clearfix picList">
						<li class="uploadFile disabled">
							<a href="javascript:;" class="upload_imgs">
								<span class="btn_upload_img">上传图片</span>
								<input type="hidden" name="XUploadForm[file]" value="">
								<input type="file" class="imgupload file" name="XUploadForm[file]" multiple="">
							</a>
							<span class="gray">最多可上传1张图片</span>
						</li>
					</ul>
				</div>
			</div>
			<input type="button" id="btnSub" class="btnSub answer_questions_btn"
			       answerID=<?php echo user()->id; ?> aqID="<?php echo $answerQuestionModel->aqID; ?>" value="提交">
		</div>
	</div>
</div>
<script type="text/javascript">
	done = function (e, data) {
		$.each(data.result, function (index, file) {
			if (file.error) {
				require(['popBox'], function (popBox) {
					popBox.errorBox(file.error);
				});
				return false;
			}

			var _this = $(e.target);
			var liSize = _this.parents(".UPloadFil").find('.picList li img').length;
			if (liSize >= 1) {
				require(['popBox'], function (popBox) {
					popBox.errorBox('最多传1张图片');
				});
				return false;
			}
			$('<li class="upload_img"><i class="remove_images"></i><input type="hidden" id="imgurls" name="imgurls[]" value="' + file.url + '" /> <img width="182" height="122" src="' + file.url + '" alt=""><span class="delBtn"></span></li>').insertAfter('.uploadFile');
			$('.upload_imgs').hide();
			$('.gray').hide();
		});

	};

	window.locale = {
		"fileupload": {
			"errors": {
				"maxFileSize": "文件太大",
				"minFileSize": "文件太小",
				"acceptFileTypes": "文件类型不允许",
				"maxNumberOfFiles": "Max number of files exceeded",
				"uploadedBytes": "Uploaded bytes exceed file size",
				"emptyResult": "Empty file upload result"
			}, "error": "错误", "start": "开始", "cancel": "中止", "destroy": "删除"
		}
	};
	require(['lib/jqueryfileupload/jquery.iframe-transport', 'lib/jqueryfileupload/jquery.fileupload-process', 'lib/jqueryfileupload/jquery.fileupload-validate'], function () {
		$('.imgupload').fileupload({
			"acceptFileTypes": /(\.|\/)(jpg|jpeg|png)$/i,
			"maxFileSize": 4194304,
			"done": done,
			"processfail": function (e, data) {
				var index = data.index, file = data.files[index];
				if (file.error) {
					require(["popBox"], function (popBox) {
						popBox.errorBox(file.error);
					});
				}
			},
			"id": "xuploadform-file",
			"url": "/upload/pic",
			"autoUpload": true,
			"formData": {},
			"dataType": "json"
		});
	});
	$('.remove_images').live('click', function () {
		var self = $(this);
		self.parents('.upload_img').remove();
		$('.upload_imgs').show();
		$('.gray').show();
	});
</script>

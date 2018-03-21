<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/19
 * Time: 16:45
 */
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;

$this->registerJsFile(publicResources().'/static/js/lib/My97DatePicker/WdatePicker.js');
?>

<div class="sUI_formList sUI_formList2">
	<div class="row">
		<div class="form_l">
			<img class="userHeadPic" data-type="header" onerror="userDefImg(this);" width="40px" height="40px"
				 src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId(user()->id),70,70); ?>" alt="">
		</div>
		<div class="form_r">
			<textarea class="textarea_content<?php echo $aqId; ?>"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="form_r">
			<div class="upImgFile up_img">
				<ul class="clearfix picList" id="upload_pic<?php echo $aqId; ?>">
					<li class="uploadFile disabled">
						<a href="javascript:;" class="uploadFileBtn">
							上传图片
							<input type="hidden" name="XUploadForm[file]" value="">
							<input type="file"  class="imgupload file" name="XUploadForm[file]" multiple="">
						</a>
					</li>
				</ul>
			</div>
			<span class="gray">最多可上传1张图片</span>

			<div class="upImgFile">
				<div class="sUI_pannel">
					<span><button type="button" class="bg_blue QA_answerBtn answer_questions_btn"
					              val="<?php echo $aqId; ?>">回答
						</button></span>
					<span><button type="button" class="bg_gray QA_cancelBtn">取消</button></span>
				</div>
			</div>
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
				var liSize = _this.parents(".form_r").find('.picList li img').length;
				if (liSize >= 1) {
					require(['popBox'], function (popBox) {
						popBox.errorBox('最多传1张图片');
					});
					return false;
				}
				$('<li class="upload_img"><input type="hidden" id="imgurls" name="imgurls[]" value="' + file.url + '" /> <img width="182" height="122" src="' + file.url + '" alt=""><span class="delBtn"></span></li>').insertBefore('.uploadFile');
			});
			require(['module/uploadeImg_check_btn'],function(classes_modify){
				classes_modify.leftImg(e.target);
			});

		};

		window.locale = {"fileupload":{"errors":{"maxFileSize":"文件太大","minFileSize":"文件太小","acceptFileTypes":"文件类型不允许","maxNumberOfFiles":"Max number of files exceeded","uploadedBytes":"Uploaded bytes exceed file size","emptyResult":"Empty file upload result"},"error":"错误","start":"开始","cancel":"中止","destroy":"删除"}};
		require(['lib/jqueryfileupload/jquery.iframe-transport','lib/jqueryfileupload/jquery.fileupload-process','lib/jqueryfileupload/jquery.fileupload-validate'], function(){ $('.imgupload').fileupload({"acceptFileTypes":/(\.|\/)(jpg|png|jpeg)$/i,"maxFileSize":4194304,"done":done,"processfail":function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}},"id":"xuploadform-file","url":"/upload/pic","autoUpload":true,"formData":{},"dataType":"json"});  });
</script>
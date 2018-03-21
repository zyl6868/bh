<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-19
 * Time: 上午9:56
 */
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;
use common\models\dicmodels\ClassDutyModel;

/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main.php');
$this->blocks['bodyclass'] = "student";
$this->registerCssFile(BH_CDN_RES . '/pub/css/student.css' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/pub/js/ztree/zTreeStyle/zTreeStyle.css' . RESOURCES_VER);

$this->registerJsFile(BH_CDN_RES . '/pub/js/jquery.validationEngine.min.js' . RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/pub/js/jquery.validationEngine-zh_CN.js' . RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/pub/js/ztree/jquery.ztree.all-3.5.min.js' . RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$studentId = $this->params["studentId"];
if ($studentId == 0) {
	$studentId = user()->id;
}
$userInfo = loginUser()->getUserModel($studentId);

$classInfoMember = SeClassMembers::find()->where(['userID' => $userInfo->userID])->one();
$class = null;
if ($classInfoMember != null) {
	$class = SeClass::find()->where(['classID' => $classInfoMember->classID])->one();
}
?>

<div class="cont24 homepage student_home">
	<div class="grid_24 myInfo">
		<div class="infoBar pr">
			<div class="infoBarBg"></div>
			<div class="infoCont">
				<div class="imgBG">
					<img data-type='header' onerror="userDefImg(this);"
					     src="<?php echo ImagePathHelper::imgThumbnail($userInfo->getFaceIcon(), 220, 220) ?>"
					     width="220" height="220" alt="">
				</div>
				<div class="teacher_title clearfix pr">
					<h2><?php echo $userInfo->trueName; ?></h2>
				</div>
				<p>学校：<?php echo WebDataCache::getSchoolNameBySchoolId($userInfo->schoolID) ?>
					|<?php if (!empty($class)) {
						echo '班级：' . $class->className;
					} ?> |身份： 学生 |<?php if (!empty($classInfoMember)) {
						echo '班内职务：' . ClassDutyModel::model()->getName($classInfoMember->job);
					} ?>
				</p>

			</div>
		</div>
	</div>
	<?php echo $content ?>

</div>
<?php $this->endContent() ?>
<script>
	$(function () {
		$('.newBtnJs').click(function () {
			var $_this = $(this);
			var data = $_this.attr("data_val");
			var arrinfo = data.split('|');
			var id = arrinfo[0];
			var name = arrinfo[1];
			popBox.private_new_msg([{'id': id, 'name': name}], function () {
				var messageContent = $.trim($('.private_msg_Box textarea').val());
				if (messageContent == "") {
					popBox.errorBox("内容不能为空!");
					return false;
				}
				if (messageContent.length > 140) {
					popBox.errorBox("文字已超出!");
					return false;
				}
				var url = '<?= url("messagebox/send-message")?>';
				var userId = $('.popCont .sel').val();
				$.post(url, {userId: userId, messageContent: messageContent}, function (result) {
					if (result.success == true) {
						$('.private_msg_Box').remove();
						location.reload();
					}
				});
			});
			return false;

		})
	});
</script>


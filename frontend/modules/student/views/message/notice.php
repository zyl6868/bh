<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 14-12-11
 * Time: 下午6:59
 */
/* @var $this yii\web\View */
$this->title = "我的通知";
$this->registerCssFile(BH_CDN_RES . '/pub/js/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/pub/js/fancyBox/jquery.fancybox.js' . RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/teacher_MyMessage.css' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/teacher_remind_message.css' . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/student/student_MyMessage';
?>
<!-- 主体 -->
<div id="main" class="clearfix main">
	<!-- 主体左侧 -->
	<div id="main_left" class="main_left">
		<?php
		echo $this->render("_message_nav");
		?>
	</div>
	<!-- 主题右侧 -->
	<div id="main_right" class="main_right" style="width:910px;">
		<!-- 右侧选项卡 -->
		<div id="tab" class="tab_sub">
			<li class="select">我的通知</li>
		</div>
		<div id="notice" class="tab_1 notice main_h4">
			<?php echo $this->render('_notice_list', array('model' => $model, 'pages' => $pages, "classId" => $classId)); ?>
		</div>
	</div>
</div>


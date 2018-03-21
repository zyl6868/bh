<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/4/21
 * Time: 13:37
 */

/* @var $this yii\web\View */
$this->title = "系统消息";
$this->registerCssFile(BH_CDN_RES . '/static/css/teacher_MyMessage.css' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/teacher_remind_message.css' . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/student/student_remind_message';
?>
<script type="text/javascript">
	$(function () {
		$('.resultList li').click(function () {
			var messageType = $(this).attr('messageType');
			$.get('<?php echo url("student/message/sys-msg");?>', {messagetype: messageType}, function (data) {
				$('#notice').html(data);
			});
		});

	})

</script>
<div id="main" class="clearfix main" style="min-height:700px;">
	<!-- 主体左侧 -->
	<div id="main_left" class="main_left">
		<?php echo $this->render('_message_nav') ?>
	</div>
	<div id="main_right" class="main_right">
		<ul id="tab" class="tab_sub">
			<li class="select" data-messageType="">全部</li>
			<li data-messageType="507009">班海消息</li>
			<li data-messageType="507001">作业</li>
		</ul>
		<div class="tab_1 notice main_h4" id="notice">
			<?php echo $this->render('_sys_msg_list', array('model' => $model, 'pages' => $pages, "classId" => $classId)); ?>
		</div>

	</div>
</div>


<!--主体end-->

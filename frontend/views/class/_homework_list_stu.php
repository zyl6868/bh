<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/12
 * Time: 17:39
 */
use common\helper\DateTimeHelper;
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;

?>
<?php
if (empty($homework)):
	echo ViewHelper::emptyView("暂无作业！");
endif;

/** @var common\models\pos\SeHomeworkRel[] $homework */

$newHomeworkGroup = [];
foreach ($homework as $homeworkKey => $homeworkVal) {
	$date = date('Y-m-d', DateTimeHelper::timestampDiv1000($homeworkVal->createTime));
	$newHomeworkGroup[$date][] = $homeworkVal;
}

foreach ($newHomeworkGroup as $newHomeworkGKey => $newHomeworkGVal) {
	 ?>
	<!-- 年份开始 -->
	<div class="yearitem">
		<div class="title_pannel sUI_pannel">
			<div class="pannel_l">
				<h4>
					<i class="calendar_pic"></i>
					<span><?php echo date("Y年m月", strtotime($newHomeworkGKey)); ?></span>
				</h4>
			</div>
		</div>
		<!-- 月份开始 -->
		<div class="monthbox">
			<ul class="worklist">
				<?php echo $this->render("_homework_list_stu_state",['newHomeworkGVal'=>$newHomeworkGVal,'classId'=>$classId]); ?>
			</ul>
		</div>
		<!-- 月份结束-->
	</div>
	<!-- 年份结束-->
<?php } ?>
<div class="page">
	<?php
	echo CLinkPagerExt::widget(array(
			'pagination' => $pages,
			'updateId' => '.classbox',
			'maxButtonCount' => 10,
			'showjump' => true
		)
	);
	?>
</div>
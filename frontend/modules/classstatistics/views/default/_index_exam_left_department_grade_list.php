<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/23
 * Time: 14:29
 */
use yii\helpers\Url;

?>
<div class="asideItem">
	<div class="sel_classes">
		<div class="pd15">
			<h5>
				成绩统计
			</h5>
			<?php echo $this->render("_statistics_left_list",['classId'=>$classId])?>

		</div>
	</div>
</div>
<div class="asideItem">
	<ul class="left_menu">
		<?php echo $this->render("_index_exam_grade_list",['classId'=>$classId])?>
	</ul>
</div>

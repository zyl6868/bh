<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/7
 * Time: 15:06
 */
use yii\helpers\Url;

?>
<div class="asideItem">
	<ul class="left_menu">
		<li>
			<a class="<?= $this->context->highLightUrl('student/homeworkstatistics/homework-excellent-rate') ? 'cur' : '' ?>"
			   href="<?php echo Url::to(['/student/homeworkstatistics/homework-excellent-rate']) ?>">
				作业优秀率统计
			</a>
		</li>
		<li>
			<a class="<?= $this->context->highLightUrl('student/homeworkstatistics/homework-unfinished') ? 'cur' : '' ?>"
			   href="<?php echo Url::to(['/student/homeworkstatistics/homework-unfinished']) ?>">
				作业未完成统计
			</a>
		</li>
	</ul>
</div>

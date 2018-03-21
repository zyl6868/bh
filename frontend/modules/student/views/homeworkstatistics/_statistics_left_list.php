<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/11
 * Time: 11:02
 */
use yii\helpers\Url;

?>
<button id="sch_mag_classesBar_btn" type="button" class="bg_white icoBtn_wait"><i></i>更换</button>
<div id="sch_mag_homes" class="sch_mag_homes pop">
	<dl>
		<dt class="schoolLevel cur">
			<a class="<?= $this->context->highLightUrl(['student/homeworkstatistics/homework-excellent-rate','student/homeworkstatistics/homework-unfinished']) ? 'ac' : '' ?>"
			   href="<?php echo Url::to(['/student/homeworkstatistics/homework-excellent-rate']) ?>">作业统计</a>
		</dt>
		<dd data-sel-item class="sel_ac"></dd>
		<dd data-sel-item></dd>
	</dl>
	<dl>
		<dt class="schoolLevel cur">
			<a class="<?= $this->context->highLightUrl(['student/classshortboard/index','student/classshortboard/week-short']) ? 'ac' : '' ?>"
			   href="<?php echo Url::to(['/student/classshortboard/index']) ?>">短板池</a>
		</dt>
		<dd data-sel-item class="sel_ac"></dd>
		<dd data-sel-item></dd>
	</dl>
</div>

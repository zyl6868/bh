<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/30
 * Time: 14:39
 */
use common\models\pos\SeHomeworkRel;
use yii\helpers\Html;

/** @var common\models\pos\SeHomeworkTeacher $val */
?>

<li class="clearfix sup_li this">
	<div class="item_title noBorder sup_l fl">
		<h4>
			<a href="<?= $val->getType == 1 ? url('teacher/managetask/organize-work-details-new', ['homeworkid' => $val->id]) : url('teacher/managetask/new-update-work-detail', ['homeworkid' => $val->id]); ?>"
			   title=" <?= Html::encode($val->name); ?>">
				<i style="width:51px;">
					<?php if ($val->getType == '1') {
						echo '[电子]';
					} elseif ($val->getType == '0') {
						echo '[纸质]';
					} ?>
				</i>
				<?= cut_str(Html::encode($val->name), 31); ?>
			</a>
		</h4>
		<?php if (!empty($val->homeworkDescribe)) { ?>
			<dl>
				<dd>
					<em>简介：</em>
					<span class="synopsis"><?= Html::encode($val->homeworkDescribe) ?></span>
				</dd>

			</dl>
		<?php } ?>
	</div>
	<div class="sup_r  fr layou_btn">
		<div class="sup_box">
			<div>
				<span class="a_button notice w120" data-type="<?= $val->getType ?>" data-content="<?= $val->name; ?>"
				      data-id="<?= $val->id; ?>">布置作业</span>
			</div>
		</div>
	</div>
	<br style="clear: both"/>
	<?php

	$homeworkRelList = $val->getHomeworkRel()->where(['isDelete' => '0'])->all();
	SeHomeworkRel::getHomeworkTeacherInfo($homeworkRelList);
	if (!empty($homeworkRelList)) {
		echo $this->render("_teacher_work_manage_list_record", ["homeworkRelList" => $homeworkRelList,'homeworkTeacher'=>$val]);
	} ?>
</li>


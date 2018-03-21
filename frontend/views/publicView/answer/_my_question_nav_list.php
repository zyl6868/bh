<?php
/**
 * 教师和学生 答案和修改两个按钮版本
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/8/4
 * Time: 15:31
 */
/** @var common\models\pos\SeAnswerQuestion $val */
/** @var common\models\pos\SeQuestionResult $answerCount */
?>
	<span>
		<a href="javascript:;" class="btn answer bg_blue_l" aqid="<?php
		echo $val->aqID; ?>">
			答案
			<em>(<b><?php echo $val->answerCount; ?></b>)</em>
		</a>
</span>
<?php if ($val->creatorID == user()->id) {
	if (loginUser()->isTeacher()) { ?>
		<span>
			<a href="<?php echo url('teacher/answer/update-question', array('aqId' => $val->aqID)) ?>"
			   class="btn bg_blue_l">修改</a>
		</span>
	<?php } elseif (loginUser()->isStudent()) { ?>
		<span>
			<a href="<?php echo url('student/answer/update-question', array('aqId' => $val->aqID)) ?>"
			   class="btn bg_blue_l">修改</a>
		</span>
	<?php }
} ?>
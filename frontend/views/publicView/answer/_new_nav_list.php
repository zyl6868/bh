<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/8/4
 * Time: 15:31
 */

/** @var common\models\pos\SeAnswerQuestion $val */
?>
	<span>
		<a href="<?php echo url(['/platform/answer/detail', 'aqid' => $val->aqID]); ?>#answerCntPoint"
		   class="btn bg_blue_l btn_bg_blue">回答</a>
	</span>
	<span>
		<a href="javascript:;" class="btn answer bg_blue_l btn_bg_blue" aqid="<?php echo $val->aqID; ?>">
			答案
			<em>(<b><?php echo $val->answerCount; ?></b>)</em>
		</a>
	</span>
	<span>
		<a href="javascript:;" class="btn bg_blue_l quiz quiz_btn_add btn_bg_blue" val="<?php echo $val->aqID; ?>"
		   user="<?php echo $val->creatorID; ?>" uuser="<?php echo user()->id; ?>">
			同问 (<em id="same<?php echo $val->aqID; ?>" val="<?php echo $val->sameCount; ?>"><?php echo $val->sameCount; ?></em>)
		</a>
	</span>
<?php if ($val->creatorID == user()->id) { ?>
	<?php if (loginUser()->isTeacher()) { ?>
		<span>
			<a href="<?php echo url('teacher/answer/update-question', array('aqId' => $val->aqID)) ?>"
			   class="btn bg_blue_l btn_bg_blue">修改</a>
		</span>
	<?php } elseif (loginUser()->isStudent()) { ?>
		<span>
			<a href="<?php echo url('student/answer/update-question', array('aqId' => $val->aqID)) ?>"
			   class="btn bg_blue_l btn_bg_blue">修改</a>
		</span>
	<?php }
} ?>
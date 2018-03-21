<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/8/4
 * Time: 15:31
 */
use frontend\components\helper\AnswerHelper;

?>
<dl class="fl box_btn">
	<dd>
		<a href="javascript:;" class="w90 a_button reply bg_blue_l">回答</a>
		<?php
		//答案数
		$replyNumber = AnswerHelper::ReplyNumber($val->aqID);
		//同问数
		$alsoAsk = AnswerHelper::AlsoAsk($val->aqID);
		?>

		<a href="javascript:;" class="w90 a_button answer bg_blue_l open_reply_list" aqid="<?php echo $val->aqID; ?>" >答案<em>(<b><?php echo $replyNumber;?></b>)</em></a>
		<a href="javascript:;" class="w90 a_button bg_blue_l quiz q_add" val="<?php echo $val->aqID;?>" user="<?php echo $val->creatorID;?>">同问(<b id="same<?php echo $val->aqID;?>" val="<?php echo $alsoAsk;?>"><?php echo $alsoAsk;?></b>)</a>
		<?php if($val->creatorID == user()->id){?>
			<?php if(loginUser()->isTeacher()){ ?>
				<a href="<?php echo url('teacher/answer/update-question',array('aqId'=>$val->aqID)) ?>" class="w90 a_button bg_blue_l">修改</a>
			<?php }elseif(loginUser()->isStudent()){ ?>
				<a href="<?php echo url('student/answer/update-question',array('aqId'=>$val->aqID)) ?>" class="w90 a_button bg_blue_l">修改</a>
			<?php }} ?>
	</dd>
</dl>

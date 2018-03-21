<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/24
 * Time: 14:44
 */
use common\models\sanhai\ShTestquestion;
use common\models\search\Es_testQuestion;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;

foreach ($questionCartQuestion as $key=>$item) {
	$esQuestionData = Es_testQuestion::find()->where(["id"=>$item->questionId])->one();
	/** @var common\models\search\Es_testQuestion $esQuestionData */
	$showType = $esQuestionData->getQuestionShowType();
	$isMaster = $esQuestionData->getQuestionChildCache();
?>
<div class="quest join_basket">
	<div class="sUI_pannel quest_title">
		<div class="pannel_l">
			<b><?php echo $key+1?></b>
		</div>
		<div class="pannel_r" style="margin-right: 25px">
           <span><a href="javascript:;" class="move_up_btn"  cartQuestionId="<?php echo $item->cartQuestionId?>"><i></i> 上移</a></span>
            <span><a href="javascript:;" class="move_down_btn"  cartQuestionId="<?php echo $item->cartQuestionId?>"><i></i> 下移</a></span>
			<span><a href="javascript:;" class="del_btn del_question"  cartQuestionId="<?php echo $item->cartQuestionId?>" orderNumber="<?=$item->orderNumber?>"><i></i>删除</a></span>
		</div>
	</div>
	<div class="pd25" cartQuestionId="<?php echo $item->cartQuestionId?>" >

		<div class="Q_title  clearfix">
			<p><?php echo StringHelper::htmlPurifier($esQuestionData->processContent()) ?></p>
		</div>

		<?php if ($showType == ShTestquestion::QUESTION_DAN_XUAN_TI || $showType == ShTestquestion::QUESTION_DUO_XUAN_TI) { ?>
			<div class="Q_cont">
				<?php
				if ($esQuestionData->jsonAnswer != '' && $esQuestionData->jsonAnswer != null) {
					echo $esQuestionData->homeworkQuestionContent();
				}
				?>
			</div>
		<?php } ?>

		<?php if ($showType == ShTestquestion::QUESTION_PAN_DUAN_TI) { ?>
			<div class="Q_cont">
				<?php
				echo $esQuestionData->getJudgeQuestionContent();
				?>
			</div>
		<?php } ?>

		<?php if ($showType == ShTestquestion::QUESTION_KE_PAN_LIAN_XIAN_TI) { ?>
			<div class="Q_cont">
				<?php
				echo $esQuestionData->getConnectionQuestionContent();
				?>
			</div>
		<?php } ?>

		<?php if ($showType == ShTestquestion::QUESTION_KE_PAN_YING_YONG_TI ||$showType == ShTestquestion::QUESTION_BU_KE_PAN_YING_YONG_TI) { ?>
			<?php
			if (!empty($isMaster)) {
				echo $this->render('//publicView/basket/_haschild_item_answer', ['childList' => $isMaster, 'mainId' => $esQuestionData->id]);
			}
			?>
		<?php } ?>

		<div class="sUI_pannel btnArea">
			<button type="button" class="bg_white icoBtn_open show_aswerBtn">查看答案解析 <i></i></button>
		</div>
		<div class="A_cont">
			<div class="answerBar">
				<h6>答案:</h6>
				<p><?php echo $esQuestionData->getNewAnswerContent(); ?></p>
			</div>

			<div class="analyzeBar">
				<h6>解析：</h6>
				<p><?php if (empty($esQuestionData->analytical)) {
						echo '略';
					} else {
						echo $esQuestionData->analytical;
					} ?></p>
			</div>

		</div>


	</div>

</div>

<?php } ?>
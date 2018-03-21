<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/29
 * Time: 13:45
 */
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;

/* @var $this yii\web\View */
$this->title = "班内答疑";
$this->blocks['requireModule'] = 'app/classes/classes_answering_question';
/** @var  common\models\pos\SeAnswerQuestion $modelList */
/** @var common\models\pos\SeAnswerQuestion $answerSort */
?>
<script type="text/javascript">
	$(function () {
		//我的问题弹窗
		$('.myQuestion').click(function () {
			$('#my_question').dialog({
				autoOpen: false,
				width: 400,
				modal: true,
				resizable: false,
				buttons: [
					{
						text: "前去检索",
						click: function () {
							if ($('#mySchoolPop .text').val() == 1) {
								$(this).dialog("close");
							}
							else {
								location.href = '<?php echo url('/platform/answer/index');?>';
							}
						}
					},
					{
						text: "我要提问",
						click: function () {
							if ($('#mySchoolPop .text').val() == 1) {
								$(this).dialog("close");
							}
							else {
								if ('<?php echo loginUser()->isStudent();?>') {
									location.href = '<?php echo url('student/answer/add-question');?>';
								} else if ('<?php echo loginUser()->isTeacher();?>') {
									location.href = '<?php echo url('teacher/answer/add-question');?>';
								}
							}
						}
					}
				]
			});
			$("#my_question").dialog("open");
			return false;
		});
	})

</script>
<div class="main clearfix col1200 classes_answering_question" id="requireModule"
     rel="app/classes/classes_answering_question" data-script="classes_answering_question">

	<div class="container col910 alpha no_bg">
		<div class="classify">
			<div class="pd25">
				<div id="classes_sel_list" class="sUI_formList sUI_formList_min  classes_file_list ">
					<div class="row">
						<?php echo $this->render('_answer_subject_list', ['classId' => $classId]) ?>
					</div>
					<div class="row clsId" cls="<?php echo $classId ?>">
						<div class="form_l tl is_solved">
							<a class="sel_ac" solved_type="" data-sel-item href="javascript:;">全部状态</a>
						</div>
						<div class="form_r">
							<ul>
								<li class="is_solved">
									<a data-sel-item href="javascript:;" solved_type="1"><i class="already_solved">
										</i>已解决</a>
								</li>
								<li class="is_solved">
									<a data-sel-item href="javascript:;" solved_type="2">
										<i class="unresolved"></i>未解决</a>
								</li>
							</ul>
						</div>
					</div>
					<button id="i_askBtn" type="button" class="btn40 bg_blue i_askBtn myQuestion">我要提问</button>
				</div>
			</div>
		</div>
		<div class="check_answer_list">
			<?php echo $this->render('//publicView/answer/_new_answer_question_list', ['modelList' => $modelList, 'pages' => $pages,]) ?>
		</div>
	</div>

	<div class="aside col260 omega no_bg">


		<div class="asideItem asker_list">

			<h4><i></i>提问排名</h4>

			<div class="pd15">
				<ul>
					<?php
					if (empty($answerSort)) {
						echo ViewHelper::emptyView("暂无提问排名！");
					}

					foreach ($answerSort as $sortVal) { ?>
						<li>
							<img data-type="header" onerror="userDefImg(this);" width="40" height="40"
							     src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($sortVal['creatorID']), 70, 70); ?>"
							     alt="" creatorID="<?php echo $sortVal['creatorID']; ?>">
							<?php echo $sortVal['creatorName'] ?>
							<span>提问：<em><?php echo $sortVal['answerCount'] ?></em></span>
						</li>
					<?php } ?>
				</ul>

			</div>

		</div>

	</div>

</div>
<div id="my_question" class="my_question popoBox hide " title="答疑管理">
	<div class="impBox">
		<form>
			<div class="answer_text" style="text-align:center; line-height: 55px;">
				请先看一下是否已有相同问题
			</div>

		</form>
	</div>
</div>
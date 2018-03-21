<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/7/26
 * Time: 11:01
 */

use yii\web\View;

$this->title = "我的回答";
$this->blocks['requireModule'] = 'app/student/answer_questions';
$this->registerCssFile(BH_CDN_RES.'/static/css/classes.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES.'/static/css/answer-question.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/echarts.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/chart/pie.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);

/** @var common\models\pos\SeAnswerQuestion[] $modelList */
?>
<script type="text/javascript">
	$(function(){
		//我的问题弹窗
		$('.myQuestion').click(function(){
			$('#my_question').dialog({
				autoOpen: false,
				width:400,
				modal: true,
				resizable:false,
				buttons: [
					{
						text: "前去检索",
						click: function() {
							if($('#mySchoolPop .text').val()==1){
								$( this ).dialog( "close" );
							}
							else{
								location.href = '<?php echo url('/platform/answer/index');?>';
							}
						}
					},
					{
						text: "我要提问",
						click: function() {
							if($('#mySchoolPop .text').val()==1){
								$( this ).dialog( "close" );
							}
							else{
								if('<?php echo loginUser()->isStudent();?>'){
									location.href = '<?php echo url('student/answer/add-question');?>';
								}else if('<?php echo loginUser()->isTeacher();?>'){
									location.href = '<?php echo url('teacher/answer/add-question');?>';
								}
							}
						}
					}
				]
			});
			$("#my_question").dialog( "open" );
			return false;
		});
	})

</script>
<div class="main clearfix col1200 classes_answering_question">
	<div class="container col910 alpha no_bg">
		<div class="container tabs classify">
			<div class="tab">
				<div class="tab-btns clearfix">
					<?php echo $this->render("_answerquestion_nav")?>
				</div>
			</div>
		</div>
		<div id="classes_sel_list"  class="container no_bg">

			<div class="check_answer_list">
				<?php echo $this->render('//publicView/answer/_my_answer_question_list',['modelList' => $modelList, 'pages' => $pages])?>
			</div>
		</div>

	</div>

	<div class="aside col260 omega no_bg">

		<?php echo $this->render("_answer_statistics");?>
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

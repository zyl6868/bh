<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/24
 * Time: 10:17
 */


$this->title = "平台答疑";
$this->blocks['requireModule'] = 'app/platform/platform_answering_question';
?>

<script type="text/javascript">
	$(function () {
		//增加提示信息
		$('.search_ansewr').append('<i>一句话描述</i>');
		$('.search_ansewr_text').focus(function () {
			var _this = $(this);
			_this.siblings('i').hide();
		});
		$('.search_ansewr_text').blur(function () {
			var _this = $(this);
			if (_this.val() != '') {
				_this.siblings('i').hide();
			}
			else {
				_this.siblings('i').show();
			}

		});

		//我的问题弹窗
		$('.myQuestion').click(function () {
			$('#my_question').dialog({
				autoOpen: false,
				width: 400,
				modal: true,
				resizable: false,
				buttons: [
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
		//点击搜索按钮
		$(document).on("click", "#search_word", function () {
			var search_word = $('#searchText').val();
			$.get('<?php echo url("platform/answer/answer-questions-list");?>', {keyWord: search_word}, function (data) {
				$('.check_answer_list').html(data);
			});
		});
	})

</script>
<!--主体-->
<div class="main clearfix  col1200 platform_answering_question" id="requireModule"
     rel="app/platform/platform_answering_question" data-script="platform_answering_question">
	<div class="container classify">
		<div class="pd25">
			<div class="searchBar">
				<span class="sUI_searchBar sUI_searchBar_max">
					<input type="text" class="text" id="searchText" placeholder="请输入要提问的问题···">
					<button type="button" class="searchBtn" id="search_word">搜索题目</button>
				</span>
			</div>
			<div id="classes_sel_list" class="sUI_formList sUI_formList_min  classes_file_list ">
				<div class="row">
					<?php echo $this->render('_answer_subject_list') ?>
				</div>
				<div class="row">
					<div class="form_l tl is_solved">
						<a class="sel_ac" solved_type="" data-sel-item href="javascript:;">全部状态</a>
					</div>
					<div class="form_r">
						<ul>
							<li class="is_solved">
								<a data-sel-item href="javascript:;" solved_type="1"><i
										class="already_solved"></i>已解决</a>
							</li>
							<li class="is_solved">
								<a data-sel-item href="javascript:;" solved_type="2"><i class="unresolved"></i>未解决</a>
							</li>
						</ul>
					</div>
				</div>
				<button id="i_askBtn" type="button" class="btn40 bg_blue i_askBtn myQuestion">我要提问</button>
			</div>
		</div>
	</div>
	<div class="container no_bg">
		<div class="check_answer_list">
			<?php echo $this->render('//publicView/answer/_new_answer_question_list', ['modelList' => $modelList, 'pages' => $pages]) ?>

		</div>
	</div>
</div>
<!--主体end-->
<div id="my_question" class="my_question popoBox hide " title="答疑管理">
	<div class="impBox">
		<form>
			<div class="answer_text" style="text-align:center; line-height: 55px;">
				请先看一下是否已有相同问题
			</div>

		</form>
	</div>
</div>

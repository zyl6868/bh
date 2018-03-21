<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/26
 * Time: 14:13
 */
/* @var $this yii\web\View */
use common\models\dicmodels\SubjectModel;

$schoolModel=$this->params['schoolModel'];

/* @var $this yii\web\View */  $this->title="校内答疑 - ".$schoolModel->schoolName;
?>
<script>
	$(function(){

		//点击搜索按钮
		$('#search_word').click(function(){
			var keyWord = $('#searchText').val();
			$.get('<?php echo url("school/answer-questions", array('schoolId' => $schoolId));?>',{keyWord:keyWord},function(data){
				$('.make_testpaper').html(data);
			});
		});
		$('#searchText').placeholder({value:'请输入要提问的问题',ie6Top:10});

		//科目变化，列表自动刷新
		$(".subject_list").click(function(){
			var subjectID = $(this).attr('subject');
			$.get('<?php echo url("school/answer-questions",array('schoolId' => $schoolId));?>',{ subjectID: subjectID },function(data){
				$(".make_testpaper").html(data);
			})
		});
	})
</script>

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
								location.href = '<?php echo url('platform/answer/index');?>';
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
			$( "#my_question" ).dialog( "open" );
			return false;
		});
	})

</script>
<!--主体-->
		<div class="main_cont">
			<div class="title">
				<h4>校内答疑</h4>
				<div class="title_r hand_r">
                		<span>
                            <input type="text" class="text searchText" id="searchText" ><button type="button" class="hideText TextBtn searchBtn " id="search_word">搜索</button>
                        </span>
					<a href="javascript:" class="a_button w150 bg_green btn40 myQuestion">我要提问</a>

					<!--判断当前用户是谁，我要提问按钮便链接到当前用户个人管理中心的提问页面-->
				</div>
			</div>
			<ul class="resultList clearfix" id="subject_click">
				<li class="ac subject_list" subject=""><a href="javascript:;">全部科目</a></li>
				<?php
				$subject=SubjectModel::model()->getData();
				foreach($subject as $subjectVal){
					?>
					<li class="subject_list" subject="<?php echo $subjectVal->secondCode;?>"><a href="javascript:;"><?php echo $subjectVal->secondCodeValue?></a></li>
				<?php } ?>

			</ul>
			<hr>
			<div class="scholl_class_cont scholl_answer">
				<div class="main_cont test answer_questions">
					<div class="make_testpaper">
						<ul class="make_testpaperList">
							<?php echo $this->render('//publicView/answer/_answer_list', array('modelList'=>$modelList,'pages' => $pages));?>

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

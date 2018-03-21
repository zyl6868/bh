<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/29
 * Time: 9:52
 */
/* @var $this yii\web\View */  $this->title="教师主页";
?>
<script>
	$(function(){
		$(".file_type").live('click',function(){
			var type = $(this).val();
			$.get("<?php echo url('/teacher/default/index',array('teacherId'=>$teacherId))?>",{type:type},
				function (data){
					$('#list').html(data);
				}
			)
		});
	})
</script>
<!--主体-->
	<div class="grid_16 alpha omega main_l">
		<div class="main_cont">
			<div class="tab">
				<?php echo $this->render('_teacher_file_url' ,array('teacherId'=>$teacherId))?>
				<div class="tabCont">
					<div class="tabItem favorite">
						<?php echo $this->render('_teacher_file_search', array( 'pages' => $pages, 'result' => $result));?>
						<div id="list">
							<?php echo $this->render('_teacher_file_list', array('result' => $result, 'listType'=>$listType, 'teacherId'=>$teacherId, 'pages' => $pages));?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->render('_teacher_file_right',array('answerResult'=>$answerResult, 'teacherId'=>$teacherId)); ?>
<!--主体end-->


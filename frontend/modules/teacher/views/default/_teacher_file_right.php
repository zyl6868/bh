<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/29
 * Time: 16:56
 */
//教师主页右部
?>
<div class="grid_8 alpha omega main_r">
	<div class="main_cont">
		<div class="mainContBorder">
			<div class="item">
				<h4>
					<?php if($teacherId == user()->id){
						echo 'Wo';
					}else{
						echo 'Ta';
					}?>
					的答疑总汇
				</h4>
				<ul class="total_QA_list clearfix">
					<li>
						<span class="accept_ico">采纳</span>
						<?php echo $answerResult->useCnt; ?>
					</li>
					<li>
						<span class="QA_ico">问答</span>
						<?php echo $answerResult->answerCnt; ?>
					</li>
					<li>
						<span class="ask_ico">提问</span>
						<?php echo $answerResult->askQuesCnt; ?>
					</li>
				</ul>

			</div>
			<div class="item Ta_teacher">

				<?php if($teacherId ==user()->id){
					echo $this->render('_new_your_index_view', array('teacherId'=>$teacherId));
				}else{
					echo $this->render('_new_other_index_view', array('teacherId'=>$teacherId));
				}?>

			</div>
			<div class="item noBorder"></div>
		</div>
	</div>
</div>
<script>
	$("#classID").change(function () {
		var teacherId = <?php echo $teacherId; ?>;
		var classID = $(this).val();

		$.post("<?php echo url('teacher/default/get-class-member')?>", {classID: classID,teacherId: teacherId}, function (result) {
			$("#classMember").html(result);
		})
	});
	$("#allClassID").change(function () {
		var teacherId = <?php echo $teacherId; ?>;
		var classID = $(this).val();
		$.post("<?php echo url('teacher/default/get-class-member')?>", {
			classID: classID,
			teacherId: teacherId
	}, function (result) {
			$("#allClassMember").html(result);
		})
	})
</script>

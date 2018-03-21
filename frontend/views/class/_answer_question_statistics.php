<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/8
 * Time: 15:51
 * 班级答疑统计片段
 */
?>


<div class="asideItem anwser_rate">
	<h4><i></i>答疑统计</h4>
	<div class="pd15">
		<div id="anwser_rate_tab" class="sUI_tab anwser_rate_tab">
			<?php echo $this->render('_answer_question_statistics',['classId' => $classId, 'answerCount' => $answerCount, "replyCount" => $replyCount, "replyAdoptCount" => $replyAdoptCount]); ?>
		</div>
	</div>

</div>

<ul class="tabList clearfix">
	<li><a href="javascript:;" class="ac"><em><?php echo $answerCount; ?></em>提问<span class="arrow"></span></a></li>
	<li><a href="javascript:;"><em><?php echo $replyCount; ?></em>回答<span class="arrow"></span></a></li>
	<li><a href="javascript:;"><em><?php echo $replyAdoptCount; ?></em>被采纳<span class="arrow"></span></a></li>
</ul>
<div id="anwser_rate" class="anwser_rate" style="height: 300px;">


</div>
<script type="text/javascript">
	$(function(){
		$(document).ready(function(){

		});
//				$(document).ready(function() {
//					*        $('#example').dataTable( {
//							*            "fnDrawCallback": function () {
//					*            alert( 'Now on page'+ this.fnPagingInfo().iPage );
//					*          }
//					*        } );
//					*    } );
	})
</script>
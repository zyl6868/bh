<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/11
 * Time: 10:12
 */

use yii\helpers\Url;

$this->title = "教师-作业作答情况";
$this->blocks['requireModule'] = 'app/classes/tch_hmwk_result_reply';
?>

<div class="main col1200 clearfix tch_hmwk_stu" id="requireModule" rel="app/classes/tch_hmwk_result_reply">
	<?php echo $this->render("_tch_work_details_content", ['homeworkDetailsTeacher' => $homeworkDetailsTeacher, 'classId' => $classId,'homeworkRelAudio'=>$homeworkRelAudio]) ?>

	<div class="container">
		<div id="reply_tab" class="tab tabList_border">
			<ul class="tabList clearfix ">
				<li>
					<a href="<?php echo Url::to(['class/work-detail', 'classId' => $classId, 'classhworkid' => $classhworkId, 'type' => '1']) ?>">未批改</a>
				</li>
				<li class="click_no_submit">
					<a href="<?php echo Url::to(['class/work-detail', 'classId' => $classId, 'classhworkid' => $classhworkId, 'type' => '2']) ?>">未提交</a>
				</li>
				<li class="click_already_corrections">
					<a href="<?php echo Url::to(['class/work-detail', 'classId' => $classId, 'classhworkid' => $classhworkId, 'type' => '3']) ?>"
					   class="ac" type="3">已批改</a>
				</li>
			</ul>
			<div class="tabCont work_detailTab noBorder">
				<div class="tabItem" id="already_corrections_list">
					<div class="">
						<ul class="resultList testClsList" clId="<?php echo $classId; ?>"
						    classhworkId="<?php echo $classhworkId; ?>">
							<li checked-time="1" class="marked-checked-time sel_ac" data-sel-item>
								<a class="ac " href="javascript:;">全部（<?php echo $isCorrections; ?>人）</a>
							</li>
							<li checked-time="2" class="marked-checked-time" data-sel-item>
								<a href="javascript:;">按时提交（<?php echo $markedOnTimeNumber; ?>人）</a>
							</li>
							<li checked-time="3" class="marked-checked-time" data-sel-item>
								<a href="javascript:;">未按时提交（<?php echo $markedOvertime; ?>人）</a>
							</li>
						</ul>
						<?php echo $this->render("_tch_work_details_already_corrections_new",
							[
								'markedOvertime' => $markedOvertime,
								'isCorrections' => $isCorrections,
								'markedOnTimeNumber' => $markedOnTimeNumber,
								'answerCorrected' => $answerCorrected,
								'homeworkDetailsTeacher' => $homeworkDetailsTeacher,
								'pagesCorrected' => $pagesCorrected,
								"classId" => $classId,
								'classhworkId' => $classhworkId
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/12
 * Time: 16:07
 */
$this->title ='班级作业';
$this->blocks['requireModule']='app/classes/stu_hmwk_list';
/** @var common\models\pos\SeHomeworkRel[] $homework */
?>

<div class="main stu_hmwk_list col1200 clearfix classes_answering_question" id="requireModule" rel="app/classes/stu_hmwk_list">
	<div class="container">
		<div class="pd25">
			<div id="classes_sel_list" class="sUI_formList sUI_formList_min classes_file_list " cl="<?php echo $classId;?>">
				<div class="row">
					<?php echo $this->render('_homework_subject_list_stu',['classId'=>$classId]);?>
				</div>
				<div class="row">
					<div class="form_l tl click_state">
						<a class="" state="1" data-sel-item href="javascript:;">全部状态</a>
					</div>
					<div class="form_r">
						<ul>
							<li class="click_state">
								<a state="2" data-sel-item href="javascript:;">已完成</a>
							</li>
							<li class="click_state">
								<a  class="sel_ac" state="3" data-sel-item href="javascript:;">未完成</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container no_bg">
		<div class="classbox">
			<?php
			echo $this->render("_homework_list_stu",['homework'=>$homework, 'classId'=>$classId, 'pages'=>$pages])?>
		</div>
	</div>
</div>


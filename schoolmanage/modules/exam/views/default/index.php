<?php
/** @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '考务管理-首页';
$searchArr = array(
	'schoolLevel' => app()->request->getParam('schoolLevel'),
	'gradeId' => app()->request->getParam('gradeId'),
	'joinYear' => app()->request->getParam('joinYear'),
);
$this->blocks['requireModule'] = 'app/sch_mag/sch_mag_home';
?>
<div class="main col1200 clearfix sch_mag_testMag_home" id="requireModule">
	<div class="sch_mag_left aside col260 no_bg  alpha">
		<div class="asideItem">
			<div class="sel_classes">
				<div class="pd15">
					<h5>
						<?php if ($department == 20201) {
							echo "小学部";
						} elseif ($department == 20202) {
							echo "初中部";
						} elseif ($department == 20203) {
							echo "高中部";
						} ?>
					</h5>
					<button id="sch_mag_classesBar_btn" type="button" class="bg_white icoBtn_wait"><i></i>更换学部</button>
					<div id="sch_mag_homes" class="sch_mag_homes pop">
						<?php echo $this->render("_index_exam_school_level_list", ['searchArr' => $searchArr, 'schoolLevelList' => $schoolLevelList]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="asideItem">
			<ul class="left_menu">
				<?php echo $this->render("_index_exam_grade_list", ["gradeModel" => $gradeModel, "searchArr" => $searchArr, 'schoolID' => $schoolID, 'upTime' => $upTime]) ?>
			</ul>
		</div>
	</div>
	<div class="sch_mag_right container no_bg col910 omega">
		<div class="item">
			<?php echo $this->render("_index_exam_select_type_list", ['joinYear' => $joinYear, 'gradeId' => $gradeId, 'department' => $department, 'yearArr' => $yearArr,]); ?>
		</div>
		<?php echo $this->render("_index_exam_right_list", ["examSchoolModel" => $examSchoolModel, 'pages' => $pages]); ?>
	</div>
	<br>
</div>

<!--弹框创建考试-->
<div id="examConBox" class="popBox examConBox hide" title="创建考试 ">

</div>
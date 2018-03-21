<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 17:29
 */

$this->title = '统计管理-首页';
$searchArr = array(
	'schoolLevel' => app()->request->getParam('schoolLevel'),
	'gradeId' => app()->request->getParam('gradeId'),
	'joinYear' => app()->request->getParam('joinYear'),
);
$this->blocks['requireModule'] = 'app/statistic/statistic_index';
?>
<div class="main col1200 clearfix statistic_index" id="requireModule" rel="app/statistic/statistic_index">
	<div class="aside col260 no_bg alpha">
		<?php echo $this->render("_index_exam_left_department_grade_list", ['searchArr' => $searchArr, "gradeModel" => $gradeModel, 'departmentId' => $departmentId, 'department' => $department, 'upTime' => $upTime]); ?>
	</div>

	<div class="container col910 no_bg omega">
		<div class="item sel_test_bar">
			<?php echo $this->render("_index_exam_select_type_list", ['gradeId' => $gradeId, 'departmentId' => $departmentId, 'yearArr' => $yearArr, 'joinYear' => $joinYear]); ?>
		</div>

		<?php echo $this->render("_index_exam_right_list", ["examSchoolModel" => $examSchoolModel, 'departmentId' => $departmentId, 'gradeId' => $gradeId, 'pages' => $pages]); ?>
	</div>
	<br>
</div>

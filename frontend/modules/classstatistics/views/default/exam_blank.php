<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 17:29
 */

use frontend\components\helper\ViewHelper;

$this->title = '班级统计';
$searchArr= array(
'schoolLevel'=>app()->request->getParam('schoolLevel'),
'gradeId'=>app()->request->getParam('gradeId'),
);
$this->blocks['requireModule']='app/classes/statistic_index';
?>
<div class="main col1200 clearfix statistic_index" id="requireModule" rel="app/classes/statistic_index">
	<div class="aside col260 no_bg alpha">
		<?php echo $this->render("_index_exam_left_department_grade_list",['classId'=>$classId]);?>
	</div>

    <div class="container col910 no_bg omega">
        <div class="item sel_test_bar">
            <?php echo $this->render("_index_exam_select_type_list",['yearArr'=>$yearArr,'classId'=>$classId]);?>
        </div>

	<?php echo ViewHelper::emptyView("该班级暂无考试！");?>

        </div>
    <br>
</div>
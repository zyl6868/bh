<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/17
 * Time: 17:45
 * 考务管理：全部年份 片段
 */
/**
 * 考务管理：右側右侧三个选项列表 片段
 */
?>
<div class="sUI_formList grade_id" joinYear="<?php echo $joinYear ?>" gradeId="<?php echo $gradeId; ?>"
     department="<?php echo $departmentId ?>">
	<?php if (!empty($yearArr)) { ?>
		<div class="row year_type">

			<div class="form_l">
				<a href="javascript:;" class="sel_ac year_click" data-sel-item examYear="">全部学年</a>
			</div>
			<div class="form_r">
				<ul class="testList">
					<?php
					foreach ($yearArr as $item) { ?>
						<li>
							<a href="javascript:;" class="year_click" data-sel-item=""
							   examYear="<?php echo $item; ?>"><?php echo $item; ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
	<div class="row exam_type">
		<div class="form_l">
			<a class="sel_ac exam_click" data-sel-item href="javascript:;" examType="">全部考试</a>
		</div>
		<div class="form_r">
			<ul class="testList">
				<li><a class="exam_click" data-sel-item href="javascript:;" examType="21902">期中考试</a></li>
				<li><a class="exam_click" data-sel-item href="javascript:;" examType="21901">期末考试</a></li>
				<li><a class="exam_click" data-sel-item href="javascript:;" examType="21904">模拟考试</a></li>
				<li><a class="exam_click" data-sel-item href="javascript:;" examType="21903">月考</a></li>
				<li><a class="exam_click" data-sel-item href="javascript:;" examType="21906">会考</a></li>
			</ul>
		</div>
	</div>
</div>
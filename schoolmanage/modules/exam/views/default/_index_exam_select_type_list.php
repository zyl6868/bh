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

<div class="classify">
	<div class="pd25">
		<div id="testMag_home_sel_list" class="testMag_home_formList classes_file_list grade_id" joinYear="<?php echo $joinYear?>" gradeId="<?php echo $gradeId; ?>" department="<?php echo $department; ?>">
			<?php if(!empty($yearArr)){ ?>
			<div class="row year_type">

				<div class="form_l tl">
					<a href="javascript:;" class="sel_ac year_click" data-sel-value="1" data-sel-item examYear="">全部学年</a>
				</div>
				<div class="form_r moreContShow">
					<ul class="clearfix">
						<?php
						foreach ($yearArr as $item) { ?>
							<li>
								<a href="javascript:;" class="year_click" data-sel-value="1" data-sel-item="" examYear="<?php echo $item; ?>"><?php echo $item; ?></a>
							</li>
						<?php } ?>
					</ul>
				</div>

			</div>
			<?php } ?>
			<div class="row exam_type" >
				<div class="form_l tl">
					<a class="sel_ac exam_click"  data-sel-item href="javascript:;" examType="">全部考试</a>
				</div>
				<div class="form_r moreContShow">
					<ul class="clearfix">
						<li><a class="exam_click" data-sel-item href="javascript:;" examType="21902">期中考试</a></li>
						<li><a class="exam_click" data-sel-item href="javascript:;" examType="21901">期末考试</a></li>
						<li><a class="exam_click" data-sel-item href="javascript:;" examType="21904">模拟考试</a></li>
						<li><a class="exam_click" data-sel-item href="javascript:;" examType="21903">月考</a></li>
						<li><a class="exam_click" data-sel-item href="javascript:;" examType="21906">会考</a></li>
					</ul>
				</div>
			</div>
			<div class="row solved_type">
				<div class="form_l tl">
					<a class="sel_ac solved_clcik" data-sel-item href="#" isSolved="">全部状态</a>
				</div>
				<div class="form_r">
					<ul class="clearfix">
						<li>
							<a class="solved_clcik" data-sel-item href="javascript:;" isSolved="2">
								<i class="already_solved"></i>成绩录入完
							</a>
						</li>
						<li>
							<a class="solved_clcik" data-sel-item href="javascript:;"  isSolved="1">
								<i class="in_solution"></i>成绩录入中
							</a>
						</li>
						<li>
							<a class="solved_clcik" data-sel-item href="javascript:;"  isSolved="0">
								<i class="unresolved"></i>成绩未录入
							</a>
						</li>
					</ul>
				</div>
			</div>
			<button id="cj_exma" type="button" class="btn40 bg_blue i_askBtn cj_exma">创建考试</button>
		</div>
	</div>
</div>
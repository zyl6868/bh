<div class="asideItem">
	<div class="sel_classes">
		<div class="pd15">
			<h5>
				<?php if(app()->request->get("schoolLevel") == 20201){
					echo "小学部";
				}elseif(app()->request->get("schoolLevel")  == 20202){
					echo "初中部";
				}elseif(app()->request->get("schoolLevel")  == 20203){
					echo "高中部";
				}?>
			</h5>
			<button id="sch_mag_classesBar_btn" type="button" class="bg_white icoBtn_wait"><i></i>更换学部</button>
			<div id="sch_mag_homes" class="sch_mag_homes pop">
				<?php echo $this->render("_index_exam_school_level_list",['department'=>$department,'lengthOfSchooling'=>$lengthOfSchooling])?>
			</div>
		</div>
	</div>
</div>
<div class="asideItem">
	<ul class="left_menu">
		<?php echo $this->render("_index_exam_grade_list", ["gradeModel"=>$gradeModel, "searchArr"=>$searchArr,'upTime'=>$upTime])?>
	</ul>
</div>

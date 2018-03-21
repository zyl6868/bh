<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/16
 * Time: 17:40
 * 考务管理：试卷列表 片段
 */
/** @var common\models\pos\SeExamSchool $val */

use frontend\components\helper\ViewHelper;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\helpers\Url;

if(empty($examSchoolModel)){
	if(empty($gradeId)){
		echo ViewHelper::emptyView("该部暂无考试安排！");
	}else{
		echo ViewHelper::emptyView("该年级暂无考试安排！");
	}

}

foreach($examSchoolModel as $val){
	$examSubjectModel = $val->getExamSubject()->all();

?>
	<div class="item sch_mag_con">
		<div class="pd25">
			<div class="sUI_pannel <?php if(!empty($examSubjectModel)){ echo 'title_pannel'; }?>">
				<div class="pannel_l">
					<h4><?php echo Html::encode($val->examName); ?></h4>
				</div>

				<div class="pannel_r">
					<?php if(!empty($examSubjectModel)){ ?>
						<a href="<?=Url::to(['/exam/default/set-score','examId'=>$val->schoolExamId])?>">编辑&nbsp;|</a>
						<a href="<?= Url::to(['/exam/scoreinput','examId'=>$val->schoolExamId])?>">录入成绩</a>
					<?php }else{ ?>
						<span><a href="<?=Url::to(['/exam/default/set-score','examId'=>$val->schoolExamId])?>" class="bg_white icoBtn_wait btn">设置科目和分数</a></span>
					<?php } ?>
				</div>
			</div>
			<?php if(!empty($examSubjectModel)){ ?>
			<div class="sch_subject_list classes_file_list clearfix">
				<ul class="subList_con">
					<li class="all_subject">考试科目:</li>
					<?php foreach ($examSubjectModel as $item) { ?>
						<li><a href="javascript:;"><?php echo SubjectModel::model()->getName((int)$item->subjectId) ?></a></li>
					<?php } ?>
				</ul>
				<div class="state_list">
					<a href="javascript:;">
						<?php if($val->inputStatus == 0){ ?>
							<i class="unresolved"></i>成绩未录入
						<?php }elseif($val->inputStatus == 1){?>
							<i class="in_solution"></i>成绩录入中
						<?php }elseif($val->inputStatus == 2){?>
							<i class="already_solved"></i>成绩录入完成
						<?php }else{ ?>
							<i class="generation_in"></i>生成成绩统计中
						<?php } ?>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>


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
		echo ViewHelper::emptyView("该班级暂无统计完成的考试！");
}
foreach($examSchoolModel as $val){
	$examSubjectModel = $val->getExamSubject()->all();

?>
	<div class="item">
		<div class="pd25">
			<div class="sUI_pannel <?php if(!empty($examSubjectModel)){ echo 'title_pannel'; }?>">
				<div class="pannel_l">
					<h4><?php echo Html::encode($val->examName); ?></h4>
				</div>

				<div class="pannel_r">
					<?php if(!empty($examSubjectModel)){ ?>
						<a href="<?php echo Url::to(['overview','examId'=>$val->schoolExamId,'classId'=>$classId,])?>">查看统计</a>
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
			</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>


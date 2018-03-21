<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/30
 * Time: 14:25
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;
/** @var common\models\pos\SeHomeworkTeacher[] $homeworkList */
?>
<ul>

	<?php
	if(empty($homeworkList)){
		echo ViewHelper::emptyView("暂无该学部学科的作业。");
	}

	foreach ($homeworkList as $val) {
		echo "<div id='one-work-content".$val->id."'>";
		echo $this->render("_teacher_work_manage_list_content",["val"=>$val]);
		echo "</div>";
	} ?>
</ul>

<?php
if (isset($pages)) {
	echo CLinkPagerExt::widget(array(
					'pagination' => $pages,
					'updateId' => '#work_list_page',
					'maxButtonCount' => 5,
					'showjump' => true
			)
	);
}
?>
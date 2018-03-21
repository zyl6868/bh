<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/11
 * Time: 10:26
 * 未批改片段
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;

/** @var common\models\pos\SeHomeworkAnswerInfo $answer */
/** @var common\models\pos\SeHomeworkTeacher $homeworkDetailsTeacher */
?>

<div id="no_already_data">
	<div class="studentList" id="work_id">
		<?php
		if (empty($answer)) {
			ViewHelper::emptyView();
		}
		foreach ($answer as $item) {
			echo $this->render("_tch_work_details_no_corrections_view", ['item' => $item, 'homeworkAnswerID' => $item->homeworkAnswerID, 'homeworkDetailsTeacher' => $homeworkDetailsTeacher, 'classId' => $classId]);
		}
		?>

		<div class="page">
			<?php
			if (isset($page)) {
				echo CLinkPagerExt::widget(array(
						'pagination' => $page,
						'updateId' => '#work_id',
						'maxButtonCount' => 5,
						'showjump' => true
					)
				);
			}
			?>
		</div>
	</div>
</div>

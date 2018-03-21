<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/11
 * Time: 10:33
 * 已批改
 */
use frontend\components\helper\ViewHelper;

?>

	<div id="already_data">
		<div class="studentList" id="fixwork_id">
			<?php
			if (empty($answerCorrected)) {
				ViewHelper::emptyView();
			}

			foreach ($answerCorrected as $item) {
				echo $this->render("_tch_work_details_no_corrections_view", ['classId' => $classId, 'item' => $item, 'homeworkAnswerID' => $item->homeworkAnswerID, 'homeworkDetailsTeacher' => $homeworkDetailsTeacher]);
			}
			?>

			<div class="page ">
				<?php
				if (isset($pagesCorrected)) {
					echo \frontend\components\CLinkPagerExt::widget(array(
							'pagination' => $pagesCorrected,
							'updateId' => '#fixwork_id',
							'maxButtonCount' => 5
						)
					);
				}
				?>
			</div>

		</div>
	</div>
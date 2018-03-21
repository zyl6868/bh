<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/7
 * Time: 11:18
 */

use yii\helpers\Url;

$this->title = '班级作业';
$this->blocks['requireModule'] = 'app/classes/classes_homework';
/** @var common\models\pos\SeHomeworkRel $homework */
?>

<div class="main classes_file col1200 clearfix" id="requireModule" rel="app/classes/classes_homework">
	<div class="container classify">
		<div class="pd25">
			<div class="sUI_formList sUI_formList_min classes_file_list">
				<?php
				echo $this->render('_homework_subject_list_tch', ['classId' => $classId]);
				?>
				<a id="i_askBtn" href="<?php echo Url::to(['/teacher/resources/collect-work-manage']) ?>"
				   class="btn bg_white put_qust_btn">我的作业</a>
			</div>

		</div>
	</div>
	<div class="container no_bg">
		<div class="classbox">
			<?php
			echo $this->render('_homework_list_tch', ['homework' => $homework, 'classId' => $classId, 'pages' => $pages]); ?>
		</div>
	</div>
</div>



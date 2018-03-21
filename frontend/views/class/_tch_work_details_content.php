<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/18
 * Time: 16:55
 */
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\KnowledgePointModel;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container homework_title">
		<span class="return_btn">
			<a id="addmemor_btn" class="btn bg_gray icoBtn_back"  href="<?php echo Url::to(['class/homework','classId'=>$classId])?>" ><i></i>返回</a>
		</span>
	<h4><?php echo Html::encode($homeworkDetailsTeacher->name); ?></h4>
</div>
<div class="container homwork_info">
	<div class="pd25">
		<p><em>版本：</em><?php echo EditionModel::model()->getName($homeworkDetailsTeacher->version) ?></p>

		<?php if (!empty($homeworkDetailsTeacher->chapterId)) {
			$chapterName = ChapterInfoModel::findChapterStr($homeworkDetailsTeacher->chapterId);
			?>
			<p><em>章节：</em><?php echo $chapterName; ?></p>
		<?php } elseif (!empty($homeworkDetailsTeacher->knowledgeId)) { ?>
			<p>
				<em>章节：</em><?php echo KnowledgePointModel::findKnowledgeStr($homeworkDetailsTeacher->knowledgeId); ?>
			</p>
		<?php } ?>

		<p><em>难度：</em><b class="<?php if ($homeworkDetailsTeacher->difficulty == 0) {
				echo "";
			} elseif ($homeworkDetailsTeacher->difficulty == 1) {
				echo "mid";
			} elseif ($homeworkDetailsTeacher->difficulty == 2) {
				echo "hard";
			} ?>"></b></p>
		<?php if(!empty($homeworkDetailsTeacher->homeworkDescribe)){?>
			<p>
				<em>简介：</em>
				<?php echo cut_str(Html::encode($homeworkDetailsTeacher->homeworkDescribe), 300); ?>
			</p>
		<?php }?>
		<?php
		//布置语音
		echo $this->render("//publicView/classes/_teacher_homework_rel_audio",[ 'homeworkRelAudio' => $homeworkRelAudio]); ?>
	</div>
</div>

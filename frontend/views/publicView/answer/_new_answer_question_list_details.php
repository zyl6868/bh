<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/29
 * Time: 15:50
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;

/** @var common\models\pos\SeAnswerQuestion $val */
?>

<li class="QA_li  ">
	<div class="sUI_pannel userInfo <?php if ($val->isSolved == 0) {
		echo '';
	} elseif ($val->isSolved == 1) {
		echo 'solve';
	} ?>">
		<div class="pannel_l head_card" creatorID="<?= $val->creatorID; ?>">
			<img class="icon_card" data-type="header" onerror="userDefImg(this);" width="70px" height="70px"
			     src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($val->creatorID), 70, 70); ?>"
			     alt="" creatorID="<?= $val->creatorID; ?>" source="0">
			<h5><?php echo $val->creatorName; ?></h5>

			<p> <?php echo SubjectModel::model()->getName((int)$val->subjectID) . "&nbsp";
				echo date("Y年m月d日 H:i", DateTimeHelper::timestampDiv1000($val->createTime)); ?></p>
		</div>
		<div class="pannel_r">
			<span class="solve_ico"></span>
		</div>
	</div>
	<div class="pd15">
		<h4>
			<a style="color:#333;font-size: 18px;font-weight: 600"
			   href="<?php echo url(['/platform/answer/detail', 'aqid' => $val->aqID]); ?>">
				<?php echo Html::encode($val->aqName); ?>
			</a>
		</h4>
	</div>
	<div class="QA_txt">
		<a style="color:#333;" href="<?php echo url(['/platform/answer/detail', 'aqid' => $val->aqID]); ?>">
			<?php echo StringHelper::htmlPurifier($val->aqDetail); ?>
		</a>
	</div>
	<?php
	//分离图片
	$img = ImagePathHelper::getPicUrlArray($val->imgUri);
	foreach ($img as $k => $imgSrc) {
		?>
		<a class="fancybox" href="<?php echo resCdn($imgSrc); ?>" data-fancybox-group="gallery_<?= $val->aqID; ?>">
			<img class="lazy" width="120" height="90"
			     data-original="<?= ImagePathHelper::imgThumbnail($imgSrc, 120, 90) ?>" alt="" src="">
		</a>
	<?php } ?>
	<div class="asker_bar head_img" id="head_img<?php echo $val->aqID ?>">
		<em class="comeFrom">同问：</em>
		<?php echo $this->render('_new_answer_question_list_details_alsoask', ['val' => $val]) ?>
	</div>
	<div class="sUI_pannel aqId" aqid="<?php echo $val->aqID; ?>">
		<?php echo $this->render('//publicView/answer/_new_nav_list', ['val' => $val]); ?>
	</div>
	<div class="answerBigBox">
		<div class="answerBox answerM hide">
			<em class="arrow" style="left:30px;"></em>

			<div class="editor" id="response<?php echo $val->aqID; ?>">
			</div>
		</div>
		<div class="answerBox answerW hide">
			<i class="arrow" style="left:115px;"></i>

			<div class="answerBox_list" id="reply_list<?php echo $val->aqID; ?>">
			</div>
		</div>
	</div>
</li>

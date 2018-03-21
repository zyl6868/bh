<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/8/4
 * Time: 18:39
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\pos\SeAnswerQuestion $question */
/** @var common\models\pos\SeQuestionResult $model */
/** @var common\models\pos\SeQuestionResult $replySum */
?>
<ul class="answer_list">
	<?php
	$isUse = true;

	$key1 = null;

	foreach ($model as $key => $msgValue) {
		$first = $model[0];
		if ($msgValue->isUse == 1) {
			$random = $model[$key];
			$key1 = $key;
		}
	}
	if ($key1 != null) {
		$model[0] = $random;
		$model[$key1] = $first;
	}

	foreach ($model as $msgValue) {
		?>
		<li class="clearfix">
			<em class="answer_listL" creatorID="<?= $msgValue->creatorID ?>" source="<?= $msgValue->sourceChannel ?>">
				<img data-type="header" onerror="userDefImg(this);" width="50" height="50"
				     src="<?php echo $msgValue->sourceChannel == 0 ? publicResources() . WebDataCache::getFaceIconUserId($msgValue->creatorID) : 'http://f.kehai.com/file/userFace/' . $msgValue->creatorID . '.r' ?>">
				<?php if ($msgValue->sourceChannel == 1) { ?>
					<div class="identity"><em class="example">榜</em></div>
				<?php } else {
					if (WebDataCache::getUserType($msgValue->creatorID) == 0) { ?>
						<div class="identity"><em class="student">生</em></div>
					<?php } else { ?>
						<div class="identity"><em class="teachers">师</em></div>
					<?php }
				} ?>

			</em>

			<div class="answer_listR fl">
				<div class="answer_a clearfix">
					<div creatorID="<?= $msgValue->creatorID ?>"><?php echo $msgValue->creatorName; ?></div>
					<?php
					if ($msgValue->isUse == 1) {
						$isUse = false;
						?>
						<span>最佳答案</span>
						<?php
					}
					if ($question->creatorID == user()->id) {
						if ($msgValue->isUse == 0 && $isUse == true) {
							?>
							<span class="put put_Js adopt_btn" val="<?php echo $msgValue->resultID; ?>"
							      u="<?php echo $msgValue->rel_aqID; ?>">
								<a href="javascript:" class="btn_c">采用</a>
							</span>
						<?php }
					} ?>

					<em class="fr">
						<?php echo date('Y-m-d', DateTimeHelper::timestampDiv1000($msgValue->createTime)); ?>
					</em>
				</div>
				<div class="answer_a clearfix">
					<?php echo Html::encode($msgValue->resultDetail); ?>
					<?php
					//分离图片
					$resultImg = ImagePathHelper::getPicUrlArray($msgValue->imgUri);
					foreach ($resultImg as $k => $resultImgSrc) {
						?>
						<a class="fancybox" href="<?php echo resCdn($resultImgSrc); ?>"
						   data-fancybox-group="gallery_<?= $msgValue->resultID; ?>">
							<img width="162" height="122" src="<?php echo resCdn($resultImgSrc); ?>" alt="">
						</a>
					<?php } ?>
				</div>
			</div>
		</li>
	<?php }
	if ($replySum > 3) {
		?>
		<span style="">
		<a href="<?php echo Url::to(['/platform/answer/detail', 'aqid' => $question->aqID]) ?>">更多答案>>></a>
	</span>
	<?php } ?>
</ul>

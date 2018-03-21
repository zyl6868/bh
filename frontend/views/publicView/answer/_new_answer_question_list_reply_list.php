<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/29
 * Time: 18:41
 */
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\pos\SeQuestionResult $model */
/** @var common\models\pos\SeAnswerQuestion $question */
/** @var common\models\pos\SeQuestionResult $replySum */
?>
<ul class="sUI_dialog_list sUI_dialog_list_min answer_list">
	<?php
	$isUse = true;

	foreach ($model as $msgValue) {
		?>
		<li class="head_card <?php
		if ($msgValue->isUse == 1) {
			$isUse = false;
			echo 'bestAnswer ';
		}
		if ($msgValue->sourceChannel == 1) {
			echo "answer_example";
		} elseif (WebDataCache::getUserType($msgValue->creatorID) == 0) {
			echo 'answer_student';
		} else {
			echo 'answer_teacher';
		} ?>" creatorID="<?= $msgValue->creatorID ?>">
			<img class="userHeadPic icon_card" data-type="header" onerror="userDefImg(this);" width="40" height="40"
			     src="<?php echo $msgValue->sourceChannel == 0 ? ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($msgValue->creatorID), 70, 70) : 'http://f.kehai.com/file/userFace/' . $msgValue->creatorID . '.r' ?>"
			     creatorID="<?= $msgValue->creatorID; ?>" source="<?= $msgValue->sourceChannel ?>">
			<sub></sub>

			<div class="cont">
				<p><?php echo Html::encode($msgValue->resultDetail); ?></p>

				<p>
					<?php
					//分离图片
					$resultImg = ImagePathHelper::getPicUrlArray($msgValue->imgUri);
					foreach ($resultImg as $k => $resultImgSrc) {
						?>
						<a class="fancybox" href="<?php echo resCdn($resultImgSrc); ?>"
						   data-fancybox-group="gallery_<?= $msgValue->resultID; ?>">
							<img width="120" height="90" src="<?php echo resCdn($resultImgSrc); ?>" alt="">
						</a>
					<?php } ?>
				</p>
			</div>
			<span class="best_ico"></span>
			<!--			<a class="report" href="#">举报</a>-->

			<div class="sUI_pannel">
				<div class="pannel_r">
					<!--					<span><button type="button" class="bg_white thankBtn">感谢一下</button> </span>-->

					<?php
					if ($question->creatorID == user()->id) {
						if ($msgValue->isUse == 0 && $isUse == true) {
							?>
							<span class="adopt_rem adopt_btn " val="<?php echo $msgValue->resultID; ?>"
							      u="<?php echo $msgValue->rel_aqID; ?>">
								<button type="button" class="bg_white setBestBtn">评为最佳</button>
							</span>
						<?php }
					} ?>

				</div>
			</div>
		</li>
	<?php }
	if($replySum>3){
	?>
	<span>
		<a style="width:118px;height: 28px;line-height:28px;background-color:#fff;border:1px solid #DBDBDB;display: block;text-align: center" href="<?php echo Url::to(['/platform/answer/detail','aqid'=>$question->aqID])?>">查看更多答案></a>
	</span>
	<?php } ?>
</ul>

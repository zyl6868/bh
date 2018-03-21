<?php
use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;
use yii\helpers\Html;
use yii\web\View;

$this->registerCssFile(BH_CDN_RES.'/static/js/lib/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/fancyBox/jquery.fancybox.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/lazyload/jquery.lazyload.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
/**
 * @var array $replyListArr
 * @var object $answerQuestionModel
 */
?>
<div id="answerPage" class="answerPage">
	<ul>
		<?php
		foreach($replyListArr as $val){?>
			<li class="answerlist clearfix <?php if ($val->sourceChannel == 1) {
				echo "answer_example";
			} elseif (WebDataCache::getUserType($val->creatorID) == 0) {
				echo 'answer_student';
			} else {
				echo 'answer_teacher';
			}
			?>" creatorID="<?= $val->creatorID ?>">
				<dl>
					<dt>
						<img class="icon_card" src="<?php echo $val->sourceChannel == 0 ? ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($val->creatorID), 70, 70) : 'http://f.kehai.com/file/userFace/' . $val->creatorID . '.r';?>"
							 data-type="header" onerror="userDefImg(this);" creatorID="<?=$val->creatorID?>" source="<?= $val->sourceChannel ?>">
						<sub></sub>
					</dt>
					<dd>
						<div class="params">
							<h5><?php echo Html::encode($val->creatorName); ?></h5>
							<div class="pannel_r">
								<span class="gray">
									<?php echo date("Y年m月d日 H:i", DateTimeHelper::timestampDiv1000($val->createTime)); ?>
								</span>
							</div>
							<p><?php echo StringHelper::htmlPurifier($val->resultDetail);?></p>
						</div>
						<div class="params">
							<ul>
								<?php if($val->imgUri){?>
									<li class="img_li clearfix">
										<a class="fancybox" href="<?php echo resCdn($val->imgUri); ?>"
										   data-fancybox-group="gallery">
											<img src="<?php echo ImagePathHelper::imgThumbnail($val->imgUri,120,90);?>" alt="">
										</a>
									</li>

								<?php }?>
							</ul>
							<div class="rating">
								<?php
								if($isuse){
									if ($val->isUse == 1) {
										echo '<b></b>';
									}
								}else{
									if ($answerQuestionModel->creatorID == user()->id) {
									if ($val->isUse == 0) {
								?>
									<input type="button" class="adopt_btn"  val="<?php echo $val->resultID; ?>" u="<?php echo $val->rel_aqID; ?>" value="评为最佳">
								<?php }}} ?>
							</div>
						</div>
					</dd>
				</dl>
			</li>
		<?php } ?>
	</ul>
	<div class="page">
		<?php
		echo \frontend\components\CLinkPagerExt::widget(
			array(
				'pagination' => $pages,
				'updateId' => '#answerPage',
				'maxButtonCount' => 8,
				'showjump'=>true
			)
		)
		?>
	</div>
</div>

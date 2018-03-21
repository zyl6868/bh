<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/18
 * Time: 14:53
 */
?>
<?php
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;
/* @var $this yii\web\View */
?>
<div class="headWrap">
	<div class="col1200">
		<div class="head">
			<a href="#"><h1>班海网</h1></a>
			<?php if (!user()->isGuest) {?>
				<div class="userCenter">
					<div class="userChannel">

						<div class="centerBox">
							<i></i>
							<ul class="personal_center">
								<li>
									<a href="<?= url('site/logout') ?>" class="logOff">
										<i class="center_quit"></i>退出登录</a>
								</li>
							</ul>
						</div>
						<a class="userName" href="javascript:;" title="<?= loginUser()->getTrueName() ?>">
							<img src="<?= ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId(user()->id),70,70) ?>" style="vertical-align: middle;" data-type="header" onerror="userDefImg(this);" />
							<?= loginUser()->getTrueName() ?>
						</a>
					</div>

					<a class="help" href="http://www.banhai.com/pub/help/focus_map_video.html" title="帮助"></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

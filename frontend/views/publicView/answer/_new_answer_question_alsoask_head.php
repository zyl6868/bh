<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/3
 * Time: 13:48
 */
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;

?>
<?php foreach($alsoAsk as $samelist) { ?>
	<b creatorID="<?=$samelist->sameQueUserId?>">
		<img class="icon_card" data-type="header" onerror="userDefImg(this);" width="40px" height="40px" src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($samelist->sameQueUserId),70,70);?>" alt="" title="<?php echo WebDataCache::getTrueNameByuserId($samelist->sameQueUserId);?>" creatorID="<?=$samelist->sameQueUserId?>" source="0">
	</b>
<?php } ?>



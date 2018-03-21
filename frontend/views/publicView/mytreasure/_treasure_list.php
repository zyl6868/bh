<?php
/** @var array $model */
use common\components\WebDataCache;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\ViewHelper;
$this->title='我的学米';
?>

<?php
if(empty($xuemiRankingResult)){
    ViewHelper::emptyView();
    return false;
}
?>
<table>
        <thead>
        <tr>
            <td>名次</td>
            <td colspan="2">用户名</td>
            <td>学米数</td>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach ($xuemiRankingResult as $k=>$v){?>
                <tr>
                    <td><a href="javascript:void(0);"><?php echo $k+1;?></a></td>
                    <td class="learningLeft">
                        <img class="icon_card" data-type="header" onerror="userDefImg(this);"
                             src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($v->userID), 70, 70); ?>"
                             alt="" creatorID="<?= $v->userID; ?>" source="0">
                        <sub></sub>
                    </td>
                    <td class="learningRight">
                        <?php echo WebDataCache::getTrueNameByuserId($v->userID);?>
                    </td>
                    <td><?php echo $v->xueMi;?></td>
                </tr>
            <?php }?>
        </tbody>

</table>
<br>
<script>

</script>


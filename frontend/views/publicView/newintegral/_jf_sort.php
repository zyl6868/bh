<?php
/**
 * @var array $dataList
 */
use common\components\WebDataCache;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;

?>
<div id="tab_2" class="bg_fff tab_fff tchIntegral">
    <table id="tab__3">
        <?php
        if(!empty($dataList)) { ?>
        <thead>
        <tr>
            <td>名次</td>
            <td colspan="2">用户名</td>
            <td>用户等级</td>
            <td>积分数</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($dataList as $key => $val) { ?>

            <tr>
                <td class="heightlight"><?= $key+1 ?> </td>
                <td class="headFace">
                    <img class="icon_card" data-type="header" onerror="userDefImg(this);" width="40px", height="40px"
                                                    src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::getFaceIconUserId($val['userID']), 70, 70); ?>"
                                                    alt="" creatorID="<?= $val['userID']; ?>" source="0"><sub></sub>
                </td>
                <td class="faceName" title="<?php echo WebDataCache::getTrueNameByuserId($val['userID']);?>"><?php echo Html::encode(cut_str(WebDataCache::getTrueNameByuserId($val['userID']),5));?></td>
                <td><?= $val['gradeName'] ?></td>
                <td><?= $val['totalPoints'] ?></td>
            </tr>

        <?php } ?>
        </tbody>
        <?php }else{
            ViewHelper::emptyView();
        };
        ?>
    </table>
</div>


<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-14
 * Time: 下午7:24
 */
use yii\helpers\Url;

?>

<?php foreach ($kidList as $item) {?>
    <div class="errWorkBox">
        <a style="color: #000; display: block;" href="<?= Url::to(['kid-question-list', 'kid' => $item->kid, 'date' => $date]);?>"><div class="errWorkTitle"><?= $item->kidName ?></div></a>
        <div class="errWorkCtn">
            <div class="errNum">
                <div class="percent" data-num="<?= $item->wrongNum ?>"></div>
                <span>错<?= $item->wrongNum ?>题</span>
            </div>
            <p>
                <a href="<?= Url::to(['kid-question-list', 'kid' => $item->kid, 'date' => $date]);?>">查看错题</a> |
                <a href="javascript:;"  onclick="BHWEB.toPlayVideo('<?=$item->videoInfo != null ? $item->videoInfo->videoId : 0;?>')" class="studySpot">学习知识点</a>
            </p>
        </div>
    </div>
<?php } ?>

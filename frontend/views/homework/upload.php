<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-12-15
 * Time: 下午2:33
 */

use yii\helpers\Html;
use yii\web\View;

$this->title ='作业详情';
$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_paper';
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.easing.1.3.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.timers-1.2.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/galleryViewAddFn.js', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/GalleryView/jquery.galleryview-3.0-dev.css', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES . '/static/css/classes.css' . RESOURCES_VER);
?>


<div class="main col800 clearfix tch_hmwk_result" >
    <div class="container homework_title">
        <h4><?= Html::encode($homeworkData->name)?></h4>
    </div>
    <div class="container">
        <h4 class="cont_title"><i class="t_ico_file"></i>作业内容</h4>
        <div class="pd25">
            <?php if (!empty($imageList)) { ?>
                <ul id="myGallery">
                    <?php foreach($imageList as $list){?>
                        <li><img src="<?= resCdn($list->url)?>"  alt=""/><span></span></li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <div class="empty">
                    <img src="/pub/images/unAnswered.png">
                </div>
            <?php } ?>
        </div>
    </div>
</div>
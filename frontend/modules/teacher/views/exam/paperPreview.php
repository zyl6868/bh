<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-11-25
 * Time: 下午4:48
 */
use yii\web\View;

/* @var $this yii\web\View */  $this->title="试卷预览";
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.easing.1.3.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.timers-1.2.js', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/GalleryView/jquery.galleryview-3.0-dev.css', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/galleryViewConfig.js', [ 'position' => View::POS_HEAD] );
?>
<div class="grid_19 main_r">
    <div class="main_cont test_class_overall_appraisal">
        <div class="title"> <a href="javascript:" onclick="window.history.go(-1);" class="txtBtn backBtn"></a>
            <h4>试卷预览</h4>
        </div>
        <div class="correctPaper">
            <h5><?=$result->name?></h5>

            <ul id="myGallery">
                <?php  $array=explode(",",$result->imageUrls); foreach($array as $v){?>
                    <li><img src="<?=resCdn().$v?>"/></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        image="<?=$result->imageUrls?>";
        imgArr=image.split(",");
        $('.correctPaperSlide').testpaperSlider({ClipArr:imgArr});
    })
</script>
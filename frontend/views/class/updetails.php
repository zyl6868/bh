<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 16:54
 */
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use yii\helpers\Html;
use yii\web\View;

$this->title ='作业详情';
$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_paper';
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.easing.1.3.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.timers-1.2.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/galleryViewAddFn.js', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/GalleryView/jquery.galleryview-3.0-dev.css', [ 'position' => View::POS_HEAD] );
?>


<div class="main col1200 clearfix tch_hmwk_result" id="requireModule" rel="app/classes/tch_hmwk_veiw_paper" >
    <div class="container homework_title">
        <a href="javascript:history.back(-1);" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>

        <h4><?= Html::encode($homeworkData->name)?></h4>
    </div>
    <div class="container homwork_info">
        <div class="pd25">
            <?php if(!empty($homeworkData->version)){?><p><em>版本：</em><?=EditionModel::model()->getName($homeworkData->version); ?></p><?php }?>
            <?php if(!empty($homeworkData->chapterId)){?><p><em>章节：</em><?php echo ChapterInfoModel::findChapterStr($homeworkData->chapterId);?></p><?php }?>
            <?php if(isset($homeworkData->difficulty) && $homeworkData->difficulty>=0){?><p><em>难度：</em><b class="<?php if($homeworkData->difficulty == 1){echo 'mid';}elseif($homeworkData->difficulty == 2){echo 'hard';}?>"></b></p><?php }?>
            <?php if(!empty($homeworkData->homeworkDescribe)){?><p><em>简介：</em><?= Html::encode($homeworkData->homeworkDescribe); ?></p><?php }?>
            <?php
            //布置语音
            echo $this->render("//publicView/classes/_teacher_homework_rel_audio",[ 'homeworkRelAudio' => $homeworkRelAudio]);
            ?>
        </div>
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
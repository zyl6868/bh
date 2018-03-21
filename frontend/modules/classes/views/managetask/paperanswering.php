<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/13
 * Time: 14:36
 */
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\KnowledgePointModel;
use yii\helpers\Html;
use yii\web\View;

/** @var $this yii\web\View */
$this->title = '作业答题';
$this->blocks['requireModule'] = 'app/classes/stu_hmwk_do_homework_paper';
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.easing.1.3.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.timers-1.2.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/galleryViewAddFn.js', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/GalleryView/jquery.galleryview-3.0-dev.css', [ 'position' => View::POS_HEAD] );
?>
<div class="main col1200 clearfix stu_do_homwork" id="requireModule"
     rel="<?php echo BH_CDN_RES . '/static/js/app/classes/stu_hmwk_do_homework_paper.js'; ?>">
    <div class="container homework_title">
        <a href="<?php echo url('student/managetask/work-list'); ?>" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
        <h4 title="<?= Html::encode($homeworkData->name) ?>"><?= Html::encode($homeworkData->name) ?></h4>
    </div>
    <div class="container homwork_info">
        <div class="pd25">
            <p><em>版本：</em><?php echo EditionModel::model()->getName($homeworkData->version) ?></p>

            <?php if (!empty($homeworkData->chapterId)) {
                $chapterName = ChapterInfoModel::findChapterStr($homeworkData->chapterId);
                ?>
                <p><em>章节：</em><?php echo $chapterName; ?></p>
            <?php } elseif (!empty($homeworkData->knowledgeId)) { ?>
                <p>
                    <em>章节：</em><?php echo KnowledgePointModel::findKnowledgeStr($homeworkData->knowledgeId); ?>
                </p>
            <?php } ?>

            <?php if (isset($homeworkData->difficulty) && $homeworkData->difficulty >= 0) { ?>
                <p><em>难度：</em><b class="<?php if ($homeworkData->difficulty == 0) {
                        echo "";
                    } elseif ($homeworkData->difficulty == 1) {
                        echo "mid";
                    } elseif ($homeworkData->difficulty == 2) {
                        echo "hard";
                    } ?>"></b></p>
            <?php } ?>
            <?php if (!empty($homeworkData->homeworkDescribe)) { ?>
                <p><em>简介：</em><?php echo Html::encode($homeworkData->homeworkDescribe); ?></p>
            <?php } ?>
            <?php echo $this->render("//publicView/classes/_teacher_homework_rel_audio", ['homeworkRelAudio' => $homeworkRelAudio]); ?>
        </div>
    </div>

    <!-- 答题卡-->
    <!-- 作业区-->
    <div class="container testpaperArea">
        <h4 class="cont_title"><i class="t_ico_file"></i>作业内容</h4>
        <div class="pd25">
            <?php $imageArray = $homeworkData->homeworkImages;
                    if (!empty($imageArray)) { ?>
                <ul id="myGallery">
                    <?php foreach ($imageArray as $v) { ?>
                        <li><img src="<?= resCdn($v->url) ?>" alt=""/><span></span></li>
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

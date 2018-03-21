<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/12
 * Time: 13:30
 */
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use yii\helpers\Url;
use yii\web\View;

$this->title='批改作业';
$this->blocks['requireModule']='app/classes/tch_hmwk_paper';
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.easing.1.3.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.timers-1.2.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/galleryViewAddFn.js', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/GalleryView/jquery.galleryview-3.0-dev.css', [ 'position' => View::POS_HEAD] );
?>
<div class="main col1200 clearfix tch_homework_paper"  id="requireModule" rel="app/classes/tch_hmwk_paper">
    <input type="hidden" id="homeworkAnswerID" value="<?=$homeworkAnswerID?>">
    <div class="container homework_title">
        <span class="return_btn"><a id="addmemor_btn" href="<?=url::to(['/class/work-detail','classId'=>$classId,'classhworkid'=>$oneAnswerResult->relId])?>"  class="btn">返回</a></span>
        <h4><?=$oneAnswerResult->homeWorkTeacher->name?></h4>
    </div>

    <div class="aside col230 alpha">
        <div id="checkStatus" class="clearfix checkStatus">
            <a class="<?=$type==0?'ac':''?> bGray" href="<?=url::to(['correct-pic-hom', 'classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerIdFirst, 'type' => 0])?>">未批改</a>
            <a class="<?=$type==1?'ac':''?>" href="<?=url::to(['correct-pic-hom', 'classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerIdFirst, 'type' => 1])?>">已批改</a>
        </div>
        <div id="userList" class="userList">
            <?php
            if($homeworkAnswerResult == null){
                ViewHelper::emptyView();
            }
            foreach($homeworkAnswerResult as $v){?>
            <dl class="<?=$v->homeworkAnswerID==$homeworkAnswerID?'cur':''?>">
                <a href="<?=url::to(['correct-pic-hom','classId'=>$classId,'homeworkAnswerID'=>$v->homeworkAnswerID, 'type' => $type])?>">
                    <dt><img onerror="userDefImg(this);" width='50px' height='50px'
                             src="<?= WebDataCache::getFaceIconUserId($v->studentID) ?>"></dt>
                <dd>
                    <h5><?= WebDataCache::getTrueNameByuserId($v->studentID) ?></h5>
                    <?php if($v->correctLevel==4){?>
                        <em class="check_btn"></em>
                    <?php }elseif($v->correctLevel==3){?>
                        <em class="half_btn"></em>
                    <?php }elseif($v->correctLevel==2){ ?>
                        <em class="wrong_btn"></em>
                    <?php }elseif($v->correctLevel==1){?>
                        <em class="bad_btn"></em>
                    <?php }else{?>
                        <em></em>
                    <?php }?>
                </dd>
                </a>
            </dl>
            <?php }?>
        </div>
    </div>
    <div class="container col940 omega">
        <?php if($homeworkAnswerResult == null){
            ViewHelper::emptyView();
        }else{?>
        <div class="pd25">
            <div class="work_btnmark">
                <?php if (!empty($imageArray)) { ?>
                    <ul id="myGallery">
                        <?php foreach ($imageArray as $v) { ?>
                            <li><img src="<?= resCdn($v) ?>" alt=""/><span></span></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="empty">
                        <img src="/pub/images/unAnswered.png">
                    </div>
                <?php } ?>
                <div class="cor_btn">
                    <a href="javascript:;" class="check"></a>
                    <a href="javascript:;" class="half"></a>
                    <a href="javascript:;" class="wrong"></a>
                    <a href="javascript:;" class="bad"></a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>

</div>
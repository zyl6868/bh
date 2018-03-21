<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/10/23
 * Time: 14:51
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<ul class="sUI_dialog_list classes_fresh_news clearfix">

    <?php
    if(empty($homeworkInfoRel) && empty($answerInfo) &&empty($classEventInfo)){
        ViewHelper::emptyView('暂无班级新鲜事！');
    }
    if(!empty($homeworkInfoRel)){
        /** @var common\models\pos\SeHomeworkRel $homeworkInfoRel */
        $homeworkInfo = $homeworkInfoRel->getHomeWorkTeacher()->one();

        if(!empty($homeworkInfo)){
            ?>
            <li>
                <img class="userHeadPic" data-type='header' onerror="userDefImg(this);" src="<?php echo  ImagePathHelper::imgThumbnail(publicResources() . WebDataCache::getFaceIconUserId($homeworkInfoRel->creator),70,70)?>" height="50" width="50">


                    <h5><?php echo WebDataCache::getTrueNameByuserId($homeworkInfoRel->creator); ?>

                        老师布置了一份新作业
                        <?php if($isInClass){
                                    if(loginUser()->isTeacher()){
                                        if($homeworkInfo->getType == 0){
                                            $url = Url::to(['class/up-details', 'classId' => $classId,'homeworkId' => $homeworkInfo->id]);
                                        }else{
                                            $url = Url::to(['class/organize-details','classId' => $classId,'homeworkId' => $homeworkInfo->id]);
                                        }
                                    }else{
                                        $url = Url::to(['classes/managetask/details','classId' => $classId,'relId' => $homeworkInfoRel->id]);
                                    }
                            ?>
                            <a href="<?php echo $url;?>">
                                <em>"<?php echo cut_str(Html::encode($homeworkInfo->name),50); ?>"</em>
                            </a>
                        <?php }else{?>
                            <a>
                                <em>"<?php echo cut_str(Html::encode($homeworkInfo->name),50); ?>"</em>
                            </a>
                        <?php }?>
                    </h5>

                <div class="sUI_pannel">
                    <div class="pannel_l">
                        <span class="date"><?php echo date('Y-m-d', DateTimeHelper::timestampDiv1000($homeworkInfoRel->deadlineTime)); ?></span>
                    </div>
                    <div class="pannel_r"></div>
                </div>
            </li>
        <?php }
    }
    if(!empty($answerInfo)){
        ?>
        <li>

            <img class="userHeadPic" data-type='header' onerror="userDefImg(this);" src="<?php echo  ImagePathHelper::imgThumbnail(publicResources() . WebDataCache::getFaceIconUserId($answerInfo->creatorID),70,70)?>" height="50" width="50">
                <h5><?php echo WebDataCache::getTrueNameByuserId($answerInfo->creatorID); ?>提出了一个新问题
                    <a href="<?php echo Url::to(['/platform/answer/detail','aqid'=>$answerInfo->aqID])?>">
                        <em>"<?php echo cut_str(Html::encode($answerInfo->aqName),50); ?>"</em>
                    </a>
                </h5>

            <div class="subject_pic">
                <?php if(!empty($answerInfo->imgUri)){ ?>
                    <br/>
                    <?php
                    //分离图片
                    $img = ImagePathHelper::getPicUrlArray($answerInfo->imgUri);
                    foreach($img as $k=>$imgSrc) {
                        ?>
                        <a class="fancybox" href="<?php  echo resCdn($imgSrc); ?>" data-fancybox-group="gallery_<?= $answerInfo->aqID; ?>">
                            <img width="120" height="90" src="<?=ImagePathHelper::imgThumbnail($imgSrc,120,90) ?>" alt="">
                        </a>
                    <?php  } ?>
                <?php } ?>

            </div>
            <div class="sUI_pannel">
                <div class="pannel_l"><span class="date"><?php echo date('Y-m-d H:i', DateTimeHelper::timestampDiv1000($answerInfo->createTime)); ?></span></div>
                <div class="pannel_r"></div>
            </div>

        </li>
    <?php
    }
    if(!empty($classEventInfo)){
        ?>
        <li class="no_btm_boder">
            <img class="userHeadPic" data-type='header' onerror="userDefImg(this);" src="<?php echo  ImagePathHelper::imgThumbnail(publicResources() . WebDataCache::getFaceIconUserId($classEventInfo->creatorID),70,70)?>" height="50" width="50">
                <h5>
                    <?php echo WebDataCache::getTrueNameByuserId($classEventInfo->creatorID); ?>添加了一份班级大事记
                    <a href="<?php echo Url::to(['class/memorabilia','classId'=>$classId])?>">
                        <em>"<?php echo cut_str(Html::encode($classEventInfo->eventName),50); ?>"</em>
                    </a>

                </h5>


            <div class="subject_pic">
                <?php
                if(!empty($classEventInfo)){ ?>
                    <?php echo StringHelper::htmlPurifier($classEventInfo->briefOfEvent); ?><br>
                    <?php
                    //分离图片
                    $img = ImagePathHelper::getPicUrlArray($classEventInfo->url);
                    foreach($img as $k=>$imgSrc) {
                        ?>

                        <a class="fancybox" href="<?php  echo resCdn($imgSrc); ?>" data-fancybox-group="gallery_<?= $classEventInfo->eventID; ?>">
                            <img width="120" height="90" src="<?=ImagePathHelper::imgThumbnail($imgSrc,120,90) ?>" alt="">
                        </a>
                    <?php  }} ?>
            </div>
            <div class="sUI_pannel">
                <div class="pannel_l"><span class="date">
                        <?php echo date('Y-m-d H:i', DateTimeHelper::timestampDiv1000($classEventInfo->createTime)); ?></span>
                </div>
                <div class="pannel_r"></div>
            </div>
        </li>

    <?php }?>
</ul>
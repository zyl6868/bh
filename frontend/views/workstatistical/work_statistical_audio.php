<?php
use common\components\WebDataCache;
use common\helper\DateTimeHelper;
use common\helper\MediaSourceHelper;
use common\models\pos\SeHomeworkAnswerQuestionAll;
use common\models\sanhai\ShTestquestion;
use common\clients\MediaSourceService;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;

$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$classModel = $this->params['classModel'];
$classId = $classModel->classID;

$this->title = "作业统计";
$this->blocks['requireModule']='app/classes/tch_hmwk_result_stu';
?>

<div class="main col1200 clearfix tch_hmwk_stu" id="requireModule" rel="app/classes/tch_hmwk_result_stu.js">
    <div class="container homework_title">
        <a id="addmemor_btn" href="<?= url('class/homework', ['classId' => $classId]) ?>" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
        <h4><?php echo cut_str(Html::encode($homeWorkTeacher->name), 30) ?></h4>
    </div>
    <div class="container">
        <div class="sUI_tab">
            <ul class="tabList clearfix">
                <li class="tabListShow"><a href="javascript:void() " class="ac">学生作业</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <h4 class="cont_title"><i class="t_ico_user"></i>未按时提交作业人员</h4>
        <span class="alert_txt"><b></b>红色姓名代表作业仍未提交</span>

        <?php
        if(DateTimeHelper::timestampX1000()<$deadlineTime):?>
            <div class="noend">作业还未截止，请截止后查看</div>
        <?php else:?>
            <ul class="topic_userList">
                <?php foreach($overtimeId as $v):?>
                    <li class=""> <a style="width: 67px;" class="sub_content" href="javascript:;" title="<?php echo WebDataCache::getTrueNameByuserId($v); ?>"><?php echo WebDataCache::getTrueNameByuserId($v); ?></a></li>
                <?php endforeach;?>
                <?php foreach($noAnswerdId as $v1):?>
                    <li ><a style="width: 67px;" class="sub_content ac" href="javascript:;" title="<?php echo WebDataCache::getTrueNameByuserId($v1); ?>"><?php echo WebDataCache::getTrueNameByuserId($v1); ?></a></li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>

    </div>

    <?php if (!empty($homeworkAnswerID)): ?>
        <div class="container">
            <h4 class="cont_title"><i class="t_accuracy"></i>作业正确率排名</h4>

            <div class="workbox">
                <ul class="u_list">

                    <?php
                    foreach ($homeworkAnswerID as $k => $v):


                        $rangeClass = 'range range_bg';
                        if ($k > 2) {
                            $rangeClass = 'range';
                        }
                        $key='work_statistical_student'.$v->studentID. $relId;
                        if ($this->beginCache($key, ['duration' => 600])) {
//                            $homeworkAnswer = \common\models\pos\SeHomeworkAnswerInfo::homeworkAnswerID($v->studentID, $relId);
                        ?>


                        <li class="clearfix">
                            <span class="<?php echo $rangeClass; ?>"><?php if($k < 9){echo '0'.($k+1);}else{echo $k+1;}; ?></span>

                            <p class="headimg">
                                <img src="<?php echo WebDataCache::getFaceIconUserId($v->studentID) ?>"
                                     class="qr" data-type="header" onerror="userDefImg(this);">
                            </p>

                            <p class="username"><?php echo WebDataCache::getTrueNameByuserId($v->studentID); ?></p>

                            <div class="subject">
                                <?php
                                    $answerAllResult = SeHomeworkAnswerQuestionAll::accordingToHomeworkAnswerIdGetHomeworkAnswerQueList($v->homeworkAnswerID);
                                    $mediaService = new MediaSourceService();
                                    foreach ($questionIdResult as $k1 => $v1){

                                        $mediaId = '';
                                        foreach($answerAllResult as $key2=> $val){
                                            if($val['questionID'] == $k1){
                                                $mediaId=(string)$val->mediaId;
                                                unset($answerAllResult[$key2]);
                                            }
                                        }
                                    ?>
                                    <div class="audioBox">
                                        <span style="position: absolute;margin-left: -20px;"><?php echo $v1; ?>.</span>
                                        <p class="vol"></p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="140" height="36" viewBox="0 0 159 36">
                                            <defs>
                                            </defs>
                                            <rect class="cls-1" x="9" width="140" height="36" rx="18" ry="18"></rect>
                                            <path class="cls-2"
                                                  d="M10.88,21.272S9.365,10.119.909,6.622c-1,1.068-4.219-1.724,12.464,0C13.158,6.854,16.208,12.325,10.88,21.272Z"></path>
                                        </svg>
                                        <audio src="<?php echo MediaSourceHelper::getMediaSource($mediaId); ?>"></audio>
                                        <?php

                                            $mediaInfo = $mediaService->getMediaSourceInfo($mediaId);
                                            $duration = 0;
                                            if($mediaInfo){
                                                $duration = $mediaInfo->duration;
                                            }
                                        ?>
                                        <span class="time">
                                            <?php echo DateTimeHelper::convertMinSec($duration); ?>
                                        </span>
                                    </div>
                                <?php  } ?>
                            </div>
                        </li>
                    <?php $this->endCache();} endforeach; ?>

                </ul>
            </div>
        </div>
    <?php else: ?>
        <div class="container">
            <?php echo ViewHelper::emptyView();?>
        </div>
    <?php endif; ?>
</div>
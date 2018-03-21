<?php
/**
 * Created by PhpStorm.
 * User: unizk
 * Date: 2015/4/16
 * Time: 18:20
 */
use common\models\pos\SeHomeworkTeacher;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */  $this->title='上传作业详情';
/** @var  SeHomeworkTeacher $homeworkDetails */
$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_paper';
$images= $homeworkData->getHomeworkImages()->select('url')->asArray()->column();
$this->registerJsFile(BH_CDN_RES.'/pub/js/base.js'.RESOURCES_VER,[ 'position'=> View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/classes.css'.RESOURCES_VER);

?>
<script type="text/javascript">
    $(function() {
        imgArr=<?php echo   json_encode($images);
        ?>;
        $('.correctPaperSlide').testpaperSlider({ClipArr:imgArr});
    })
</script>

<div class="grid_19 main_r">
    <div class="main_cont test_class_overall_appraisal col1200 clearfix" style="min-height: 650px" id="requireModule" rel="app/classes/tch_hmwk_veiw_paper">
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

            </div>
        </div>

        <div class="container">
            <?php if(!empty($images)){?>
                <h4 class="cont_title"><i class="t_ico_file"></i>作业内容</h4>
                <div class="pd25">
                    <div id="slide" class="slide">
                        <div class="slidePaperWrap mc">
                            <ul id="slidePaperList" class="slidePaperList ">

                                <?php foreach($images as $list){?>
                                    <li name="111"><img src="<?= resCdn($list)?>"  alt=""/><span></span></li>

                                <?php }?>
                            </ul>
                            <a href="javascript:;" id="prevBtn" class="slidePaperPrev">上一页</a> <a href="javascript:;" id="nextBtn" class="slidePaperNext">下一页</a> </div>
                        <div class="sliderBtnBar hide"></div>
                        <div class="slidClip">
                            <span onselectstart="return false" class="ClipPrevBtn">prev</span>
                            <div class="slidClipWrap">
                                <div class="slidClipArea">
                                    <?php foreach($images as $image){?>
                                        <a><img src="<?= resCdn($image)?>"   alt=""/></a>
                                    <?php }?>

                                </div>
                            </div>
                            <span onselectstart="return false" class="ClipNextBtn">next</span>
                        </div>
                    </div>
                </div>
            <?php }else{
                \frontend\components\helper\ViewHelper::emptyView();
            }?>
        </div>

    </div>
</div>
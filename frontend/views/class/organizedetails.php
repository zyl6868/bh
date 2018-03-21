<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 10:06
 */
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use yii\helpers\Html;

/** @var  $this yii\web\View */
$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);
$this->title = '作业详情';
$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_ele';

?>

<div class="main col1200 clearfix tch_hmwk_veiw_ele" id="requireModule" rel="app/classes/tch_hmwk_veiw_ele" >
    <div class="container homework_title">
        <a href="javascript:history.back(-1);" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>

        <h4  title="<?= Html::encode($homeworkData->name) ?>"><?= Html::encode($homeworkData->name)?></h4>
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
    <div class="container no_bg">
        <div class="testPaper">
            <?php foreach($homeworkResult as $item){?>

                <?php echo $this->render('//publicView/new_class_homework/_itemPreviewType', array('item' => $item, 'homeworkData' => $homeworkData)); ?>

           <?php }?>
        </div>
    </div>
</div>
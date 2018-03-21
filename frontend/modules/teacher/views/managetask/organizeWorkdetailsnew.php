<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/4/17
 * Time: 14:52
 */
use frontend\components\helper\AreaHelper;
use common\components\WebDataCache;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;

/* @var $this yii\web\View */  $this->title='组织作业详情页';
$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);

$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_paper';
$this->registerCssFile(BH_CDN_RES.'/static/css/classes.css'.RESOURCES_VER);
$this->blocks['requireModule']='app/platform/platform_hmwk_veiw_ele';
?>

<div class="grid_19 main_r">


    <div class="main_cont col1200  online_answer testPaperView clearfix" style="min-height: 650px" id="requireModule" rel="app/platform/platform_hmwk_veiw_ele">
        <div class="container homework_title">
            <a href="javascript:history.back(-1);" class="btn return_btn icoBtn_back"><i></i>返回</a>
            <h4><?php echo $homeworkData->name;?></h4>
        </div>
        <div class="container homwork_info">
            <div class="pd25">
                <?php
                if (!empty($homeworkData->version)) {?>
                    <p><em>版本：</em><?php echo  EditionModel::model()->getName($homeworkData->version)?></p>
                <?php } ?>
                <?php if($homeworkData->id!==''&& $homeworkData->chapterId !==null){ ?>
                    <li class="clearfix">
                        <p><em>章节：</em><?php echo ChapterInfoModel::findChapterStr($homeworkData->chapterId);?></p>
                    </li>
                <?php }
                 if(isset($homeworkData->difficulty) && $homeworkData->difficulty>=0){ ?>
                    <p><em>难度：</em><b class="<?php if ($homeworkData->difficulty == 0) {
                            echo "";
                        } elseif ($homeworkData->difficulty == 1) {
                            echo "dif_mid";
                        } elseif ($homeworkData->difficulty == 2) {
                            echo "dif_hard";
                        } ?>"></b></p>
                <?php }
                if (!empty($homeworkData->homeworkDescribe)) { ?>
                    <p><em>简介：</em><?= cut_str(Html::encode($homeworkData->homeworkDescribe), 300); ?></p>
                <?php } ?>

            </div>
        </div>
        <div class="container no_bg">
            <div class="testPaper">
                <?php if(isset($homeworkResult)){
                    foreach ($homeworkResult as $item) { ?>
                        <?php echo $this->render('//publicView/new_class_homework/_itemPreviewType', array('item' => $item, 'homeworkData' => $homeworkData)); ?>
                    <?php  }
                }else{
                    \frontend\components\helper\ViewHelper::emptyView();
                } ?>
            </div>
        </div>
    </div>

</div>

<!--主体end-->
<script type="text/javascript">
    //查看答案与解析
    $('.openAnswerBtn.fl').click(function(){
        $(this).children('i').toggleClass('close');
        $(this).parents('.paper').find('.answerArea').toggle();
    })
</script>
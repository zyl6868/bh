<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/15
 * Time: 13:27
 */
use common\models\pos\SeHomeworkTeacher;
use common\models\sanhai\ShTestquestion;
use common\components\WebDataCache;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use yii\helpers\Html;
use yii\web\View;

/** @var $this yii\web\View */
$this->title = '答题完毕';
$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);
$this->blocks['requireModule'] = 'app/classes/stu_hmwk_do_homework';
?>

<div class="main col1200 clearfix stu_do_homwork" id="requireModule" rel="app/classes/stu_hmwk_do_homework">
    <div class="container homework_title">
        <a href="<?php echo url('student/managetask/work-list'); ?>" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
        <h4 title="<?= Html::encode($homeworkData->name) ?>"><?= Html::encode($homeworkData->name) ?></h4>
    </div>
    <div class="container homwork_info">
        <div class="pd25">
            <?php if (!empty($homeworkData->version)) { ?><p>
                <em>版本：</em><?= EditionModel::model()->getName($homeworkData->version); ?></p><?php } ?>
            <?php if (!empty($homeworkData->chapterId)) { ?><p>
                <em>章节：</em><?php echo ChapterInfoModel::findChapterStr($homeworkData->chapterId); ?></p><?php } ?>
            <?php if (isset($homeworkData->difficulty) && $homeworkData->difficulty >= 0) { ?><p><em>难度：</em><b
                    class="<?php if ($homeworkData->difficulty == 1) {
                        echo 'mid';
                    } elseif ($homeworkData->difficulty == 2) {
                        echo 'hard';
                    } ?>"></b></p><?php } ?>
            <?php if (!empty($homeworkData->homeworkDescribe)) { ?><p>
                <em>简介：</em><?= Html::encode($homeworkData->homeworkDescribe); ?></p><?php } ?>
            <?php
            //布置语音
            echo $this->render("//publicView/classes/_teacher_homework_rel_audio", ['homeworkRelAudio' => $homeworkRelAudio]); ?>
        </div>
    </div>
    <?php
        if(strpos(loginUser()->phoneReg,'he_') !== false){
            echo  $this->render('_login_download',['userInfo'=>loginUser()]);
        }
    ?>
    <!-- 答题卡-->
    <!-- 作业区-->
    <div class="container no_bg testpaperArea">
        <div class="testPaper">
            <?php
            foreach ($homeworkQuestion as $key => $item) {
                $questionInfo = ShTestquestion::findOne($item->questionId);
                if (empty($questionInfo)) continue;
                echo $this->render('//publicView/new_homeworkAnswer/_item_answer_type',
                    ['item' => $questionInfo, 'number' => $key + 1, 'isAnswered' => $isAnswered, 'homeworkData' => $homeworkData, 'objectiveAnswer' => $objectiveAnswer]);
            }
            ?>

        </div>
    </div>

</div>
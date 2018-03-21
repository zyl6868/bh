<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/12
 * Time: 16:36
 */
use common\models\pos\SeHomeworkAnswerQuestionAll;
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use yii\helpers\Url;
use yii\web\View;

$this->title = '批改作业';
$this->blocks['requireModule'] = 'app/classes/tch_hmwk_ele';
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/GalleryView/jquery.easing.1.3.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/GalleryView/jquery.timers-1.2.js', ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/GalleryView/galleryViewAddFn.js', ['position' => View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/GalleryView/jquery.galleryview-3.0-dev.css', ['position' => View::POS_HEAD]);
?>
<div class="main col1200 clearfix tch_homework_ele" id="requireModule" rel="app/classes/tch_hmwk_ele">
    <div class="container homework_title">
		<span class="return_btn"><a id="addmemor_btn" class="btn bg_gray icoBtn_back"
                                    href="<?= url::to(['/class/work-detail', 'classId' => $classId, 'classhworkid' => $oneAnswerResult->relId]) ?>"><i></i>返回</a></span>
        <h4><?php echo $homeworkResult->name ?></h4>
    </div>

    <div class="aside col230 alpha">
        <div id="checkStatus" class="clearfix checkStatus">
            <a class="<?= $type == 0 ? 'ac' : '' ?> bGray"
               href="<?= url::to(['correct-org-hom', 'classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerIdFirst, 'type' => 0]) ?>">未批改</a>
            <a class="<?= $type == 1 ? 'ac' : '' ?>"
               href="<?= url::to(['correct-org-hom', 'classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerIdFirst, 'type' => 1]) ?>">已批改</a>
        </div>
        <div id="userList" class="userList">
            <?php
            /* @var  SeHomeworkAnswerInfo[] $homeworkAnswerResult */
            if ($homeworkAnswerResult == null) {
                ViewHelper::emptyView();
            }
            foreach ($homeworkAnswerResult as $k => $v) {
                $answerAllQuery = SeHomeworkAnswerQuestionAll::find()->where(['homeworkAnswerID' => $v->homeworkAnswerID])->andWhere(['>', 'correctResult', 0]);
                $subjectArray = [];
                foreach ($answerAllQuery->all() as $v1) {
                    $questionID = $v1->questionID;
                    $questionModel = ShTestquestion::getTestQuestionDetails_Cache($questionID);
                    if ($questionModel && $questionModel->isMajorQuestion() && !$questionModel->isJudgeQuestion()) {
                        array_push($subjectArray, $questionID);
                    }
                }
                ?>
                <dl class="<?= $v->homeworkAnswerID == $homeworkAnswerID ? 'cur' : '' ?>"
                    homeworkAnswerID="<?= $v->homeworkAnswerID ?>"
                    studentID="<?= $v->studentID ?>">
                    <a href="<?= url::to(['correct-org-hom', 'classId' => $classId, 'homeworkAnswerID' => $v->homeworkAnswerID, 'type' => $type]) ?>">
                        <dt><img onerror="userDefImg(this);" width='50px' height='50px'
                                 src="<?= WebDataCache::getFaceIconUserId($v->studentID) ?>"></dt>
                        <dd>
                            <h5><?= WebDataCache::getTrueNameByuserId($v->studentID) ?></h5>
                            <em class="approved">已批:<span><?= count($subjectArray) ?></span>/<b><?= count($questionArray) ?></b></em>
                        </dd>
                    </a>
                </dl>
            <?php } ?>
        </div>
    </div>
    <div class="container col940 omega">
        <?php if ($homeworkAnswerResult == null) {
            ViewHelper::emptyView();
        } else { ?>
            <div class="pd25">
                <div class="cor_questions">
                    <ul id="q_list" style="width: 1428px;">
                        <?php foreach ($questionArray as $k => $v) {
                            $answerAllResult = SeHomeworkAnswerQuestionAll::find()->where(['homeworkAnswerID' => $oneAnswerResult->homeworkAnswerID, 'questionID' => $v])->one();
                            if ($answerAllResult != null) {
                                $correctResult = $answerAllResult->correctResult;
                            } else {
                                $correctResult = 0;
                            }
                            switch ($correctResult) {
                                case 0:
                                    $pic = '';
                                    break;
                                case 1:
                                    $pic = 'wrong_btn';
                                    break;
                                case 2:
                                    $pic = 'half_btn';
                                    break;
                                case 3:
                                    $pic = 'check_btn';
                                    break;
                                default:
                                    $pic = '';
                            }
                            if ($k == 0) {
                                ?>
                                <li class="act" questionID="<?= $v ?>" aid="<?= $answerAllResult->aid?>">题<?= $homeworkResult->getQuestionNo($v) ?><i
                                        class="<?= $pic ?>"></i></li>
                            <?php } else { ?>
                                <li questionID="<?= $v ?>" aid="<?= $answerAllResult->aid?>">题<?= $homeworkResult->getQuestionNo($v) ?><i
                                        class="<?= $pic ?>"></i>
                                </li>
                            <?php }
                        } ?>

                    </ul>
                </div>

                <div class="work_btnmark">
                    <?php if (!empty($answerImageArray)) { ?>
                        <ul id="myGallery">
                            <?php foreach ($answerImageArray as $v) { ?>
                                <li><img src="<?= resCdn($v) ?>" alt=""/><span></span></li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <div class="empty">
                            <img src="/pub/images/unAnswered.png">
                        </div>
                    <?php } ?>
                    <div class="original">
                        <span class="btn_txt">原题</span>

                        <div class="exhibition">
                            <i class="arrow_v_r"></i>
                        </div>
                    </div>
                    <div class="cor_btn">
                        <a href="javascript:;" class="check"></a>
                        <a href="javascript:;" class="half"></a>
                        <a href="javascript:;" class="wrong"></a>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
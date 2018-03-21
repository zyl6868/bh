<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-13
 * Time: 上午10:52
 */

/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static/js/appMethods.js' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/homeworkInfo.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/zepto.min.js' . RESOURCES_VER);
?>

<div class="wrapper">
    <div class="header">
        <div class="nav">
            <a href="javascript:;" class="back" id="goBack">
                <img src="<?php BH_CDN_RES ?>/static/img/back.png">
            </a>
        </div>
        <div class="headerTitle">作业报告</div>
    </div>
    <?php if ($homeworkInfo == null) {
        \mobileWeb\components\ViewHelper::emptyView("作业不存在");
    } else { ?>
    <div class="homeworkReport">
        <div class="homework">
            <div class="homeworkIntroduce">
                <h5><?= $homeworkInfo->homeworkName ?></h5>
                <div class="homeworkTime">
                    完成时间：<?= date("Y-m-d", strtotime($homeworkInfo->uploadTime)) . '&nbsp;&nbsp;' . date("H:i", strtotime($homeworkInfo->uploadTime)) ?>
                    <a href="javascript:;" id="watchTeach"
                       data-id="<?= $homeworkInfo->videoInfo ? $homeworkInfo->videoInfo->videoId : 0; ?>">看本次作业讲解</a>
                </div>
            </div>
        </div>
        <p class="errInfo">本次作业正确率：<span><?= $homeworkInfo->correctRate ?>
                %</span>，答错以下&nbsp;<span><?= $homeworkInfo->mistakes ?></span>&nbsp;题：</p>
        <?php foreach ($questionList as $question) { ?>
            <div class="errPart">
                <div class="errWork">
                    <div style="color: #000" class="errCtn"><?= $question->content ?></div>
                    <div class="ans">
                        <h5>正确答案：</h5>
                        <p style="color: #000"><?= $question->answer ?></p>
                    </div>
                    <div class="ans">
                        <h5>你的答案：</h5>
                        <p style="color: #000"><?= $question->userAnswer ?></p>
                    </div>
                    <div class="stuWork">
                        你的同学中有&nbsp;<span><?= $question->classmateWrongNum ?></span>&nbsp;人答错此题
                        <a href="javascript:;" class="studyThis"
                           data-id="<?= $homeworkInfo->videoInfo ? $homeworkInfo->videoInfo->videoId : 0; ?>"
                           data-time="<?= $question->startTimePoint ?>">学习本题</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        $('#watchTeach').tap(function () {
            BHWEB.toPlayVideo(this.getAttribute('data-id'));
        });


        var studyThisList = document.getElementsByClassName('studyThis');
        for (var i = 0; i < studyThisList.length; i++) {
            studyThisList[i].onclick = function () {
                BHWEB.toPlayViedoSpecifiedTime(this.getAttribute("data-id"), this.getAttribute("data-time"));
            }
        }

        $('#goBack').tap(function () {
            history.back();
        });
    }, false);



</script>

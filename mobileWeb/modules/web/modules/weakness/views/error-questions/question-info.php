<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-13
 * Time: 下午12:04
 */

/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static/js/appMethods.js' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/errQuestionInfo.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/zepto.min.js' . RESOURCES_VER);
?>

<div class="wrapper">
    <div class="header">
        <div class="nav">
            <a href="javascript:;" id="goBack" class="back">
                <img src="<?php BH_CDN_RES ?>/static/img/back.png">
            </a>
        </div>
        <div class="headerTitle">我的错题</div>
    </div>

    <div class="homeworkReport">
        <div class="errPart">
            <div class="errWork">
                <div class="errTitle">
                    <span class="gang">|</span><h5>作业错题</h5>
                    <p>难度：<span><?php switch ($complexity) {
                                case 21101:
                                    echo '容易';
                                    break;
                                case 21102:
                                    echo '较易';
                                    break;
                                case 21103:
                                    echo '一般';
                                    break;
                                case 21104:
                                    echo '较难';
                                    break;
                                case 21105:
                                    echo '困难';
                                    break;
                                default:
                                    echo '容易';
                            } ?></span></p>
                </div>
                <div style="color: #000" class="errCtn"><?= $questionModel->content ?></div>
                <div class="ans">
                    <h5>正确答案：</h5>
                    <p><?= $questionModel->answer ?></p>
                </div>
                <div class="ans">
                    <h5>你的作答：</h5>
                    <p><?= $questionModel->userAnswer ?></p>
                </div>
            </div>

            <p class="fromTitle">来源：<?=$questionModel->homeworkName?></p>

            <?php if($videoInfo != null){?>
                <div class="errWork">
                    <div class="errTitle">
                        <span class="gang">|</span><h5>本题讲解</h5>
                    </div>
                    <div class="subjectCtn" data-id="<?=$videoInfo->videoId ?>">
                        <img src="<?= $videoInfo->courseResId?>">
                        <h5 class="subjectTitle"><?=$videoInfo->videoTitle?></h5>
                        <div class="subjectTime">
                            <p>课程时长：<?=floor($videoInfo->courseTime/60) . ':' . (($videoInfo->courseTime%60 < 10) ? ('0'.$videoInfo->courseTime%60) : ($videoInfo->courseTime%60));?></p>
                            <a href="javascript:;">开始学习&nbsp;<span>></span></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var subjectCtnList = document.getElementsByClassName('subjectCtn');
        for (var i = 0; i < subjectCtnList.length; i++) {
            subjectCtnList[i].onclick = function () {
                BHWEB.toPlayVideo(this.getAttribute('data-id'));
            }
        }


        $('#goBack').tap(function () {
            window.history.back();
        });

    }, false);

</script>

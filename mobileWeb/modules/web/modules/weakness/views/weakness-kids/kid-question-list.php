<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-13
 * Time: 下午2:06
 */

/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static/js/appMethods.js' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/kidErrQuestionList.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/zepto.min.js' . RESOURCES_VER);
?>

<div class="wrapper">
    <div class="header">
        <div class="nav">
            <a href="javascript:;" id="goBack" class="back">
                <img src="<?php BH_CDN_RES ?>/static/img/back.png">
            </a>
        </div>
        <div class="headerTitle"><?= $knowledgeInfo ? $knowledgeInfo->kidName : ''; ?></div>
    </div>
    <?php if (count($kidQuestionList) == 0) {
        \mobileWeb\components\ViewHelper::emptyView("此知识点没有错题");
    } else { ?>
        <div class="homeworkReport" id="errWorkList" data-date="<?=$date?>" data-kid="<?=$kid?>">
            <div id="errWorkHeight">
                <div class="errPart">
                    <div class="errWork">
                        <div class="errTitle">
                            <span class="gang">|</span><h5>知识点讲解</h5>
                        </div>
                        <?php if ($knowledgeInfo && $knowledgeInfo->videoInfo) { ?>
                            <div class="subjectCtn" data-id="<?= $knowledgeInfo->videoInfo->videoId ?>">
                                <img src="<?= $knowledgeInfo->videoInfo->courseResId ?>">
                                <h5 class="subjectTitle"><?= $knowledgeInfo->videoInfo->videoTitle ?></h5>
                                <div class="subjectTime">
                                    <p>
                                        课程时长：<?= (floor($knowledgeInfo->videoInfo->courseTime / 60) < 10 ? '0'.floor($knowledgeInfo->videoInfo->courseTime / 60):floor($knowledgeInfo->videoInfo->courseTime / 60)) . ':' . (($knowledgeInfo->videoInfo->courseTime % 60) < 10 ? '0'.($knowledgeInfo->videoInfo->courseTime % 60) : $knowledgeInfo->videoInfo->courseTime % 60) ?></p>
                                    <a href="javascript:;">开始学习&nbsp;<span>></span></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="errWorkList" id="errQuestionList">
                    <?= $this->render('//publicView/weakness/_questions', ['questionList' => $kidQuestionList, 'date' => $date]) ?>
                </div>
                <p style="display: none; text-align: center;" class="loadMore" id="loadMore">加载更多</p>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {

        var $errWorkList = $('#errWorkList');
        var date = $errWorkList.attr('data-date');
        var kid = $errWorkList.attr('data-kid');
        var subjectCtnList = document.getElementsByClassName('subjectCtn');
        for (var i = 0; i < subjectCtnList.length; i++) {
            subjectCtnList[i].onclick = function () {
                BHWEB.toPlayVideo(this.getAttribute('data-id'));
            }
        }

        $('#goBack').tap(function () {
            window.history.back();
        });

        var errWorkBox = $('.errWorkBox');
        if (errWorkBox.length > 0) {
            var clientH =  document.body.clientHeight;
            $errWorkList.height(clientH - 70 -10);
            //加载更多
            var on_off = 0;
            var page_index = 2;
            // 最外层div id
            $errWorkList.on('scroll', function () {
                if (errWorkBox.length < 10) {
                    on_off = 1000;
                    return;
                }

                // 整个内容的高度
                var errWorkHeight = $('#errWorkHeight').offset().height;

                if ((errWorkHeight - this.scrollTop - this.offsetHeight + 10 + on_off) <= 0) {
                    on_off = 1000;

                    // 在最外层最下面 p 标签
                    $('#loadMore').css('display','block');
                    //获取参数
                    setTimeout(function () {
                        $.get('/web/weakness/weakness-kids/kid-question-list', {
                            kid: kid,
                            date: date,
                            page: page_index++
                        }, function (data) {
                            var html = '';
                            var imageStar = '<img src="/static/img/gradeStart.png">';
                            $.each(data.data, function (key, item) {
                                switch (item.difficult) {
                                    case 21101:
                                        questionStar = imageStar + '<span>容易</span>';
                                        break;
                                    case 21102:
                                        questionStar = imageStar + imageStar + '<span>较易</span>';
                                        break;
                                    case 21103:
                                        questionStar = imageStar + imageStar + imageStar + '<span>一般</span>';
                                        break;
                                    case 21104:
                                        questionStar = imageStar + imageStar + imageStar + imageStar + '<span>较难</span>';
                                        break;
                                    case 21105:
                                        questionStar = imageStar + imageStar + imageStar + imageStar + imageStar + '<span>困难</span>';
                                        break;
                                    default:
                                        questionStar = imageStar + '<span>容易</span>';
                                }
                                var datal = item.wrongTime;
                                var arrl = datal.split(" ");
                                datal = arrl[0].replace(/-/g,"/");
                                var dateTime = datal;


                                html += '<div class="errWorkBox">'
                                    + '<div class="errWorkCtn">'
                                    + '<a style="color: #000" href="/web/weakness/error-questions/question-info?questionId=' + item.questionId + '&date=' + date +'">' + item.content + '</a>'
                                    + '</div>'
                                    + '<div class="gradeStart">' + questionStar
                                    + '<p>' + dateTime + '</p>'
                                    + '</div>'
                                    + '</div>'
                            });
                            var kidList = data.data;
                            if (kidList.length == 0) {
                                on_off = 1000;
                                $('#loadMore').html('已经到底了');
                            } else {
                                // 添加包裹所有片段的div  errWorkHeight
                                $('#errQuestionList').append(html);
                                $('#loadMore').css('display','none');
                                on_off = 0
                            }
                        });
                    }, 1000);
                }
            })
        }
    });

</script>
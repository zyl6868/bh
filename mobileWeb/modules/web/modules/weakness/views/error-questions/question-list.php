<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午3:33
 */
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static/js/appMethods.js' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/errQuestionList.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/zepto.min.js' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/errQuestionList.js' . RESOURCES_VER);
?>

<div class="wrapper">
    <div class="header">
        <?= $this->render('//publicView/weakness/_my_weakness_header', ['date' => $date]) ?>
    </div>

    <div class="selectSubject">
        <?= $this->render('//publicView/weakness/_subject_and_complexity',
            ['subjectName' => $subjectName, 'userInfo' => $userInfo, 'subjectId' => $subjectId,
                'complexity' => $complexity, 'date' => $date]) ?>
    </div>
    <div class="shadeBox" id="shadeBox"></div>

    <?php if (count($questionList) == 0) {
        \mobileWeb\components\ViewHelper::emptyView("最近暂无错题");
    } else { ?>
        <div class="errWorkList" id="errWorkList" data-date="<?=$date?>" data-subject-id="<?=$subjectId?>" data-complexity="<?=$complexity?>">
            <p class="errWorkListTitle"><?=$monthNum?>月份错题</p>
            <div id="errWorkHeight">
                <?= $this->render('//publicView/weakness/_questions', ['questionList' => $questionList, 'date' => $date]) ?>
            </div>
            <p class="loadMore" id="loadMore">加载更多</p>
        </div>
    <?php } ?>

</div>

<script>
    history.replaceState(null, "", "");

    document.addEventListener("DOMContentLoaded", function () {


        var errWorkBox = $('.errWorkBox');
        var $errWorkList = $('#errWorkList');
        var date = $errWorkList.attr('data-date');
        var subjectId = $errWorkList.attr('data-subject-id');
        var complexity = $errWorkList.attr('data-complexity');
        if (errWorkBox.length > 0) {

            var clientH = document.body.clientHeight;
            $errWorkList.css('height', (clientH - 115 - 10) + 'px') ;
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
                if ((errWorkHeight - this.scrollTop - this.offsetHeight + 30 + on_off) <= 0) {
                    on_off = 1000;

                    // 在最外层最下面 p 标签
                    $('#loadMore').css('display','block');

                    setTimeout(function () {
                        $.get('<?=Url::to([''])?>', {
                            subjectId: subjectId,
                            complexity: complexity,
                            date: date,
                            page: page_index++
                        }, function (data) {
                            var html = '';
                            $.each(data.data, function (key, item) {
                                var difficult = item.difficult;

                                var xing = '<img src="/static/img/gradeStart.png">';
                                var str = xing + '<span>容易</span>';

                                if (difficult == 21101) {
                                    str = xing + '<span>容易</span>';
                                } else if (difficult == 21102) {
                                    str = xing + xing + '<span>较易</span>';
                                } else if (difficult == 21103) {
                                    str = xing + xing + xing + '<span>一般</span>';
                                } else if (difficult == 21104) {
                                    str = xing + xing + xing + xing + '<span>较难</span>';
                                } else if (difficult == 21105) {
                                    str = xing + xing + xing + xing + xing + '<span>困难</span>';
                                }


                                var datal = item.wrongTime;
                                var arrl = datal.split(" ");
                                datal = arrl[0].replace(/-/g,"/");
                                var dateTime = datal;

                                html += '<div class="errWorkBox">' +
                                    '<div class="errWorkCtn">' +
                                    '<a style="color:#000" href="/web/weakness/error-questions/question-info?questionId=' + item.questionId + '&date=' + date +'">' + item.content + '</a>' +
                                    '</div>' +
                                    '<div class="gradeStart">' + str +
                                    '<p>' + dateTime + '</p>' + '</div> </div>';

                            });
                            var errorList = data.data;
                            if (errorList.length == 0) {
                                on_off = 1000;
                                $('#loadMore').html('已经到底了');
                            } else {
                                // 添加包裹所有片段的div  errWorkHeight
                                $('#errWorkHeight').append(html);

                                $('#loadMore').css('display', 'none');
                                on_off = 0;
                            }
                        });
                    }, 1000);
                }
            })
        }
    });

</script>
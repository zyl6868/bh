<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午2:47
 */

use yii\helpers\Url;

/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static/js/appMethods.js' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/homeworkList.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/zepto.min.js' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/fastclick.js' . RESOURCES_VER);
?>


<div class="wrapper">
    <div class="header">
        <div class="nav">
            <a href="javascript:;" class="back" id="back">
                <img src="<?php BH_CDN_RES ?>/static/img/back.png">
            </a>
        </div>
        <div class="headerTitle">讲作业</div>
    </div>

    <div class="hwTitle clearfix">
        <p class="homeWorkInfo">你<span id="mounth"><?=$monthNum ?></span>月完成的作业（只包含有讲解课程的）</p>
        <div class="calendar" id="calendar"><img src="<?php BH_CDN_RES ?>/static/img/calendar.png"" alt=""></div>
        <ul id="dates">
        </ul>
    </div>

    <?php if (count($homeworkList) == 0) {
        \mobileWeb\components\ViewHelper::emptyView();
    } else { ?>

    <div class="homeworkList">
        <?php foreach ($homeworkList as $item) { ?>
            <div class="homeworkBox">
                <h5><?=$item->subjectName?>作业</h5>
                <p class="homeworkCtn"><?= $item->homeworkName ?></p>
                <div class="homeworkTime">
                    <img src="<?php BH_CDN_RES ?>/static/img/time.png">&nbsp;
                    <span>完成时间：&nbsp;</span>
                    <span><?= date("Y", strtotime($item->uploadTime)) . '年' . date("m", strtotime($item->uploadTime)) . '月' . date("d", strtotime($item->uploadTime)) . '日' ?></span>
                </div>
                <p class="homeworkOk">正确率：<span><?= $item->correctRate ?>
                        %</span>&nbsp;&nbsp;错&nbsp;<span><?= $item->mistakes ?></span>&nbsp;题</p>
                <div class="homeworkBtn">
                    <div class="teachBtn watchTeach" data-id="<?= $item->videoInfo ? $item->videoInfo->videoId : 0; ?>">
                        <img src="<?php BH_CDN_RES ?>/static/img/teach.png" alt="">
                        看讲解
                    </div>
                    <a href="<?= Url::to(['/web/homework/my-homework/homework-info', 'homeworkAnswerId' => $item->homeworkAnswerID]) ?>">
                        <div class="teachBtn errWork">
                            <img src="<?php BH_CDN_RES ?>/static/img/errWork.png" alt="">
                            查错题
                        </div>
                    </a>
                </div>
            </div>
        <?php } }?>
    </div>
</div>


<script type="text/javascript">

    //返回
    document.addEventListener('DOMContentLoaded', function() {
        FastClick.attach(document.body);

        var date = new Date();
        var year = date.getFullYear();
        var months = date.getUTCMonth() + 1;

        var datesHtml = '';
        var MonthsList = [];  // 月份列表
        var yearLi = year;
        var monthsLi = months;
        for (var i = 1; i <= 6; i++) {
            if (monthsLi == 0) {
                monthsLi = 12;
                yearLi -= 1;
            }
            MonthsList.unshift(monthsLi);
            monthsLi = monthsLi < 10 ? '0' + monthsLi : monthsLi;
            datesHtml += '<li>' + yearLi + '-' + monthsLi + '</li>';
            monthsLi--;
        }
        $('#dates').html(datesHtml);
        // 点击日历
        $('#calendar').tap(function () {
            $('#dates').css('display', 'block');
            return false;
        });
        $('*').not('#calendar').tap(function () {
            $('#dates').hide();
        });

        $("#dates li").tap(function () {
            var searchTime = $(this).html();
            // 获取到月份跳转 ？？？？？？？？？？？？？？/
            location.href = "/web/homework/my-homework/homework-list?date=" + searchTime;
        });

        $('#back').tap(function () {
            BHWEB.pop();
        });

        var watchTeachs = document.getElementsByClassName('watchTeach');
        for (var i = 0; i < watchTeachs.length; i++) {
            watchTeachs[i].onclick = function () {
                BHWEB.toPlayVideo(this.getAttribute('data-id'));
            }
        }
    }, false);



</script>
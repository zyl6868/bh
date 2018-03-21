<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-4-20
 * Time: 上午11:47
 */
?>

<li class="clearfloat">
    <div class="year fl">
        <span>2017</span>年
    </div>
    <ul class="fl list">
        <li class="start"><img src="<?= BH_CDN_RES . '/static' ?>/images/dot.png" alt=""></li>
        <li class="line"></li>
        <li class="month clearfloat">
            <div class="fl">3月</div>
            <p class="fl">
                <span class="count1">3月份余额</span>
                <span class="count2">2200</span>
                <a href="javascript:;">兑换</a>
            </p>
        </li>
        <li class="line"></li>
        <li class="month clearfloat">
            <div class="fl">3月</div>
            <p class="fl">
                <span class="count1">3月份余额</span>
                <span class="count2">2200</span>
                <a href="javascript:;">兑换</a>
            </p>
        </li>
        <li class="line"></li>
        <li class="month clearfloat">
            <div class="fl">3月</div>
            <p class="fl">
                <span class="count1">3月份余额</span>
                <span class="count2">2200</span>
                <a href="javascript:;">兑换</a>
            </p>
        </li>
        <li class="line"></li>
    </ul>
</li>
<p id="addMore">点击加载更多 <span>↓</span></p>
<script>
    $('#addMore').click(function () {

        var year = $('.year:last').children('span').text();

        $('.list:last').append('<li class="month clearfloat">' +
                            '<div class="fl">3月</div> <p class="fl">' +
                            '<span class="count1">3月份余额</span>' +
                            '<span class="count2">2200</span>' +
                            '<a href="javascript:;">兑换</a>' +
                            '</p> </li> ' +
                            '<li class="line"></li>');
    })

</script>
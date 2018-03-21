<?php

use yii\helpers\Html;

?>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        list-style: none;
        -webkit-user-select: none; /*不允许用户选中文字*/
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        -webkit-tap-highlight-color: transparent;
        -webkit-overflow-scrolling: touch;
        -webkit-box-sizing: border-box;
    }
    html, body {
        width: 100%;
        height: 100%;
        background-color: #f9f9f9
    }
    a {
        text-decoration: none;
        -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
    }
    li {
        list-style: none;
    }
    .clearfix:after {
        content: '';
        display: table;
        clear: both;
    }

    .clearfix {
        *zoom: 1;
    }
    .fl {
        float: left;
    }
    .fr {
        float: right;
    }
    .wrapper {
        width: 100%;
        min-height: 100%;
        overflow: hidden;
        font-size: 14px;
        padding: 0 6px;
        position: relative;
        background-color: #f9f9f9;
    }
    .banner {
        width: 100%;
    }
    .banner img {
        display: block;
        width: 100%;
    }
    .totalContribution {
        height: 32px;
        line-height: 32px;
        font-size: 14px;
        color: #555;
        margin: 10px 0;
        padding: 0 10px;
        background-color: #fff;
        border-radius: 6px;
    }
    .totalContribution > p > span {
        color: #999;
    }
    .totalContribution > span {
        color: #2a51ed;
    }
    .nearestContribution {
        color: #555;
        text-indent: 10px;
    }
    .nearestContribution img {
        width: 1.8px;
    }
    .nearestContribution span {
        color: #999;
    }
    .contributionTable {
        width: 100%;
        color: #555;
        background-color: #fff;
        border-radius: 6px;
        margin: 10px auto;
    }
    .tableHead {
        font-weight: 700;
        height: 35px;
        line-height: 35px;
        padding: 0 1%;
        border-radius: 6px 6px 0 0;
        background-color: #d6e2ff;
    }
    .tableHead li {
        width: 29%;
        margin: 0 2%;
        float: left;
        text-align: center;
    }
    .tableHead li:first-child {
        text-align: left;
    }
    .tableHead li:last-child {
        text-align: right;
    }
    .tableBody {
        padding: 0 1%;
    }
    .tableBody > li {
        height: 33px;
        line-height: 33px;
    }
    .tableBody > li:last-child {
        border: none;
    }
    .tableBody > li > ul > li {
        width: 29%;
        margin: 0 2%;
        float: left;
        text-align: center;
    }
    .tableBody > li > ul {
        border-bottom: 1px solid #e8e8e8;
    }
    .tableBody > li > ul > li:first-child {
        text-align: left;
    }
    .tableBody > li > ul > li:last-child {
        text-align: right;
    }
    .noList {
        display: block;
        width: 40%;
        margin: 30px auto 10px;
    }

    .noListInfo {
        color: #555;
        text-align: center;
    }
</style>
<div class="inviteContent">
    <div class="wrapper">
        <div class="banner">
            <img src="<?= BH_CDN_RES . '/static' ?>/images/inviteBanner.png?v=20180124142800">
        </div>
        <div class="totalContribution">
            <p class="fl">好友累计贡献<span>(上个月)</span></p>
            <span class="fr"><?php echo $xuemiTotal ?>学米</span>
        </div>
        <div class="nearestContribution">
            <img src="<?= BH_CDN_RES . '/static' ?>/images/inviteTitleLine.png" 　>
            好友贡献明细<span>(最近1个月)</span>
        </div>

        <?php if (count($inviteArray) > 0) { ?>
            <div class="contributionTable">

                <ul class="tableHead clearfix">
                    <li>姓&nbsp;&nbsp;&nbsp;名</li>
                    <li>贡献项</li>
                    <li>贡献值</li>
                </ul>
                <ul class="tableBody">

                    <?php foreach ($inviteArray as $v) { ?>
                        <li>
                            <ul>
                                <li><?php echo Html::encode(cut_str($v->contributorTrueName, 4)); ?></li>
                                <li><?php echo Html::encode(cut_str($v->memo, 4, "")) ?></li>
                                <li><?= $v->xueMi ?>学米</li>
                            </ul>
                        </li>
                    <?php
                        }
                    ?>
                </ul>

            </div>
        <?php } else { ?>

            <img class="noList" src="<?= BH_CDN_RES . '/static' ?>/images/inviteNo.png" >
            <p class="noListInfo">暂无邀请记录</p>
        <?php } ?>


    </div>

</div>

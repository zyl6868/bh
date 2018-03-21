<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-5-3
 * Time: 下午6:02
 */
use yii\captcha\Captcha;
use yii\web\View;
$this->title = '班海申请';
/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static' . '/js/jquery.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/applyUsing.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static' . '/js/app/invite/appInviteTeacher.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);


?>
<div id="app">
    <img class="titleImg" src="<?= BH_CDN_RES . '/static' ?>/images/inviteT.jpg" alt="">
    <div class="row"></div>
    <div class="reply1">
        <p>“集结”220万题库、110万教案课件、70万精品作业、22000微课！ </p>
        <p>一键“布置、批改”作业，试题库智能匹配，轻松搞定作 业难题！ </p>
        <p>协助老师“管理”班级，轻松知晓班级学生知识薄弱点和 短板！ </p>
        <p>班海大数据，学校、班级、学生按需进行分析，快速找到 问题所在！ </p>
        <p>独有学米奖励，话费、手机、电脑轻松抱回家！</p>
    </div>
    <div class="reply2">
        <div class="form">
            <input type="text" id="applyName" placeholder="请输入姓名"/>
            <input type="text" id="applyPhone" placeholder="请输入11位手机号码"/>
            <img id="apply" src="<?= BH_CDN_RES . '/static' ?>/images/btn.png" alt="">
        </div>
        <img class="imgReply2" src="<?= BH_CDN_RES . '/static' ?>/images/reply.png" alt="">
    </div>
    <div class="userRule">
        <hr>
        <div class="ruleTitle">申请使用规则</div>
        <div class="ruleContent">
            <img src="<?= BH_CDN_RES . '/static' ?>/images/applyQRCode.jpg" alt="">
            <p>第一步：填写姓名和手机号，选择“班海申请”。</p>
            <p>第二步：扫描下方二维码或直接搜索客服微信号：<span class="yellow">qgsjzx</span>添加好友。备注“班海申请”，客服核实信息后将指导您如何激活账号。</p>
            <p>第三步：登陆激活后的班海账号，即可免费体验班海给您带来的便捷。</p>
        </div>
    </div>
</div>

<div id="hint"></div>
<div id="hint1" style="display: none">
    <div class="mask"></div>
    <div class="content">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/hint.jpg" alt="">
        <p>知道了</p>
    </div>
</div>
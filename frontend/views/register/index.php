<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title="注册";

$this->blocks['requireModule']='app/site/register';
?>

<div class="gnn_container">
    <div class="content">
        <h1>我是？请选择身份注册！</h1>
        <ul class="register_user clearfix">
            <li class="teacher">
                <dl class="clearfix">
                    <dt>
                        <span class="role">老师</span>
                        <a href="<?php echo Url::to(["register/teacher"]);?>" id="registerTch" class="tch"></a>
                    </dt>
                    <dd>or</dd>
                </dl>
            </li>
            <li class="student">
                <dl class="clearfix">
                    <dt>
                        <span class="role">学生</span>
                        <a href="<?php echo url(['register/student']);?>" id="registerStu" class="stu"></a>
                    </dt>
                    <dd>or</dd>
                </dl>
            </li>
            <li class="genearch">
                <dl class="clearfix">
                    <dt>
                        <span class="role">家长</span>
                        <a href="javascript:void(0);" id="registerGch" class="gch"></a>
                    <div class="qr-code" id="gnn_QRCode">
                        <p>家长用户请使用手机APP注册<span>扫一扫立即下载安装</span></p>
                        <img src="/static/images/gnn_QRCode_03.jpg">
                        <u id="claseQRCode"></u>
                    </div>
                    </dt>
                </dl>
            </li>
        </ul>
    </div>
</div>
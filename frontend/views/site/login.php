<?php
/* @var $this yii\web\View */

use frontend\components\CHtmlExt;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "登录";
$backend_asset = BH_CDN_RES . '/pub';
?>

<!doctype html>
<html id="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">
    <meta name="keywords" content="班海,班海网,班海平台,banhai,学校,教师,学生,老师,当周问题,当周解决"/>
    <meta name="description"
          content="班海网专注K12中小学在线教育，是基于移动互联网技术、云技术、语言交互技术而创建的最专业的中小学教学管理平台，力求当周问题当周解决，为全国5000多所学校提供全方位的教学管理解决方案。"/>

    <title>班海网_当周问题当周解决_最专业的中小学教学管理平台</title>

    <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <link href="<?php echo BH_CDN_RES . '/static' ?>/css/base.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BH_CDN_RES . '/static' ?>/css/jquery-ui.css<?= RESOURCES_VER ?>" rel="stylesheet"
          type="text/css">
    <link href="<?php echo BH_CDN_RES . '/static' ?>/css/popBox.css<?= RESOURCES_VER ?>" rel="stylesheet"
          type="text/css">
    <link href="<?php echo BH_CDN_RES . '/static' ?>/css/index.css<?= RESOURCES_VER ?>" rel="stylesheet"
          type="text/css">
    <?= Html::jsFile($backend_asset . "/js/jquery-1.7.1.min.js" . RESOURCES_VER) ?>
    <?= Html::jsFile($backend_asset . "/js/jquery-ui.min.js" . RESOURCES_VER) ?>

    <?= Html::jsFile($backend_asset . "/js/jquery.validationEngine.min.js") ?>
    <?= Html::jsFile($backend_asset . "/js/jquery.validationEngine-zh_CN.js") ?>

    <script>
        $(function () {
            $('.mark').click(function () {
                $(this).toggleClass('chked')
            });

        });

    </script>

    <style>


        /* Z-INDEX */
        .formError {
            z-index: 990;
        }

        .formError .formErrorContent {
            z-index: 991;
        }

        .formError .formErrorArrow {
            z-index: 996;
        }

        .formErrorInsideDialog.formError {
            z-index: 5000;
        }

        .formErrorInsideDialog.formError .formErrorContent {
            z-index: 5001;
        }

        .formErrorInsideDialog.formError .formErrorArrow {
            z-index: 5006;
        }

        .inputContainer {
            position: relative;
            float: left;
        }

        .formError {
            position: absolute;
            top: 300px;
            left: 300px;
            display: block;
            cursor: pointer;
        }

        .ajaxSubmit {
            padding: 20px;
            background: #55ea55;
            border: 1px solid #999;
            display: none
        }

        .formError .formErrorContent {
            width: 100%;
            background: #ee0101;
            position: relative;
            color: #fff;
            width: 150px;
            font-size: 11px;
            border: 2px solid #ddd;
            box-shadow: 0 0 6px #000;
            -moz-box-shadow: 0 0 6px #000;
            -webkit-box-shadow: 0 0 6px #000;
            padding: 4px 10px 4px 10px;
            border-radius: 6px;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
        }

        .greenPopup .formErrorContent {
            background: #33be40;
        }

        .blackPopup .formErrorContent {
            background: #393939;
            color: #FFF;
        }

        .formError .formErrorArrow {
            width: 15px;
            margin: -2px 0 0 13px;
            position: relative;
        }

        body[dir='rtl'] .formError .formErrorArrow,
        body.rtl .formError .formErrorArrow {
            margin: -2px 13px 0 0;
        }

        .formError .formErrorArrowBottom {
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            margin: 0px 0 0 12px;
            top: 2px;
        }

        .formError .formErrorArrow div {
            border-left: 2px solid #ddd;
            border-right: 2px solid #ddd;
            box-shadow: 0 2px 3px #444;
            -moz-box-shadow: 0 2px 3px #444;
            -webkit-box-shadow: 0 2px 3px #444;
            font-size: 0px;
            height: 1px;
            background: #ee0101;
            margin: 0 auto;
            line-height: 0;
            font-size: 0;
            display: block;
        }

        .formError .formErrorArrowBottom div {
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        .greenPopup .formErrorArrow div {
            background: #33be40;
        }

        .blackPopup .formErrorArrow div {
            background: #393939;
            color: #FFF;
        }

        .formError .formErrorArrow .line10 {
            width: 15px;
            border: none;
        }

        .formError .formErrorArrow .line9 {
            width: 13px;
            border: none;
        }

        .formError .formErrorArrow .line8 {
            width: 11px;
        }

        .formError .formErrorArrow .line7 {
            width: 9px;
        }

        .formError .formErrorArrow .line6 {
            width: 7px;
        }

        .formError .formErrorArrow .line5 {
            width: 5px;
        }

        .formError .formErrorArrow .line4 {
            width: 3px;
        }

        .formError .formErrorArrow .line3 {
            width: 1px;
            border-left: 2px solid #ddd;
            border-right: 2px solid #ddd;
            border-bottom: 0 solid #ddd;
        }

        .formError .formErrorArrow .line2 {
            width: 3px;
            border: none;
            background: #ddd;
        }

        .formError .formErrorArrow .line1 {
            width: 1px;
            border: none;
            background: #ddd;
        }

        #logon {
            margin-top: 27px;
            display: block;
        }

        .accountLogin {
            display: none;
        }

        .qrcodeLogin h5 {
            text-align: center;
        }

        .qrcodeLogin .qrcode {
            margin: 15px 50px 30px;
            text-align: center;
        }

        .loginbar .togbar {
            width: 300px;
            height: 48px;
            margin: -20px 0 10px;
            font-size: 20px;
            text-align: center;
            font-weight: 700;
            line-height: 40px;
        }

        .loginbar .togbar .loginIn {
            width: 149px;
            float: left;
        }

        .loginbar .togbar .loginIn.selBlue {
            color: #36b0e9;
        }

        .loginbar .togbar .togbarLine {
            display: block;
            width: 2px;
            height: 26px;
            margin-top: 7px;
            float: left;
            background-color: #666;
        }

        .msg-err {
            width: 160px;
            height: 160px;
            background: #36b0e9;
            position: absolute;
            left: 100px;
            top: 80px;
            display: none;
            border-radius: 8px;
        }

        .msg-err h6 {
            color: #fff;
            margin-top: 38px;
            margin-bottom: 8px;
            text-align: center;
        }

        .msg-err .refresh {
            width: 100px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            margin: 0 auto;
            background: #f5a91f;
            display: block;
            color: #fff;
            border-radius: 3px;
        }

    </style>
</head>
<body>
<div class="warp">
    <div class="header">客服热线 : 400-8986-838</div>
    <div class="gnn_container">
        <div class="content">
            <div class="loginbar">
                <div class="togbar clearfix">
                    <div class="sacnLogin loginIn selBlue" id="sacnLogin">扫码登录</div>
                    <sapn class="togbarLine"></sapn>
                    <div class="idLogin loginIn" id="idLogin">账号登录</div>
                </div>
                <div class="qrcodeLogin">
                    <div class="qrcode" id="qr">
                        <img src="" alt="" class="qr" width="160"
                             height="160"/>
                        <div class="msg-err">
                            <h6>二维码已失效</h6>
                            <a href="javascript:;" class="refresh">请刷新网页</a>
                        </div>
                    </div>
                    <div>
                        <h5>打开班海或班海教师APP,扫描二维码</h5>
                    </div>
                </div>

                <div class="accountLogin">
                    <?php $form = ActiveForm::begin(array(
                        'enableClientScript' => false,
                        'id' => 'form_id'
                    )) ?>
                    <div class="gnn_userName">
                        <label></label>
                        <input type="text" class="text validate[required]"
                               id="<?php echo Html::getInputId($model, 'userName') ?>"
                               name="<?php echo Html::getInputName($model, 'userName') ?>"
                               value="<?php echo $model->userName ?>"
                               data-validation-engine="validate[required]"
                               data-errormessage-value-missing="用户名不能为空"
                        />
                        <?php echo CHtmlExt::validationEngineError($model, 'userName') ?>


                    </div>
                    <div class="gnn_password">
                        <label></label>
                        <input type="password" class="text validate[required]"
                               id="<?php echo Html::getInputId($model, 'passwd') ?>"
                               name="<?php echo Html::getInputName($model, 'passwd') ?>"
                               data-validation-engine="validate[required,minSize[6],maxSize[20]]"
                               data-errormessage-value-missing="密码不能为空"
                        />
                        <?php echo CHtmlExt::validationEngineError($model, 'passwd') ?>
                    </div>
                    <div class="nameRelevant">
                        <div class="nameReleLeft">
                            <input type="checkbox" checked id="mark_chkbox"
                                   name="<?php echo Html::getInputName($model, 'rememberMe') ?>"
                                   value="1" class="mark">记住账号
                        </div>
                        <a href="<?php echo url('site/recover-password'); ?>">忘记登录密码?</a>
                    </div>
                    <button type="submit" class="loginButton" onclick="return load(this);">
                        登录
                    </button>
                    <?php \yii\widgets\ActiveForm::end() ?>
                </div>

                <div class="flowLayer" id="flowLayer"></div>
                <div class="gnn_QRCode pop" id="gnn_QRCode">
                    <h2>教师客户端扫码安装</h2>
                    <img style="width: 115px" src="<?php echo BH_CDN_RES . '/static' ?>/images/gnn_QRCode_teacher.png">
                    <hr/>
                    <h2>学生客户端扫码安装</h2>
                    <img style="width: 115px" src="<?php echo BH_CDN_RES . '/static' ?>/images/gnn_QRCode_student.png">
                    <div class="triangle"></div>
                    <div class="gnn_text" id="gnn_text"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="chapter">
            班海平台入驻<strong>5631所</strong>学校、<strong>493611位</strong>教师、<strong>7523193位</strong>学生<br>有<strong>70万</strong>作业库、<strong>85900个</strong>微课、<strong>121万</strong>课件、<strong>368万</strong>试题
        </div>
        <div class="address">
            <div class="weChat">
                官方微信
                <div class="weChatIcon" id="weChatIcon">
                    <div class="weChatBigIcon pop" id="weChatBigIcon">
                        <h1>扫一扫 关注班海微信</h1>
                        <img src="<?php echo BH_CDN_RES . '/static' ?>/images/gnn_QRCode_09.jpg">
                    </div>
                </div>
            </div>
            <div class="copyright">北京三海教育科技有限公司 ©版权所有 <a class="icpCode" href="http://www.miibeian.gov.cn/"
                                                         target="_blank">京ICP备14022510号</a>
                <a href="http://www.beian.gov.cn/portal/index" target="_blank" style="color: #999"><img
                            src="/pub/images/ghs.png" alt="">京公网安备 11010802023163 号</a></div>
        </div>
    </div>
</div>

<script>
    var code = '';
    var defaultUrl = "/qrcode/login?code=";
    var times = 1;
    var scanId;
    var desultSrc = "<?php echo BH_CDN_RES . '/static' ?>/images/loading.gif"
    $(document).bind("mouseup", function (e) {
        var target = $(e.target);
        if (target.closest(".pop").length == 0) $(".pop").hide()
    });
    $(function () {

        function getCode() {
            clearInterval(scanId);
            $(".qr").attr("src", desultSrc);
            $.post('/scancode/login/code', {}, function (data) {
                if (data.success == true) {
                    code = data.data;
                    $(".qr").attr("src", defaultUrl + code);
                    $('.msg-err').hide();
                    scanId = setInterval(function () {
                            $.get("/scancode/login/get-code-user-info", {"code": code}, function (data) {
                                if (data.success == true && data.data.isSureLogin == 1) {
                                    clearInterval(scanId);
                                    userName = data.data.userName;
                                    $.post("/site/scan-code-login", {"userName": userName}, function (data) {
                                        if (data.success == true) {
                                            window.location.href = data.data;
                                        }
                                    })
                                    return false;
                                }
                                times++;
                                if (times > 90) {                   //三分钟取消定时任务
                                    $('.msg-err').show();
                                    clearInterval(scanId);
                                    times = 1;
                                }
                            })
                        }
                        , 2000);
                }
            });
        }



        getCode();


        $("#sacnLogin").click(function () {
            if (!$(this).hasClass('selBlue')) {
                console.log(1);
                $(".loginIn").removeClass('selBlue');
                $(this).addClass('selBlue');
                $(".accountLogin").hide();
                $(".qrcodeLogin").show();
                getCode();
            }
        })
        $("#idLogin").click(function () {
            $(".loginIn").removeClass('selBlue');
            $(this).addClass('selBlue');
            $(".accountLogin").show();
            $(".qrcodeLogin").hide();
            clearInterval(scanId);
            times = 1;
            $('.msg-err').hide();
        })
        $("#flowLayer").click(function () {
            $("#gnn_QRCode").stop(true, true).animate({bottom: 0, right: 0}).show();
            return false;
        });
        $("#gnn_text").click(function () {
            $("#gnn_QRCode").stop(true, true).animate({bottom: "-400px", right: "-360px"});
        });
        $("#weChatIcon").click(function () {
            $("#weChatBigIcon").show();
            return false;
        })

        $(".refresh").click(function () {
            getCode();
        });

    })
</script>
</body>
</html>
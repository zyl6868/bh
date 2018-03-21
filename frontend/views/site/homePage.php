<?php use yii\helpers\Url; ?>
<!DOCTYPE html>
<html lang="en" style="overflow:visible;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1200, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">
    <meta name="renderer" content="webkit|ie-stand|ie-comp">
    <meta name="keywords" content="班海,班海网,班海平台,banhai,学校,教师,学生,老师,当周问题,当周解决"/>
    <meta name="description"
          content="班海网专注K12中小学在线教育，是基于移动互联网技术、云技术、语言交互技术而创建的最专业的中小学教学管理平台，力求当周问题当周解决，为全国5000多所学校提供全方位的教学管理解决方案。"/>

    <title>班海网</title>
    <link rel="stylesheet" href="<?php echo BH_CDN_RES ?>/static/css/homePage.css?v=14764315261" type="text/css">
</head>
<body>
<div id="content">
    <div class="page" id="firstPage">
        <div id="header">
            <img src="<?php echo BH_CDN_RES ?>/static/images/banhaiLogo.jpg" alt="">
            <ul>
                <li><a href="<?php echo Url::to('/site/login') ?>"><i id="login"></i>登录</a></li>
                <li id="downloadQR"><a href="javascript:;" ><i id="download"></i>下载APP</a></li>
                <li id="materialShow"><a href="javascript:;">资源投屏</a></li>
                <li>客服热线:400-8986-838</li>
            </ul>
        </div>
        <div class="gnn_QRCode pop" id="gnn_QRCode" style="display: none">
            <h2>教师客户端扫码安装</h2>
            <img style="width: 115px" src="<?php echo BH_CDN_RES.'/static'?>/images/gnn_QRCode_teacher.png">
            <hr/>
            <h2>学生客户端扫码安装</h2>
            <img style="width: 115px" src="<?php echo BH_CDN_RES.'/static'?>/images/gnn_QRCode_student.png">
        </div>
        <ul id="carousel">
            <li class="count1 image">
                <img src="<?php echo BH_CDN_RES ?>/static/images/homePage/HomePageB1.jpg" alt="">
            </li>
            <li class="count2 image">
                <img src="<?php echo BH_CDN_RES ?>/static/images/homePage/HomePageB2.jpg" alt="">
            </li>
            <li class="count2 image">
                <img src="<?php echo BH_CDN_RES ?>/static/images/homePage/HomePageB3.jpg" alt="">
            </li>
            <ol id="dots">
                <li class="active"></li>
                <li></li>
                <li></li>
            </ol>
        </ul>
    </div>
    <div class="page image"><img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img1.jpg" alt=""></div>
    <div class="page image"><img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img2.jpg" alt=""></div>
    <div class="page image"><img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img3.jpg" alt=""></div>
    <div class="page image"><img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img4.jpg" alt=""></div>
    <div class="page image"><img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img5.jpg" alt=""></div>
    <div class="page image"><img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img6.jpg" alt=""></div>
    <div class="page" id="lastPage">
        <div class="image">
            <img src="<?php echo BH_CDN_RES ?>/static/images/homePage/img7.jpg" alt="">
        </div>
        <div id="footer">
            <div class="count1">官方微信</div>
            <i id="barcodeL"></i>
            <div class="count2">
                <span>北京三海教育科技有限公司 ©版权所有</span>
                <a href="http://www.miibeian.gov.cn/">京ICP备14022510号</a>
                <img src="/pub/images/ghs.png" alt="" draggable="false" ondragstart="return false;">
                <a href="http://www.beian.gov.cn/portal/index">京公网安备11010802023163号</a>
            </div>
            <img id="barcode" src="//c02.banhai.com/bh/static/images/appCode.jpg" alt="班海网" draggable="false"
                 ondragstart="return false;" style="display: none;">
        </div>
    </div>
    <ol id="section-btn">
        <li class="on"></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ol>
</div>



<script src="<?= BH_CDN_RES . '/static' ?>/js/jquery.js<?= RESOURCES_VER ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= BH_CDN_RES . '/static' ?>/js/lib/flexible.js<?= RESOURCES_VER ?>"></script>
<script type="text/javascript" src="<?= BH_CDN_RES . '/static' ?>/js/app/site/homePage.js<?= RESOURCES_VER ?>"></script>
</body>
<script>
//    $(document).bind("mouseup",function(e){var target=$(e.target);if(target.closest(".pop").length==0)$(".pop").hide()});
    $(function(){
        $("#downloadQR").click(function () {
            $("#gnn_QRCode").slideToggle();

        });
        $("#materialShow").click(function () {
            window.open("https://tp.banhai.com/");
        })

    })
</script>
</html>
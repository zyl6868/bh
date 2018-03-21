<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>下载APP</title>
    <link href="<?php echo BH_CDN_RES.'/static' ?>/css/downLoadApp.css<?= RESOURCES_VER?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo BH_CDN_RES.'/static' ?>/js/jquery.js<?= RESOURCES_VER?>"></script>
    <script type="text/javascript" src="<?php echo BH_CDN_RES.'/static' ?>/js/app/site/downLoadApp.js<?= RESOURCES_VER?>"></script>
</head>
<body>
<div id="header">
    <ul class="clearfloat">
        <li id="downLoad" class="fl">下载APP</li>
        <li id="phone" class="fr">客服热线:400-8986-838</li>
    </ul>
</div>
<div id="content">
    <ul id="downLoadStatus">
        <li id="status">
            <div id="status0"></div>
            <div id="status1"></div>
            <i class="status0"></i>
        </li>
        <li id="app">
            <div id="phoneModel">
                <!--轮播-->
                <div class="status_0 carousel carousel0">
                    <ul>
                        <li class="page1"></li>
                        <li class="page2"></li>
                        <li class="page3"></li>
                        <li class="page4"></li>
                    </ul>
                </div>
                <div class="status_1 carousel carousel1">
                    <ul>
                        <li class="page1"></li>
                        <li class="page2"></li>
                    </ul>
                </div>
                <div class="status_0 ico" id="ico1"></div>
                <div class="status_0 ico" id="ico2"></div>
                <div class="status_0 ico" id="ico3"></div>
                <div class="status_1 ico" id="ico4"></div>
            </div>
            <a href="javascript:;" id="carouselL"></a>
            <a href="javascript:;" id="carouselR"></a>
            <div id="carouselNum">
                <ul>
                </ul>
            </div>
            <!--轮播-->
            <div id="appIco">
                <div class="row status_0"><span>老师</span>一键推送作业 真正有用的教育平台</div>
                <div class="row status_0"><span>学生</span>当周问题 当周解决</div>
                <div class="row status_0"><span>家长</span>家校互动 实时掌握孩子学情</div>
                <div class="row status_1"><span>校长</span>管理学校更方便快捷</div>
                <ul>
                    <li>
                        <img class="status_0" src="<?= BH_CDN_RES . '/static' ?>/images/gnn_QRCode_03.jpg">
                        <img class="status_1" src="<?= BH_CDN_RES . '/static' ?>/images/gnn_QRCode_06.jpg">
                    </li>
                    <li>
                        <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.sanhai.psdapp" target="_blank" id="Android"></a>
                        <a href="https://itunes.apple.com/app/id1039730547" target="_blank" id="ios"></a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<div id="footer">
    <div class="footer clearfloat"><div class="fl">官方微信</div><i class="fl" id="barcodeL"></i><div class="fr">北京三海教育科技有限公司 &copy;版权所有 &nbsp;
            <a href="http://www.miibeian.gov.cn/" target="_blank">京ICP备14022510号</a>&nbsp;
            <a href="http://www.beian.gov.cn/portal/index" target="_blank" style="color: #999"><img src="/pub/images/ghs.png" alt="">京公网安备 11010802023163 号</a></div>
        <img id="barcode" src="<?= BH_CDN_RES . '/static' ?>/images/appCode.jpg" alt="">
    </div>
</div>
</body>
</html>
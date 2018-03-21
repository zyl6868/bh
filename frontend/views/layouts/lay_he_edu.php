<?php
/* @var $this yii\web\View */
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html id="html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">
    <link href="<?= BH_CDN_RES.'/static' ?>/css/base.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link href="<?= BH_CDN_RES.'/static' ?>/css/register.min.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">

    <script src="<?= BH_CDN_RES.'/static' ?>/js/require.js" type="text/javascript"></script>
    <script src="<?= BH_CDN_RES.'/static' ?>/js/jquery.js<?= RESOURCES_VER ?>" type="text/javascript"></script>

    <title><?php echo Yii::$app->name . '-' . $this->title; ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>

<body class="<?= ArrayHelper::getValue($this->blocks, 'bodyclass'); ?>">
<div class="header">客服热线 : 400-8986-838</div>
<!--top_end-->
<!--主体-->
<?php echo $content ?>

<!--主体end-->

<div class="footer">
    <div class="address">
        <div class="weChat">
            官方微信
            <div class="weChatIcon" id="weChatIcon">
                <div class="weChatBigIcon pop" id="weChatBigIcon">
                    <h1>扫一扫 关注班海微信</h1>
                    <img src="/static/images/gnn_QRCode_09.jpg">
                </div>
            </div>
        </div>
        <div class="copyright">北京三海教育科技有限公司  ©版权所有<a href="http://www.miibeian.gov.cn/" style="color:#666" target="_blank"> 京ICP备14022510号 </a>
            <a href="http://www.beian.gov.cn/portal/index" target="_blank" style="color: #999"><img src="/pub/images/ghs.png" alt="">京公网安备 11010802023163 号</a></div>
    </div>
</div>

<?php $this->endBody() ?>

<script type="text/javascript" charset="utf-8">
    $(function () {
        $(document).bind("mouseup",function(e){var target=$(e.target);if(target.closest(".pop").length==0)$(".pop").hide()});
        $("#weChatIcon").click(function () {
            $("#weChatBigIcon").show();
            return false;
        });
    });
</script>

<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    <?php  if (!yii::$app->user->isGuest) {
        echo sprintf("_paq.push(['setUserId', '%s']);", yii::$app->user->id);
    } ?>
    (function () {
        var u = "//tongji.banhai.com/";
        _paq.push(['setTrackerUrl', u + 'piwik.php']);
        _paq.push(['setSiteId', 1]);
        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.async = true;
        g.defer = true;
        g.src = u + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>
<noscript><p><img src="//tongji.banhai.com/piwik.php?idsite=1" style="border:0;" alt=""/></p></noscript>
<!-- End Piwik Code -->

</body>
</html>

<?php $this->endPage() ?>

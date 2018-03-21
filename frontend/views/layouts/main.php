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
    <link href="<?= BH_CDN_RES.'/pub' ?>/css/base.css<?=RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link href="<?= BH_CDN_RES.'/pub' ?>/css/jquery-ui.css<?=RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link href="<?= BH_CDN_RES.'/pub' ?>/css/popBox.css<?=RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <script src="<?= BH_CDN_RES.'/pub' ?>/js/jquery-1.7.1.min.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <script src="<?= BH_CDN_RES.'/pub' ?>/js/jquery-ui.min.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <script src="<?= BH_CDN_RES.'/pub' ?>/js/base.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <title><?php echo Yii::$app->name.'-'.$this->title; ?></title>
  <?php $this->head()  ?>
</head>

<?php
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine.min.js',['position'=>\yii\web\View::POS_HEAD ] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine-zh_CN.js', ['position'=>\yii\web\View::POS_HEAD ]);
?>

<?php $this->beginBody() ?>
<body class="<?= ArrayHelper::getValue($this->blocks,'bodyclass');  ?>">
<?php echo ArrayHelper::getValue($this->blocks,'head_html'); ?>
<?php echo ArrayHelper::getValue($this->blocks,'head_html_ext'); ?>
<?php echo  $this->render('@app/views/layouts/_site_header'); ?>
<!--top_end-->
<!--主体-->
<?php echo $content ?>
<!--主体end-->
<div class="home_foot">
    <div class="home_foot_BG"></div>
<?php echo  $this->render('@app/views/layouts/_site_footer'); ?>
</div>
<?php echo  ArrayHelper::getValue($this->blocks,'foot_html'); ?>
<script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery.blockUI.js"  type="text/javascript"></script>
<script type="text/javascript">
    try {
        $.get("<?php echo url('site/site-header-message') ?>",{},function(data){
            $("#messageNotice").html(data.data.notice);
            $("#messageSys").html(data.data.sysMsg);
            $("#messageMsg").html(data.data.priMsg);
            $("#messageCount").html(data.data.sumCnt);

        });
    }catch(e){

    }


    $(document).ajaxStart($.blockUI).ajaxComplete($.unblockUI);
    function userDefImg(image) {
        image.src = '/pub/images/tx.jpg';
        image.onerror = null;
    }

</script>


<?php $this->endBody() ?>
<script src="<?php echo BH_CDN_RES.'/pub' ?>/js/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script type="text/javascript" charset="utf-8">
    $(function() {
        $("img.lazy").lazyload({
            effect : "fadeIn"
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
    (function() {
        var u="//tongji.banhai.com/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', 1]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="//tongji.banhai.com/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>
<?php $this->endPage() ?>

<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;

/* @var $content string */

?>


<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">

        <link href="<?= BH_CDN_RES.'/static' ?>/css/base.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
        <link href="<?= BH_CDN_RES.'/static' ?>/css/sUI.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
        <link href="<?= BH_CDN_RES.'/static' ?>/css/popBox.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
        <link href="<?= BH_CDN_RES.'/static' ?>/css/jquery-ui.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">

        <script src="<?= BH_CDN_RES.'/static' ?>/js/jquery.js<?= RESOURCES_VER ?>" type="text/javascript"></script>

        <title><?php echo Yii::$app->name . '-' . $this->title; ?></title>

        <?php $this->head() ?>
    </head>

    <body class="<?= ArrayHelper::getValue($this->blocks, 'bodyclass'); ?>">
    <?php $this->beginBody() ?>
    <?php echo $this->render('_site_header'); ?>

    <?= $content ?>

    <!--主体end-->
    <div class="footWrap">
        <div class="foot col1200 pr">
            <?php echo $this->render('@app/views/layouts/_site_footer'); ?>
        </div>
    </div>

    <?php echo ArrayHelper::getValue($this->blocks, 'foot_html'); ?>

    <?php $this->endBody() ?>
    <script src="<?php echo BH_CDN_RES.'/static' ?>/js/lib/lazyload/jquery.lazyload.js?<?= RESOURCES_VER ?>"></script>
    <script type="text/javascript" charset="utf-8">
        $(function () {
            require(['<?php echo BH_CDN_RES.'/static' ?>/js/lib/jquery.blockUI.js'], function () {
                $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
            });

            $("img.lazy").lazyload({
                effect: "fadeIn"
            });
        });




    </script>
    <!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        _paq.push(["setDomains", ["*.guanli.banhai.com"]]);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//tongji.banhai.com/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', 8]);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <noscript><p><img src="//tongji.banhai.com/piwik.php?idsite=8" style="border:0;" alt="" /></p></noscript>
    <!-- End Piwik Code -->

    </body>
    </html>
<?php $this->endPage() ?>
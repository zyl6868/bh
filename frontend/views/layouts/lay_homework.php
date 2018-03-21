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
        <link href="<?= BH_CDN_RES.'/static' ?>/css/sUI.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
        <link href="<?= BH_CDN_RES.'/static' ?>/css/jquery-ui.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
        <link href="<?= BH_CDN_RES.'/static' ?>/css/popBox.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
        <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">

        <script src="<?= BH_CDN_RES.'/static' ?>/js/require.js" type="text/javascript"></script>
        <script src="<?= BH_CDN_RES.'/static' ?>/js/jquery.js<?= RESOURCES_VER ?>" type="text/javascript"></script>

        <title><?php echo Yii::$app->name . '-' . $this->title; ?></title>
        <?php $this->head() ?>
        <style>
            .feedback, .signIn,.QQonlineServ {
                display: none;
            }
            .col800 {
                margin-left: auto;
                margin-right: auto;
                width: 800px;
                clear: both;
            }
        </style>
    </head>
    <?php $this->beginBody() ?>
    <script type="text/javascript">
        require.config({
            urlArgs: "bust=<?php echo RESOURCES_BASE_VER ?>",
            baseUrl: "<?php echo  BH_CDN_RES ?>/static/js",
            waitSeconds: 0,
            paths: {
                "domReady": "domReady",
                "jquery": "jquery",
                "jqueryUI": "lib/jquery-ui.min",
                "jquery_sanhai": "lib/jquery.sanhai",
                "base": "module/base",
                "popBox": "module/popBox",
                "sanhai_tools": "module/sanhai_tools",
                'userCard': "module/userCard",
                'validationEngine': 'lib/jquery.validationEngine.min',
                'validationEngine_zh_CN': 'lib/jquery.validationEngine_zh_CN'
            },

            shim: {
                "validationEngine": {
                    deps: ["jquery"],
                    exports: "validationEngine"
                },

                "validationEngine_zh_CN": {
                    deps: ["jquery"],
                    exports: "validationEngine_zh_CN"
                },
                "jQuery_cycle": ["jquery"]
            }
        });

        require(['domReady', 'base'], function (domReady) {
            domReady(function () {
                require(['<?= ArrayHelper::getValue($this->blocks, 'requireModule');?>']);
            })

        });

        function userDefImg(image) {
            image.src = '/pub/images/tx.jpg';
            image.onerror = null;
        }
    </script>
    <body class="<?= ArrayHelper::getValue($this->blocks, 'bodyclass'); ?>">
    <?php echo ArrayHelper::getValue($this->blocks, 'head_html'); ?>
    <?php echo ArrayHelper::getValue($this->blocks, 'head_html_ext'); ?>
    <!--top_end-->
    <!--主体-->

    <?php echo $content ?>

    <!--主体end-->




    <?php echo ArrayHelper::getValue($this->blocks, 'foot_html'); ?>

    <?php $this->endBody() ?>

    <script src="<?php echo BH_CDN_RES.'/static' ?>/js/lib/lazyload/jquery.lazyload.js?v=1.9.1"></script>
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
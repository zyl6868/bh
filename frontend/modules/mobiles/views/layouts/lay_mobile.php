<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/25
 * Time: 19:53
 */

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1">
    <script src="<?=Yii::getAlias('@mobile_static')  ?>/js/jquery-2.2.1.min.js<?= RESOURCES_VER ?>" type="text/javascript"></script>
    <script src="<?=Yii::getAlias('@mobile_static')  ?>/js/echarts/echarts.js<?= RESOURCES_VER ?>" type="text/javascript"></script>
    <title><?php echo Yii::$app->name.'-'.$this->title; ?></title>
    <style>
        body, p, ul, ol, li, dl, dt, dd, h1, h2, h3, h4, h5, h6, hr, blockquote, object, iframe, fieldset, input, legend, form, th, td {
            margin: 0;
            padding: 0
        }

        body, input, textarea, keygen, select, button, isindex, pre {
            font: Verdana, Tahoma;
            color: #333;
            word-break: break-all
        }

        pre {
            white-space: normal
        }

        ul, ol, li {
            list-style: none
        }

        img {
            border: none
        }

        body {
            font-size: 1.6rem
        }
    </style>
    <script type="text/javascript">
         BASE_URL='<?=Yii::getAlias('@mobile_static') ?>';
    </script>
</head>
<body>
<div>
    <?php echo $content; ?>
</div>
</body>
</html>
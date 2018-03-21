<?php
/**
 * Created by  王
 * User: Administrator
 * Date: 14-9-18
 * Time: 下午2:39
 */
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/main.js" type="text/javascript"></script>
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/base.js" type="text/javascript"></script>
    <script src='<?php echo BH_CDN_RES.'/pub' ?>/js/jquery-ui.min.js' type="text/javascript"></script>
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/base.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/teacher.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/popBox.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/js/ztree/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css">
    <title><?php echo $this->title; ?></title>
    <?php $this->head(); ?>
</head>
<?php $this->beginBody() ?>
<body>
<div class="main cont24  clearfix">
    <?php echo $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

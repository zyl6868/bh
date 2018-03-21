<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/4/7
 * Time: 15:23
 */
/* @var $this yii\web\View */
?>
<?php $this->beginPage() ?>
<!doctype html>
<html id="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">
    <title><?php echo $this->title; ?></title>
    <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/base.css<?=RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/jquery-ui.css<?=RESOURCES_VER ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BH_CDN_RES.'/pub' ?>/css/popBox.css<?=RESOURCES_VER ?>" rel="stylesheet" type="text/css">

    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery-1.7.1.min.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery-ui.min.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/base.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery.validationEngine.min.js" type="text/javascript"></script>
    <script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery.validationEngine-zh_CN.js" type="text/javascript"></script>
    <?php $this->head()  ?>
</head>
<?php $this->beginBody() ?>
<body class="reg register">

<!--header_start-->
<?php echo $this->render('//layouts/n_site_header_regist');?>
<!--header_end-->



<!--content_start-->
<?php echo $content ?>
<!--content_end-->



<!--footer_start-->
<?php echo $this->render('//layouts/n_user_footer');?>
<!--footer_end-->
<script src="<?php echo BH_CDN_RES.'/pub' ?>/js/jquery.blockUI.js"  type="text/javascript"></script>
<script type="text/javascript">
    $(document).ajaxStart($.blockUI).ajaxComplete($.unblockUI);
</script>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>




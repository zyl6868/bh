<?php
/** @var $this BaseController */

?>
<!doctype html>
<html id="html">
<head>
    <meta charset="utf-8">
    <script src="<?php echo publicResources() ?>/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo publicResources() ?>/js/main.js"></script>
    <script src="<?php echo publicResources() ?>/js/base.js"></script>

    <script src="<?php echo publicResources() ?>/js/jquery-ui.min.js"></script>
    <link href="<?php echo publicResources() ?>/css/base.css" rel="stylesheet" type="text/css">
    <link href="<?php echo publicResources() ?>/css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="<?php echo publicResources() ?>/css/popBox.css" rel="stylesheet" type="text/css">
    <title><?php echo $this->getPageTitle(); ?></title>
</head>
<body>
<!--top----------------------->
<?php
echo $this->render('application.views.layouts._user_header');
?>
<!--topEnd------------------------------------------->

<!--main---------------->

<?php echo $content; ?>
<!--mainEnd-->

<!--footer-->
<div>
    <?php
    echo $this->render('application.views.layouts._user_footer');
    ?>
</div>

<!--footEnd-->


</body>
</html>

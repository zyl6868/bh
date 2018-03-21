<?php
/* @var $this \yii\web\View */
/* @var $content string */

?>


<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">

		<link href="<?= BH_CDN_RES ?>/static/css/base.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
		<link href="<?= BH_CDN_RES ?>/static/css/sUI.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
		<link href="<?= BH_CDN_RES ?>/static/css/popBox.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
		<link href="<?= BH_CDN_RES ?>/static/css/jquery-ui.css<?= RESOURCES_VER ?>" rel="stylesheet" type="text/css">
		<script src="<?= BH_CDN_RES ?>/static/js/jquery.js<?= RESOURCES_VER ?>" type="text/javascript"></script>
		<script src="<?= BH_CDN_RES ?>/static/js/jquery-ui.js<?= RESOURCES_VER ?>" type="text/javascript"></script>
		<script type="text/javascript" src="<?= BH_CDN_RES ?>/static/js/require.js<?= RESOURCES_VER ?>"></script>
		<script type="text/javascript" src="<?= BH_CDN_RES ?>/static/js/main.js<?= RESOURCES_VER ?>"></script>
		<title><?php echo Yii::$app->name.'-'.$this->title; ?></title>

	</head>
	<body class="login_body">
	<?php $this->beginBody() ?>

	<?= $content ?>

	<?php $this->endBody() ?>
	</body>
	</html>
<?php $this->endPage() ?>
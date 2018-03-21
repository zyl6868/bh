<?php
use backend\assets\AppAsset1;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset1::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="bg-black" lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="bg-black">
<?php $this->beginBody() ?>
    <?= $content ?>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>

<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-4-21
 * Time: 下午2:25
 */
/* @var $this \yii\web\View */
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::$app->name . '-' . $this->title; ?></title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
    <?php echo $content; ?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
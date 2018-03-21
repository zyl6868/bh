<?php
/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main_v2.php');
$this->blocks['bodyclass'] = "platform";

/*新的*/
$this->registerCssFile(BH_CDN_RES.'/static/css/platform.css'.RESOURCES_VER);
?>

<?= $content ?>

<?php $this->endContent() ?>

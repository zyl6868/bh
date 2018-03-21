<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

if ($hasModel) {
    echo Html::activeFileInput($model, $attribute, $optinos) . "\n";

} else {
    echo Html::fileInput($name, $value, $optinos) . "\n";
}
?>



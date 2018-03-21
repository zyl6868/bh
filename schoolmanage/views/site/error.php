<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/5
 * Time: 18:29
 */
use yii\helpers\Html;

$this->title = 'Error';

//$this->blocks['bodyclass'] = "";
?>
<div class="main">
    <div class="main_error">
        <p><?= nl2br(Html::encode($message)) ?></p>
    </div>
</div>
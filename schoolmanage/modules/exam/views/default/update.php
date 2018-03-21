<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\pos\SeUserinfo */

$this->title = 'Update Se Userinfo: ' . ' ' . $model->userID;
$this->params['breadcrumbs'][] = ['label' => 'Se Userinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->userID, 'url' => ['view', 'id' => $model->userID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="se-userinfo-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

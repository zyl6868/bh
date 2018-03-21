<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\pos\SeUserinfo */

$this->title = 'Create Se Userinfo';
$this->params['breadcrumbs'][] = ['label' => 'Se Userinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="se-userinfo-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

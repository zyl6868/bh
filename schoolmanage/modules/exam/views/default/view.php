<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\pos\SeUserinfo */

$this->title = $model->userID;
$this->params['breadcrumbs'][] = ['label' => 'Se Userinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="se-userinfo-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->userID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->userID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userID',
            'email:email',
            'trueName',
            'parentsName',
            'phone',
            'schoolID',
            'status1',
            'status2',
            'createTime',
            'updateTime',
            'isDelete',
            'type',
            'provience',
            'city',
            'country',
            'introduce',
            'schoolidenName',
            'department',
            'weakAtCourse',
            'manifesto',
            'strongPoint',
            'honours',
            'headImgUrl:url',
            'identityOfTrainingScholl',
            'trainingSchoolID',
            'schooliden',
            'textbookVersion',
            'disabled',
            'resetPasswdToken',
            'resetPasswdTm',
        ],
    ]) ?>

</div>

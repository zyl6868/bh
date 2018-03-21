<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\pos\SeUserinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="se-userinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userID')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'trueName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parentsName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schoolID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updateTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isDelete')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provience')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'introduce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schoolidenName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weakAtCourse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manifesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strongPoint')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'honours')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headImgUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identityOfTrainingScholl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trainingSchoolID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schooliden')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'textbookVersion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'disabled')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resetPasswdToken')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resetPasswdTm')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

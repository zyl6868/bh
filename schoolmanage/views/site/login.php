<?php
/**
 * login.php
 *
 * @copyright Copyright &copy; Pedro Plowman, https://github.com/p2made, 2015
 * @author Pedro Plowman
 * @package p2made/yii2-sb-admin-theme
 * @license MIT
 */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登陆';

$fieldOptions1 = [
	'options' => ['class' => 'text logon_name form-control form-group has-feedback', 'autofocus' => 'autofocus'],
	'inputTemplate' => "{input}<i class='glyphicon glyphicon-envelope form-control-feedback'></i>",
];

$fieldOptions2 = [
	'options' => ['class' => 'text logon_pwd  form-control form-group has-feedback'],
	'inputTemplate' => "{input}<i class='glyphicon glyphicon-lock form-control-feedback'></i>",
];

$this->blocks['requireModule']='app/sch_mag/sch_mag_login';
?>

<div class="sch_mag_login" id="requireModule" rel="app/sch_mag/sch_mag_login">
	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'enableClientValidation' => false
	]); ?>

	<?= $form
			->field($model, 'username', $fieldOptions1)
			->label(false)
			->textInput(['placeholder' => $model->getAttributeLabel('用户名')])
	?>

	<?= $form
			->field($model, 'password', $fieldOptions2)
			->label(false)
			->passwordInput(['placeholder' => $model->getAttributeLabel('密码')])
	?>

	<?= $form->field($model, 'verifyCode',[
			'options' => ['class' => 'login_code']
	])->widget(Captcha::className(),[
		'name'=>'验证码',
			'template' =>'<input type="text" id="loginform-verifycode" class="form-control validate[required,minSize[5],maxSize[5]]" data-validation-engine="validate[required]" data-errormessage-value-missing="验证码不能为空" name="LoginForm[verifyCode]" placeholder="验证码">{image}',
			'imageOptions' => ['alt' => '点击换图','title'=>'点击换图', 'style'=>'cursor:pointer'],
			'captchaAction' => '/site/captcha',
	])->label(''); ?>
	<span class="account">
			<input type="hidden" name="LoginForm[rememberMe]" value="0">
			<input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked=""> 记住账号
		</span>
	<button type="submit" class="btn btn-primary btn-block btn-flat logon_submit_btn" name="login-button">登录</button>

	<?php ActiveForm::end(); ?>

</div>
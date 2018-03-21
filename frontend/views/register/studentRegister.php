<?php

/* @var $this yii\web\View */
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title="学生注册";
$this->blocks['requireModule']='app/site/register';
?>
<div class="gnn_container">
    <div class="content">
        <ul class="register_user clearfix">
            <li class="teacher tch_register">
                <dl class="clearfix">
                    <dt>
                        <span class="role">学生注册</span>
                        <a href="#" id="registerStu" class="stu"></a>
                    </dt>
                </dl>
            </li>
            <li class="">
                <div class="formR">
                    <p class="font12 attention"><span id="showContent" class="hide"></span>
                    </p>
                </div>
                <?php /* @var  $this CActiveForm */
                $form =\yii\widgets\ActiveForm::begin( array(
                    'action' => ['/register/student'],
                    'id' => 'form_id'
                )) ?>
                    <div class="info-item" id="tchphoneItem">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>真实姓名：</span>
                        </label>
                        <input type="text" name="<?php echo Html::getInputName($registerForm, 'trueName') ?>"
                               value="<?php echo isset($_POST['StudentRegisterForm']['trueName']) ? $_POST['StudentRegisterForm']['trueName'] : '' ?>"
                               id="trueName"
                               class="wid user-name" data-prompt-position="topLeft" data-errormessage-value-missing="姓名不能为空！"
                               data-validation-engine="validate[required,custom[notnull],maxSize[20]]"
                               data-prompt-target="nameError">
                        <span id="nameError" class="errorTxt"></span>
                        <?php echo frontend\components\CHtmlExt::validationEngineError($registerForm, 'trueName') ?>
                    </div>
                    <div class="info-item" id="tchSexItem">
                        <label class="right_view">
                            <span>性别：</span>
                        </label>
                        <input type="radio" autocomplete="off" id="tchMale" value=1 name="<?php echo Html::getInputName($registerForm, 'sex') ?>" class="male">男
                        <input type="radio" autocomplete="off" id="tchFemale" value=2 name="<?php echo Html::getInputName($registerForm, 'sex') ?>" class="female">女
                    </div>

                    <div class="info-item">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>手机号：</span>
                        </label>
                        <input type="text" id="phoneNum" name="<?php echo Html::getInputName($registerForm, 'mobile') ?>"
                               value="<?php echo isset($_POST['StudentRegisterForm']['mobile']) ? $_POST['StudentRegisterForm']['mobile'] : '' ?>"
                               data-validation-engine="validate[required,custom[phoneNumber],ajax[checkPhoneNumber]]"
                               class="rand-code wid phone_code" data-prompt-position="topLeft"
                               data-errormessage-value-missing="请输入正确手机号！" data-prompt-target="phoneError">
                        <span id="phoneError" class="errorTxt"></span>
                        <?php echo frontend\components\CHtmlExt::validationEngineError($registerForm, 'mobile') ?>
                    </div>

                    <div class="info-item">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>图片验证码：</span>
                        </label>
                        <input type="text" id="imgverifycode" name="<?php echo Html::getInputName($registerForm, 'imgverifycode') ?>"
                               class="text" data-prompt-position="topLeft"
                               data-validation-engine="validate[required]"
                               data-prompt-target="codeImageError" style="width: 180px">

                        <?php
                        echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'register/captcha','imageOptions'=>['id'=>'captchaimg',
                            'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;margin-left:25px;vertical-align:middle'],'template'=>'{image}']);
                        ?>
                    </div>

                    <div class="info-item">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>手机验证码：</span>
                        </label>
                        <input type="text" placeholder="请输入短信验证码" id="verifycode"
                               name="<?php echo Html::getInputName($registerForm, 'verifycode') ?>"
                               class="rand-code" data-prompt-position="topLeft"
                               data-validation-engine="validate[required]"
                               data-errormessage-value-missing="请输入短信验证码！"
                               data-prompt-target="codeError">
                        <span id="codeError" class="errorTxt" ></span>
                        <div class="get-code" id="tchget-phone-code" data-get="0">发送验证码</div>
                        <?php echo frontend\components\CHtmlExt::validationEngineError($registerForm, 'verifycode') ?>
                    </div>
                    <div class="info-item">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>登录名：</span>
                        </label>
                        <input type="text" name="<?php echo Html::getInputName($registerForm, 'phoneReg') ?>"
                               value="<?php echo isset($_POST['StudentRegisterForm']['phoneReg']) ? $_POST['StudentRegisterForm']['phoneReg'] : '' ?>"
                               id="phoneReg"
                               class="wid" data-prompt-position="topLeft" data-errormessage-value-missing="登录名不能为空！"
                               data-validation-engine="validate[required,custom[notnull],minSize[5],maxSize[20],ajax[checkLoginName]]"
                               data-prompt-target="nameError">
                        <span id="nameError" class="errorTxt"></span>
                        <?php echo frontend\components\CHtmlExt::validationEngineError($registerForm, 'loginName') ?>

                    </div>
                    <div class="info-item">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>设置登录密码：</span>
                        </label>
                        <input id="pwd" name="<?php echo Html::getInputName($registerForm, 'passwd') ?>" type="password"
                               onchange=" if($('#repasswd').val()!=''){$('#repasswd').validationEngine('validate');}"
                               class="wid" data-prompt-position="topLeft" data-errormessage-value-missing="密码不能为空！"
                               data-validation-engine="validate[required,minSize[6],maxSize[20],custom[onlyLetterNumber]]"
                               data-prompt-target="pwd01Error">
                        <span id="pwd01Error" class="errorTxt"></span>
                        <?php echo frontend\components\CHtmlExt::validationEngineError($registerForm, 'passwd') ?>
                    </div>
                    <div class="info-item">
                        <label class="right_view">
                            <i class="red">*</i>
                            <span>确认登录密码：</span>
                        </label>
                        <input id="repasswd"  type="password" name="<?php echo Html::getInputName($registerForm, 'repasswd') ?>"
                               class="wid" data-errormessage-value-missing="确认密码不能为空！"
                               data-validation-engine="validate[required,minSize[6],maxSize[20],equals[pwd]]"
                               data-prompt-position="topLeft"
                               data-prompt-target="pwd02Error">
                        <span id="pwd02Error" class="errorTxt"></span>
                        <?php echo frontend\components\CHtmlExt::validationEngineError($registerForm, 'repasswd') ?>
                    </div>
                    <input type="button" class="pre" id="tchpreBtn" value="上一步">
                    <input type="button" class="next" id="tchnextBtn" value="下一步">
                <?php \yii\widgets\ActiveForm::end(); ?>
            </li>
        </ul>
    </div>
</div>
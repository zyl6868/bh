<?php use yii\helpers\Html;

/* @var $this yii\web\View */  $this->title="首页" ?>
<script>
    $(function () {
        $('#userName').placeholder({value: "用户名"});
        $('#pwd').placeholder({value: "密码"});
        $('#cord').placeholder({value: "验证码"});

    })
</script>
<script type="text/javascript">
    $(function () {
        $('#login').bind('click', function () {
            if ($('#form_id').validationEngine('validate')) {
                $addFrom = $('#form_id');
                $.post("<?php echo url('site/login')?>", $addFrom.serialize(), function (data) {
                    if (data.success) {
                        location.reload();
                    } else {
                        popBox.alertBox(data.message);
                        $('#captcha').click();
                    }
                });
            }
        })

    })
</script>

<!--中间内容开始-->
<div class="cont24 main">
    <div class="home_login">
        <div class="home_loginBg"></div>
        <?php if (!Yii::$app->user->isGuest) {
            ?>
            <div class="home_userInfo">
                <div class="clearfix ">
                    <img src="<?php echo publicResources() . $userInfo->faceIcon; ?>" width="110" height="110" alt=""/>

                    <h2><?php echo $userInfo->trueName; ?></h2>
                </div>
                <?php if (!empty($classList)) { ?>
                    <a href="<?php echo url('class/index', array('classId' => $classList[0]->classID)) ?>"
                       class="a_button btn40 bg_green">进入我的班级 </a>
                <?php } ?>
                <h5>您当前正在使用的账号信息:</h5>

                <p> <?php echo $userInfo->email; ?></p>
            </div>
        <?php } else { ?>

            <div class="home_loginCont">
                <h4>登录到班海</h4>
                <?php $form =\yii\widgets\ActiveForm::begin( array(
                    'action' => 'site/login',
                    'enableClientScript' => false,
                    'id' => 'form_id'
                )) ?>
                <p><input type="text" class="text"
                          id="userName"
                          name="<?php echo Html::getInputName($model, 'userName') ?>"
                          value="<?php echo $model->userName ?>"
                          data-validation-engine="validate[required]" autocomplete="off"
                          data-errormessage-value-missing="用户名不能为空"/>
                </p>

                <p>
                    <input type="password" class="text"
                           id="pwd"
                           name="<?php echo Html::getInputName($model, 'passwd') ?>"
                           data-validation-engine="validate[required,minSize[6],maxSize[20]]"
                           data-errormessage-value-missing="密码不能为空" autocomplete="off"
                           onpaste="return false" oncopy="return false"/>
                </p>

                <p>
                    <input name="ValidateCode" style="width:72px;" id="cord"
                           class="text w80" type="text"/>
                    <?php $this->widget('CCaptcha', array(
                        'showRefreshButton' => true,
                        'clickableImage' => true,
                        'buttonLabel' => '&nbsp;<span>看不清？ <b>换一张</b></span>',
                        'imageOptions' => array('alt' => '点击换图', 'title' => '点击换图', 'style' => 'width:80px; height:30px;', 'class' => 'landing'),
                        'id' => 'captcha'
                    )) ?>
                </p>
                <p>
                    <button type="button" class="bg_green w180 loginBtn" id="login" value="">登   录</button>
                    <a href="<?php echo url('register'); ?>">注册</a> <a
                        href="<?php echo url('site/get-pass'); ?>">忘记密码</a></p>
                <p>
                    <input type="checkbox" class="checkbox" name="<?php echo Html::getInputName($model, 'rememberMe') ?>"
                           value="1">
                    <label>记住我</label>&nbsp;&nbsp;&nbsp;
                </p>        
                <?php \yii\widgets\ActiveForm::end() ?>
            </div>
        <?php } ?>

    </div>

</div>
<!--中间内容结束-->



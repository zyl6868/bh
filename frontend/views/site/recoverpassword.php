<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/4/12
 * Time: 9:41
 */
use yii\captcha\Captcha;

/* @var $this yii\web\View */  $this->title='找回密码';
?>

<script>
    $(function () {

        $('#form1').validationEngine({'maxErrorsPerField': 1});
        $('#form2').validationEngine({'maxErrorsPerField': 1});
        $('#reg_name').placeholder({value: '请输入用户名', ie6Top: 10});
        $('#verify_num').placeholder({value: '请输入手机号', ie6Top: 10});
        $('.sendCode').click(function () {

            var _this = $(this);
            if ($('#reg_name , #verify_num , #verify_code_image').validationEngine('validate')) {

                $('#second_show').text(60);
                _this.attr('disabled',true).addClass('disableBtn');
                //发送验证码
                var phoneReg = $("#verify_num").val();
                var regName = $('#reg_name').val();
                var verifyCodeImage = $('#verify_code_image').val();
                $.post('<?php echo url("site/get-reset-passwd-tolken-phone");?>', {phoneReg: phoneReg,regName:regName,verifyCodeImage:verifyCodeImage}, function (data) {
                    if (data.success) {
                        $('#showContent').text('我们向您的手机' + phoneReg + '发送了一条验证短信');
                        $('.countdown,.attention span').show();
                        countdown(60, '#second_show', function () {
                            $('#showContent').hide();
                            _this.removeClass('disableBtn').removeAttr('disabled').text('重新发送');
                            $('.countdown').hide();
                            $('#verify_code_image').val('');
                            $('#captchaimg').click();
                            $('#codeImageError').text('');
                        });
                    } else {
                        if (data.message != "" && data.code == 1) {
                            _this.removeClass('disableBtn').removeAttr('disabled').text('获取验证码');
                            $('.sendCode').show();
                            $("#verify_num").validationEngine("showPrompt", data.message, "error");
                        } else if(data.message != "" && data.code == 2) {
                            _this.removeClass('disableBtn').removeAttr('disabled').text('获取验证码');
                            $('.sendCode').show();
                            $("#verify_code_image").validationEngine("showPrompt", data.message, "error");
                        } else if(data.message != "" && data.code == 3) {
                            _this.removeClass('disableBtn').removeAttr('disabled').text('获取验证码');
                            $('.sendCode').show();
                            $("#reg_name").validationEngine("showPrompt", data.message, "error");
                        }

                    }
                })

            }

        });


        //findpwd : first step
        $('#pwdStepOne').click(function () {
            $this = $(this);

            if ($('#form1').validationEngine('validate')) {
                $form1 = $('#form1');
                $.post('<?php echo url('site/recover-password');?>', $form1.serialize(), function (data) {
                    if (data.success) {
                        $('#phoneShow').text(data.data.phone);
                        $('#phoneHide').val(data.data.phone);
                        $('#codeHide').val(data.data.code);
                        $('#nameHide').val(data.data.regName);
                        $('#userIdHide').val(data.data.regUserId);
                        $this.parents('[class^=step]').hide().next('[class^=step]').show();
                    } else {
                        $("#verify_code").validationEngine("showPrompt", data.message, "error");
                    }
                });
            }

        });

        //findpwd : second step
        $('#pwdStepTwo').click(function () {
            $this = $(this);

            if ($('#form2').validationEngine('validate')) {
                $form2 = $('#form2');
                $.post('<?php echo url('site/recover-password');?>', $form2.serialize(), function (data) {
                    if (data.success) {
                        $this.parents('[class^=step]').hide().next('[class^=step]').show();
                        var lastPhone = $('#phoneHide').val();
                        $('#lastPhone').text(lastPhone);
                        //5s 倒计时
                        countdown(5,'#autoJump', function(){
                            window.location.href='<?=url("site/login"); ?>';
                        });
                    } else {
                        $("#pwd").validationEngine("showPrompt", data.message, "error");
                    }
                });
            }

        })
    })
</script>


<!--主体部分-->
<div class="cont24">
    <div class="grid_19 push_3" style="height:500px">
        <h1>找回密码</h1>

        <div class="formArea">

            <div class="form_list">
                <div class="step1">
                    <form id="form1">

                        <div class="row">
                            <div class="formL">
                                <label></label>
                            </div>
                            <div class="formR">
                                <p class="font12 attention"><span id="showContent" class="hide"></span>
                                </p>
                            </div>
                        </div>

                        <div class="row" style="margin-top:-20px">
                            <div class="formL">
                                <label>用户名</label>
                            </div>
                            <div class="formR">
                                <input id="reg_name" name="form1[regName]" type="text"
                                       data-validation-engine="validate[required]"
                                       class="text" data-prompt-position="inline"
                                       data-prompt-target="nameError" style="margin-right:5px">
                                <span id="nameError" class="errorTxt"></span>

                            </div>
                        </div>

                        <div class="row" >
                            <div class="formL">
                                <label>手机</label>
                            </div>
                            <div class="formR">
                                <input id="verify_num" name="form1[verifyNum]" type="text"
                                       data-validation-engine="validate[required]"
                                       class="text" data-prompt-position="inline"
                                       data-prompt-target="phoneError" style="margin-right:5px">
                                <span id="phoneError" class="errorTxt"></span>

                            </div>
                        </div>

                        <div class="row">
                            <div class="formL">
                                <label>图片验证码</label>
                            </div>
                            <div class="formR">
                                <input type="text" id="verify_code_image" name="form1[verifyCodeImage]"
                                       class="text" data-prompt-position="inline"
                                       data-validation-engine="validate[required]"
                                       data-prompt-target="codeImageError" style="width: 180px">

                                    <?php
                                    echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'site/captcha','imageOptions'=>['id'=>'captchaimg',
                                        'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;margin-left:25px;vertical-align:middle'],'template'=>'{image}']);
                                    ?>
                                <p style="margin-top:20px">
                                    <button type="button" class="btn36 sendCode" style="border-radius:3px !important; vertical-align:middle; width:92px; background:#ff8000">获取验证码</button>
                                    <span class="gray countdown hide">(<em id="second_show">60</em>) 秒后可重新发送</span>
                                </p>
                                <span id="codeImageError" class="errorTxt" style="left:300px"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="formL">
                                <label>手机验证码</label>
                            </div>
                            <div class="formR">
                                <input type="text" id="verify_code" name="form1[verifyCode]"
                                       class="text" data-prompt-position="inline"
                                       data-validation-engine="validate[required]"
                                       data-prompt-target="codeError">
                                <span id="codeError" class="errorTxt" style="left:300px"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="formL">
                                <label></label>
                            </div>
                            <div class="formR submitBtnBar">
                                <button type="button" id="pwdStepOne" class="btn40 bg_green nextBtn"
                                        style="margin-bottom:10px">确定
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="step2 hide">
                    <form id="form2">

                        <div class="row" style="padding-bottom:0">
                            <div class="formL">
                                <label></label>
                            </div>
                            <div class="formR" style="line-height:40px; font-size:16px"> 请重置密码</div>
                        </div>
                        <div class="row">
                            <div class="formL">
                                <label>手机</label>
                            </div>
                            <div class="formR" style="line-height:40px; font-size:20px" id="phoneShow"></div>
                            <input type="hidden" value="" id="phoneHide" name="form2[phonePwd]">
                            <input type="hidden" value="" id="nameHide" name="form2[regName]">
                            <input type="hidden" value="" id="codeHide" name="form2[code]">
                            <input type="hidden" value="" id="userIdHide" name="form2[regUserId]">
                        </div>
                        <div class="row">
                            <div class="formL">
                                <label>新密码</label>
                            </div>
                            <div class="formR">
                                <input id="pwd" name="form2[pwd]" type="password"
                                       class="text validate[required,minSize[6],maxSize[20]]"
                                       data-prompt-position="inline" data-prompt-target="pwd01Error">
                                <span id="pwd01Error" class="errorTxt"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="formL">
                                <label>确认新密码</label>
                            </div>
                            <div class="formR">
                                <input type="password" name="form2[password]"
                                       class="text validate[required,equals[pwd]]"
                                       data-prompt-position="inline" data-prompt-target="pwd02Error">
                                <span id="pwd02Error" class="errorTxt"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="formL">
                                <label></label>
                            </div>
                            <div class="formR submitBtnBar">
                                <button type="button" id="pwdStepTwo" class="btn40 bg_green nextBtn"
                                        style="margin-bottom:10px">确定
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="step3 hide">
                    <div class="row">
                        <div class="formL">
                            <label></label>
                        </div>
                        <div class="formR">
                            <br><br>

                            <p style="font-size:18px">您已成功找回账号：<em id="lastPhone"></em>的密码！</p>
                            <br>

                            <p class="gray_d">系统将在<em id="autoJump">5</em>秒后自动跳转到登录页面......</p>

                            <p class="gray_d">若未发生跳转，请点击 <a class="green" href="<?= url('site/login'); ?>">我要登录</a></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--主体end-->
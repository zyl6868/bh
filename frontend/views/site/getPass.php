<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-19
 * Time: 上午10:41
 */
/** @var Controller $this */
/* @var $this yii\web\View */  $this->title="找回密码";
?>

<!--中间内容开始-->
<div class="reg_content cont24">
    <div class="reg_c_content reg_password">
        <h3 class="pass">找回密码 <span class="ico"><i class="i_btn"></i></span><span class="ico ico_ip"><i
                    class=""></i></span></h3>

        <div class="passWordBox">
            <ul class="form_list">
                <li>
                    <div class="formL"><label for="name">登陆邮箱：</label></div>
                    <div class="formR">
                        <input id="email" type="text" class="text">
                        <button type="button" id="sendmail" class="btn submitBtn">确定</button>
                    </div>
                </li>
                <li class="padding" id="showmessage">
                </li>
                <li class="padding" id="resend" style="display: none">
                    没有收到验证信？
                    <button type="submit" id='resendmail' class="btn f_btn">发送验证信</button>
                </li>
            </ul>
            <ul class="form_list tab_ul hide">
                <li>
                    <div class="formL"><label><i></i>登陆邮箱：</label></div>
                    <div class="formR">
                        <input type="text" class="text">
                    </div>
                </li>
                <li>
                    <div class="formL"><label><i></i>手机：</label></div>
                    <div class="formR click_f teacher ">
                        <input type="text" class="text">
                        <button type="submit" class="btn t_btn"><i>56</i>秒后可重发</button>
                    </div>
                </li>
                <li>
                    <div class="formL"><label><i></i>验证码：</label></div>
                    <div class="formR click_f ">
                        <input type="text" class="text">

                    </div>
                </li>
                <li>
                    <div class="formL"><label></label></div>
                    <div class="formR sub_box">
                        <button type="submit" class="submitBtn btn btn_left">确&nbsp;&nbsp;定</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--中间内容结束-->

<script type="text/javascript">
    $('#sendmail,#resendmail').click(function () {
        $.post('<?php echo \yii\helpers\Url::to(['Emailfindkey']); ?>', {email: $('#email').val()}, function (json) {
                if (json.success) {
                    $('#resend').show();
                } else {
                    $('#resend').hide();
                }
                $('#showmessage').html(json.message);
            }
        );
    });
</script>


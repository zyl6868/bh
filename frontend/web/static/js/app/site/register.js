define(['jquery',"popBox",'jquery_sanhai','sanhai_tools','validationEngine','validationEngine_zh_CN'],

    function($,popBox,jquery_sanhai,sanhai_tools,validationEngine,validationEngine_zh_CN){

        $('form').validationEngine({
            validateNonVisibleFields:true,
            promptPosition:"centerRight",
            maxErrorsPerField:1,
            showOneMessage:true,
            addSuccessCssClassToField:'ok'
        });

        $(document).bind("mouseup",function(e){var target=$(e.target);if(target.closest(".pop").length==0)$(".pop").hide()});
        $(function(){
            $("#registerGch").click(function () {
                var self = $(this).siblings('div.qr-code');
                self.stop(true,true).animate({bottom:21,right:0}).show();
                return false;
            });
            $("#claseQRCode").click(function () {
                var self = $(this).parent();
                self.stop(true,true).animate({bottom: -310,right: -309}).hide(500);
            });
            $("#weChatIcon").click(function () {
                $("#weChatBigIcon").show();
                return false;
            });

        });

        //$("#phoneNum").blur(function(){
        //    alert($("#phoneNum").validationEngine("validate"));
        //});
        $('#phoneNum').bind('jqv.field.result', function(event, field, isError, promptText){
            if(promptText == undefined){
                $('#tchget-phone-code').addClass('sendCode');
            }else{
                $('#tchget-phone-code').removeClass('sendCode');
            }
        });

        $("#verifycode").blur(function(){

            if($(this).prev().text() == '验证码错误!' || $(this).prev().text() =='请输入短信验证码！'){
                $(this).prev().remove();
            }
            var mobile = $("#phoneNum").val();
            var verifycode = $(this).val();
            if(verifycode){
                $.post('/ajax/check-verifycode',{mobile:mobile,verifycode:verifycode}, function (data) {
                    if (data.success) {
                        $("#verifycode").validationEngine("showPrompt", data.message, "error");
                        return false;
                    }
                })
            }
        });



        /*发送验证码*/
        $(document).on('click','.sendCode',function () {
            var imgverifycode = $('#imgverifycode').val();
            var btn = $('#tchget-phone-code');
            $.post("/register/verify-img-code", {imgverifycode:imgverifycode}, function (data) {
                if(data.success == false){
                    $('#imgverifycode').val('');
                    $("#captchaimg").trigger('click');
                    popBox.errorBox(data.message);
                }else{
                    var _this = $(this);
                    var phoneNum = $("#phoneNum").val();
                    $.post("/register/send-verify-code", {phoneNum: phoneNum}, function (data) {
                        if (data.success) {
                            popBox.successBox(data.message);
                            btn.html("(<em id='second_show'>60</em>)秒后重新发送");
                            btn.css({
                                'border-radius':'3px !important',
                                'vertical-align':'middle',
                                'background-color':'#CBCBCB'
                            });
                           btn.removeClass('sendCode');
                            sanhai_tools.countdown(60, '#second_show', function () {
                                $('#showContent').hide();
                                btn.html("重新发送");
                                btn.css({
                                    'border-radius':'3px !important',
                                    'vertical-align':'middle',
                                    'background-color':'#ff8000'
                                });
                                $('#tchget-phone-code').addClass('sendCode');
                                $('#verifycode').val('');
                            });
                        } else {
                            popBox.errorBox(data.message);
                        }
                    });
                }
            });

        });



        //点击上一步

        $("#tchpreBtn").on('click',function(){
            window.location.href="/register/index";
        });
        //点击下一步
        $("#tchnextBtn").live('click',function(){
             $('#form_id').submit();
        });

        //限制输入框 输入8位字符
        $('#accountName').keyup(function () {
            if($(this).val().length>8){
                $(this).val($(this).val().substring(0, 8));
            }
        });



        //加入班级
        $(".join_class").click (function () {
            var code = $("#accountName").val();
            var verify = /[0-9a-zA-Z]/;

            if (!verify.exec(code)) {
                popBox.errorBox("请输入正确的班级加入码！");
                return false;
            }
            $('#accountName').val($('#accountName').val().substring(0, 8));
            //8位邀请码
            var find_text = $('#accountName').val();
            if (find_text.length != 8) {
                popBox.errorBox('请输入八位加入码！');
                return false;
            }
            $.get("/register/register-join-class", {code: code}, function (result) {
                if (result.success) {
                    popBox.successBox(result.message);
                    setTimeout(function(){
                        window.location.href="/class/"+ result.data.classID +"/index";
                    }, 2000);
                } else {
                    popBox.errorBox(result.message);
                }
            });
        });


});
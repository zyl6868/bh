define(['jquery_sanhai', 'popBox', 'jqueryUI', 'validationEngine', 'validationEngine_zh_CN'], function (jquery_sanhai, popBox, validationEngine, validationEngine_zh_C) {
    /**
     * 去掉前后空格
     * @returns {string}
     */
    String.prototype.trim = function () {
        return this.replace(/(^\s*)|(\s*$)/g, '');
    };
    /**
     * 页头标题选择输入框
     */
    if (!$('#title_txt').val()) {
        $(".write_pen").one('click', function () {
            $('.write_pen').html('<input id="title_txt" class="title_txt" maxlength="30"/>');
            $('#title_txt').focus();
        });
    }
    /**
     * 收件人关联
     * @type {number}
     */
    //第几个班级
    var num = 0;
    //点空白控制开关
    var type = false;
    /**
     * 点击收件人下拉框 更换selected时 触发
     */
    var classId = $('[name=grade_class]:checked').parents('li').attr('id');
    $.get({
        url: "/teacher/message/new-get-class?classId=" + classId,
        success: function (data) {
            $('#' + classId).next().next().next().html(data);
        }
    });
    //全部学生显示按钮
    $('.user_hide').hide();
    $('.user_hide button').hide();
    $('[name=grade_class]:checked').parents('.ul_1').find('.user_hide').css('display', 'list-item');
    $('[name=grade_class]:checked').parents('li').next().find('option:selected').val() == 0 ? $('[name=grade_class]:checked').parents('li').next().next().children().show() : '';
    //$('.choose option:selected').val() == 0 ? $('.choose').parents('li').next().children().show() : '';
    for (var i = 0, len = $('.ul_2').length; i < len; i++) {
        $('.ul_2').eq(i).html().trim() == '' ? '' : $('.ul_2').eq(i).show();
    }
    /**
     * 全部/部分学生状态更改
     */
    $(".choose").live('change', function () {
        //选中部分学生时  选择学生按钮显示
        if ($(this).find('option:selected').val() == 0) {
            $(this).parent().next().children().css('display', 'inline-block');
        } else {//选中全部学生时
            $(this).parent().next().children().css('display', 'none');
            $(this).parents('.ul_1').next().css('display', 'none');
        }
    });

    /**
     * 点击 选择学生 按钮 时选择学生列表显示
     */
    $(".hide button").live('click', function () {
        if ($(this).html() == '选择学生') {
            type = true;
            $(this).html('确定选择');
            $(this).parent().next().children('li.bg_blue_').removeClass('bg_blue_');
            for (var i = 0, len = $(this).parents('.ul_1').next().children('li').length; len > i; i++) {
                for (var j = 0, len_ = $(this).parent().next().children('li').length; len_ > j; j++) {
                    if ($(this).parents('.ul_1').next().children('li').eq(i).html() == $(this).parent().next().children('li').eq(j).html()) {
                        $(this).parent().next().children('li').eq(j).addClass('bg_blue_');
                    }
                }
            }
            num = $('.ul_1').index($(this).parents('.ul_1'));
            $(this).parent().next().css('display', 'block');
            $(this).parents('.ul_1').next().css('display', 'block');
        }
    });

    /**
     * 交互 学生名单
     */
    $(document).on('change', '[name=grade_class]', function () {
        // 选择其他班级时下拉菜单,按钮隐藏
        $('[name=grade_class]').parents('.ul_1').not($(this)).find('.user_hide').css('display', 'none');
        $(this).parents('.ul_1').find('.user_hide').css('display', 'list-item');
        // 选择其他时 学生列表菜单2 隐藏
        $('[name=grade_class]').not($(this)).parents('.ul_1').next().html('').css('display', 'none');
        // ajax 获取班级人员名单
        var classId = $(this).parents('li').attr('id');
        $.get({
            url: "/teacher/message/new-get-class?classId=" + classId,
            success: function (data) {
                $('#' + classId).next().next().next().html(data);
            }
        });
    }).on('click', '.ul_2 li', function () {
        $(this).remove();
        if ($('.ul_2 li').length == 0) {
            $('.ul_2').css('display', 'none');
        }
    });
    /**
     * 点击其他地方隐藏 选择学生列表
     */
    $('body').on('click',function (event) { // 如果是元素本身，则返回
        if (type) {
            event = event || window.event;
            var evt = event.srcElement ? event.srcElement : event.target;
            if (!(evt.getAttribute('class') == 'choose_stu' || evt.parentNode.getAttribute('class') == 'choose_stu')) {
                //点击非列表  隐藏学生列表  数据提交学生列表2
                $(".hide button").html('选择学生');
                var len = $('.ul_1').eq(num).find('.choose_stu li.bg_blue_').length;
                $('.ul_1').eq(num).next().html('');
                if (len != 0) {
                    for (var i = 0; len > i; i++) {
                        $('.ul_1').eq(num).next().append('<li class="bg_blue_" data-userid="' + $('.ul_1').eq(num).find('.choose_stu li.bg_blue_').eq(i).attr('data-userid') + '">' + $('.ul_1').eq(num).find('.choose_stu li.bg_blue_').eq(i).html() + '</li>');
                    }
                } else {
                    $('.ul_1').eq(num).next().css('display', 'none');
                }
                $('.choose_stu').hide();
                type = false;
                return false;
            }
        }
    });
    /**
     * 选择学生点击增添 .bg_blue_ 类
     */
    $(document).on('click', '.choose_stu li', function () {
        $(this).toggleClass('bg_blue_');
    }).on('click', function (e) {//  新建 发送 || 保存
        var mes = msg();
        mes.type = e.target.id;
        if(mes.type != 'save' && mes.type != 'send'){
            return;
        }
        if (!judge(mes)) {
            return false;
        }
        $.post({
            url: '/teacher/message/add-contact',
            dataType: 'json',
            data: {message: mes},
            success: function () {
                if (mes.type == 'save') {
                    window.open("/teacher/message/msg-contact?category=0", '_self');
                } else {
                    window.open("/teacher/message/msg-contact?category=1", '_self');
                }
            }
        })
    }).on('click', function (e) {//更改  发送 || 保存
        var mes = msg();
        mes.type = e.target.id;
        if(mes.type != 'save_' && mes.type != 'send_'){
            return;
        }
        if (!judge(mes)) {
            return false;
        }
        $.post({
            url: '/teacher/message/modify-contact',
            dataType: 'json',
            data: {message: mes},
            success: function () {
                if (mes.type == 'save_') {
                    window.open("/teacher/message/msg-contact?category=0", '_self');
                } else {
                    window.open("/teacher/message/msg-contact?category=1", '_self');
                }
            }
        })
    });
    /**
     * 返回是否为空
     * @param mes 用户信息
     * @returns {boolean}
     */
    function judge(mes) {
        if (mes.title == undefined || mes.title.trim().length == 0) {
            popBox.errorBox('标题全部为空格');
            return false;
        } else if (mes.title == undefined || mes.title.replace(" ", "").length == 0) {
            popBox.errorBox('标题不能为空');
            return false;
        } else if (mes.classId == undefined) {
            popBox.errorBox('请选择班级');
            return false;
        } else if (mes.stuId.length == 0 && mes.stuAll == 0) {
            popBox.errorBox('请选择学生');
            return false;
        } else if (!document.getElementById('stu').checked && !document.getElementById('parents').checked) {
            popBox.errorBox('请选择收件人身份');
            return false;
        } else if (mes.txt.replace(" ", "").length == 0) {
            popBox.errorBox('内容不能为空');
            return false;
        }
        return true;
    }

    $('.memor_nameformError').live('click', function () {
        $(this).hide();
    });
    /**
     * 交互返回表单用户信息
     * @returns {{}}
     */
    function msg() {
        var message = {};
        message.msgid = $('#title_txt').attr('data-msgid');
        message.title = $("#title_txt").val();
        message.classId = $("[name=grade_class]:checked").parents('.border__').attr('id');
        message.stuAll = $("[name=grade_class]:checked").parents('.border__').next().find('option:selected').val();
        message.stuId = [];
        for (var i = 0, len = $("[name=grade_class]:checked").parents('.ul_1').next().children().length; len > i; i++) {
            message.stuId.push(parseInt($("[name=grade_class]:checked").parents('.ul_1').next().children().eq(i).attr('data-userid')));
        }
        message.receiverType = [];
        for (var i = 0, len = $('[name=receiverType]:checked').length; len > i; i++) {
            message.receiverType.push($('[name=receiverType]:checked').eq(i).val());
        }
        message.txt = $("textarea").val();
        message.img = [];
        for (var i = 0, len = $("#img_add img").length; len > i; i++) {
            message.img.push($("#img_add input").eq(i).val());
        }
        return message;
    }


    /**
     * 输入文本字符串数量限制
     */
    $(document).on('blur', '#title_txt', function () {
        if ($(this).val().trim() == '') {
            $(this).parent().next('div').show().children('.formErrorContent').html('此处不可空白');
        } else if ($(this).val().trim() != '' && !($(this).val().length >= 30)) {
            $(this).parent().next('div').hide();
        }
    }).on('blur', 'textarea', function () {
        if ($(this).val().trim() == '') {
            $(this).nextAll('.memor_nameformError').show();
        } else if ($(this).val().trim() != '' && !($(this).val().length >= 1000)) {
            $(this).nextAll('.memor_nameformError').hide();
        }
    }).on('keyup', '#title_txt', function () {
        if (this.value.length >= 30) {
            $(this).parent().next('div').show().children('.formErrorContent').html('最多30个字');
            if (this.value.length > 30) {
                this.value = this.value.slice(0, 30);
            }
        } else {
            $(this).parent().next('div').hide();
        }
    }).on('keyup', 'textarea', function () {
        var $this = $(this);
        if ($this.val().length >= 1000) {
            $this.val($this.val().slice(0, 1000));
        }
        var txt_length = $('textarea').val().length + ($('textarea').val().split(String.fromCharCode(10)).length > 0 ? $('textarea').val().split(String.fromCharCode(10)).length : 1) - 1;
        if (txt_length >= 1000) {
            $(this).val($(this).val().slice(0, 1000 + txt_length));
            $(this).nextAll('.memor_nameformError').show().children('.formErrorContent').html('最多1000个字');
        } else {
            $(this).nextAll('.memor_nameformError').hide();
        }
        $('#max_length_txt').html($('textarea').val().length + '/1000');
    });
    $('#max_length_txt').html($('textarea').val().length + '/1000');

    //修改图片*************************
    $(document).on('click', '.delBtn', function () {
        $(this).parent().remove();
        leftPicCal();
    });
    $('#event_form').validationEngine();
    $('.upImgFile ul').sortable({items: "li:not(.disabled)"});

    //添加和编辑可以继续添加的剩余图片的计算
    function leftPicCal() {
        var liSize = $('.upImgFile').find('li').size();
        $('.uploadFileBtn').find('span').html(7 - liSize);
        if (liSize == 7) {
            $('.uploadFileBtn').hide();
        } else {
            $('.uploadFileBtn').show();
        }
    }

    leftPicCal();
    return {leftPicCal: leftPicCal};
});
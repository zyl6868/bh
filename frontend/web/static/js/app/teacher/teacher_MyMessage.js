define(['jquery', 'jquery_sanhai', 'popBox', 'fancybox'], function ($, jquery_sanhai, popBox, fancybox) {
    $(".fancybox").die().fancybox();
    $(document).on('mouseover', '.poR', function () {//未读红色标记
        $(this).children('.formError').show();
    }).on('mouseout', '.poR', function () {
        $(this).children('.formError').hide();
    }).on('mouseover', '.tab>ul>li', function () {
        /*显示垃圾桶*/
        $(this).children().find('.cut').show();
    }).on('mouseout', '.tab>ul>li', function () {
        /*隐藏垃圾桶*/
        $(this).children().find('.cut').hide();
    }).on('click', 'i.cut', function (event) {
        event.stopPropagation();
    }).on('click', 'span.f_l b', function () {
        if ($(this).attr('data-type') == 'true') {
            /* 显示收取信息学生&家长 */
            $(this).css("background", "url('../../static/images/ico.png') -84px -828px no-repeat");
            $(this).parents('p').next().show();
            $(this).attr('data-type', 'false');
        } else {
            /* 隐藏收取信息学生&家长 */
            $(this).css("background", "url('../../static/images/ico.png') -64px -828px no-repeat");
            $(this).parents('p').next().hide();
            $(this).attr('data-type', 'true');
        }
    }).on('click', '#alert_remove', function () {//remove 弹出框
        $("#alert").hide();
        $("#alert_bg").remove();
        return;
    }).on('click', '.tab>ul>li>h4>span.sendsave', function () {
        var _this = $(this);
        var id = _this.attr('infoid');
        $.get('/teacher/message/msginfo', {id: id}, function (data) {
            if (data) {
                $('#alert_main').html(data);
            }
            alert_n();
        });
    }).on('click', '.tab>ul>li>h4>span.receiver', function () {
        var _this = $(this);
        var id = _this.attr('infoid');
        _this.parent().removeClass('font_bold');
        $.get('/teacher/message/receiver-msginfo', {id: id}, function (data) {
            if (data) {
                $('#alert_main').html(data);
            }
            alert_n();
        });
    }).on('click', '.sendmsg', function () {
        //发送短信
        _this = $(this);
        var id = _this.attr('sendId');
        $.post("send-hom-msg", {id: id}, function (html) {
            if (html.success) {
                popBox.successBox('发送成功！');
                //location.reload();
                window.open("/teacher/message/msg-contact?category=1", '_self');
            } else {
                popBox.errorBox(html.message);
            }
        })
    }).on('click', 'i.remove_cut', function () { //删除短信
        var _this = $(this);
        var target = $(_this.currentTarget);
        $("#caution").css({
            "left": ($(window).width() - $("#caution").width()) / 2,
            "top": $(window).scrollTop() + (($(window).height() - $("#caution").height()) / 2),
            "display": "block"
        });
        $("body").append('<div id="alert_bg" class="alert_bg" style="height:' + $('body').height() + 'px;width:' + $('body').width() + 'px;position:absolute"></div>');
        $(document).off('click', '#caution .okBtn');
        $(document).on('click', '#caution .okBtn', function () {
            var id = _this.attr('delId');
            $.post("del-hom-msg", {id: id}, function (data) {
                if (data.success) {
                    popBox.successBox('删除成功！');
                    _this.parents('li').remove();
                    location.reload();
                } else {
                    popBox.errorBox(data.message);
                }
            });
            $('#caution').hide();
            $('#alert_bg').remove();
        });
    }).on('click', '#caution_header i,#caution .cancelBtn', function () {
        //隐藏弹出框
        $('#caution').hide();
        $('#alert_bg').remove();
    }).on('click', 'i.delmes', function () {
        //删除通知
        var _this = $(this);
        var id = _this.attr('delId');
        $("#caution").css({
            "left": ($(window).width() - $("#caution").width()) / 2,
            "top": $(window).scrollTop() + (($(window).height() - $("#caution").height()) / 2),
            "display": "block"
        });
        $("body").append('<div id="alert_bg" class="alert_bg" style="height:' + $('body').height() + 'px;width:' + $('body').width() + 'px;position:absolute"></div>');
        $(document).off('click', '#caution .okBtn');
        $(document).on('click', '#caution .okBtn', function () {
            $.post("delete-notice", {id: id}, function (data) {
                if (data.success) {
                    popBox.successBox('删除成功！');
                    _this.parents('li').remove();
                    location.reload();
                } else {
                    popBox.errorBox(data.message);
                }
            });
            $('#caution').hide();
            $('#alert_bg').remove();
        });
    });
    function alert_n() {
        $("#alert").css({
            "left": ($(window).width() - $("#alert").width()) / 2,
            "top": $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2),
            "display": "block"
        });
        $("body").append('<div id="alert_bg" class="alert_bg" style="height:' + $('body').height() + 'px;width:' + $('body').width() + 'px;position:absolute"></div>');
    }
    //窗口变化调整弹框
    $(window).resize(function () {
        $("#caution").css({
            "left": ($(window).width() - $("#caution").width()) / 2,
            "top": $(window).scrollTop() + (($(window).height() - $("#caution").height()) / 2)
        });
        $("#alert").css("top", $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2));
        $("#alert").css("left", ($(window).width() - $("#alert").width()) / 2);
        $('#alert_bg') ? $('#alert_bg').css({
            'height': $('body').height() + 'px',
            'width': $('body').width() + 'px'
        }) : '';
    });
    $(window).keydown(function (event) {
        var keyCode = event.keyCode;
        if (keyCode == 27) {
            $('#alert').hide();
            $('#caution').hide();
            $('#alert_bg').remove();
        }
    });
});
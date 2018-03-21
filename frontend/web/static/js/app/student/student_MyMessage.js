define(['jquery_sanhai', 'popBox', 'jqueryUI','fancybox'], function (jquery_sanhai, popBox,fancybox) {
    $(".fancybox").die().fancybox();
    $(document).on('click', '#tab li', function () {
        $("#tab li").removeClass('select');
        $(this).addClass('select');
        $(".tab").css("display", "none");
        $(".tab").eq($("#tab li").index($(this))).css("display", "block");
    });
    //未读红色标记
    $(document).on('mouseover', '.poR', function () {
        $(this).children('.formError').show();
    });
    $(document).on('mouseout', '.poR', function () {
        $(this).children('.formError').hide();
    });

    $(document).on('mouseover', '.tab>ul>li', function () {
        /*显示垃圾桶*/
        $(this).children().find('.cut').show();
    });
    $(document).on('mouseout', '.tab>ul>li', function () {
        /*隐藏垃圾桶*/
        $(this).children().find('.cut').hide();
    });
    $(document).on('click', 'i.cut', function (event) {
        event.stopPropagation();
    });

    function alert_n() {
        $("#alert").css({
            "left": ($(window).width() - $("#alert").width()) / 2,
            "top": $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2),
            "display": "block"
        });
        $("body").append('<div id="alert_bg" class="alert_bg" style="height:' + $('body').height() + 'px;width:' + $('body').width() + 'px;position:absolute"></div>');
    }

    $(document).on('click', '#alert_remove', function () {//remove 弹出框
        $("#alert").hide();
        $("#alert_bg").remove();
        return;
    });

    //学校通知
    $(document).on('click', '.tab>ul>li>h4>span.receiver', function () {
        var _this = $(this);
        var id = _this.attr('infoid');
        _this.parent().removeClass('font_bold');
        $.get('/student/message/receiver-msginfo', {id: id}, function (data) {
            if (data) {
                $('#alert_main').html(data);
            }
            alert_n();
        });
    });

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

    //隐藏弹出框
    $(document).on('click', '#caution_header i,#caution .cancelBtn', function () {
        $('#caution').hide();
        $('#alert_bg').remove();
    });
    $(window).keydown(function (event) {
        var keyCode = event.keyCode;
        if (keyCode == 27) {
            $('#alert').hide();
            $('#caution').hide();
            $('#alert_bg').remove();
        }
    });
    //删除通知
    $(document).on('click', 'i.delmes', function () {
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
            $.get("delete-notice", {messageId: id}, function (data) {
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
});
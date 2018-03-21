define(['jquery', 'popBox', 'jqueryUI', 'validationEngine', 'validationEngine_zh_CN', 'jquery_sanhai'], function ($, popBox, jqueryUI, jquery_sanhai, validationEngine, validationEngine_zh_C) {
    $("#tab li").click(function () {
        $("#tab li").removeClass("select");
        $(this).addClass("select");
        var messageType = $(this).attr('data-messageType');
        $.get("/student/message/sys-msg", {messageType: messageType}, function (data) {
            $('#notice').html(data);
        });
    });
    $(document).on('mouseover', '.tab_1>ul>li', function () {
        /*显示垃圾桶*/
        $(this).children().find('.cut').css("display", "inline-block");
    }).on('mouseout', '.tab_1>ul>li', function () {
        /*隐藏垃圾桶*/
        $(this).children().find('.cut').css("display", "none");
    });
    $("#main_left li").live("click", function () {
        $(this).addClass("select");
    });

    var ele = null;

    $(document).on("click", '.tab_1>ul>li .cut', function () {
        $("#caution").css({
            "left": ($(window).width() - $("#caution").width()) / 2 + 'px',
            "top": $(window).scrollTop() + (($(window).height() - $("#caution").height()) / 2) + 'px',
            "display": "block"
        });
        $("body").append('<div id="alert_bg" class="alert_bg" style="height:' + $('body').height() + 'px;width:' + $('body').width() + 'px;position:absolute"></div>');
        var messageId = $(this).attr('data-messageId');
        ele = $(this);
    });

    $(document).off('click', '#caution .okBtn');
    $(document).on('click', '#caution .okBtn', function () {
        var messageId = ele.attr('data-messageId');
        var elePars = ele.parents('li');
        $.get("/student/message/delete-notice", {messageId: messageId}, function (data) {
            if (data.success) {
                elePars.remove();
                popBox.successBox(data.message);
                window.location.reload();
            } else {
                popBox.errorBox(data.message);
            }
        });
        $('#caution').hide();
        $('#alert_bg').remove();
    });

    //提醒消息、学校通知的切换
    $(document).on("click", '#main_left li', function () {
        $("#main_left li").removeClass('select');
        $(this).addClass("select");

    });

    $(window).resize(function () {
        $("#caution").css({
            "left": ($(window).width() - $("#caution").width()) / 2,
            "top": $(window).scrollTop() + (($(window).height() - $("#caution").height()) / 2)
        });
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
            $('#caution').hide();
            $('#alert_bg').remove();
        }
    });

    //标记为已读
    $(".readed").live("click", function () {
        var self = $(this);
        var messageID = self.attr("data-messageID");
        var messageType = self.attr("data-messageType");
        var objectID = self.attr("data-objectID");
        $.get("/student/message/is-read", {
            messageID: messageID,
            messageType: messageType,
            objectID: objectID
        }, function (data) {
            if (data.success) {
                self.css("display", "none");
                self.parents().siblings("h4").css("font-weight", "100");
            } else {
                popBox.errorBox(data.message);
            }
        })
    });
});
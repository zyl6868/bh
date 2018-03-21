define(['jquery', 'popBox', 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN'],
    function ($, popBox) {
    $("#tabList").delegate("li", "click", function () {
        var self = $(this);
        var ID = self.data("id");
        var grade = $("#grade" + ID).find("a");
        grade.addClass("ac");
        grade.siblings().removeClass("ac");
    });
    $('#uploadPicBtn').click(function () {
        popBox.uploadPic();
    });

    //退出该班弹窗
    $(".q_class").click(function () {
        var classId = $(this).attr("clId");
        $.get("/student/setting/find-class-info", {classId: classId}, function (data) {
            $('#caution').html(data);
            $('#caution').show().css({
                'top': ($(window).height() - $('#caution').height()) / 2 + $('body').scrollTop() + 'px',
                'left': ($('body').width() - $('#caution').width()) / 2 + 'px'
            });
            $('#alert_bg').show().css({
                'height': $('body').height() + 'px',
                'width': $('body').width() + 'px'
            });
        });
    });


    $('#caution .cancelBtn,#caution_header i').live('click',function(){
        $('#caution,#alert_bg,#caution_add_class').hide();
    });
    $(window).resize(function(){
        $('#caution').css({
            'top': ($(window).height() - $('#caution').height()) / 2 + $('body').scrollTop() + 'px',
            'left': ($('body').width() - $('#caution').width()) / 2 + 'px'
        });
        $('#alert_bg').css({
            'height': $('body').height() + 'px',
            'width': $('body').width() + 'px'
        });
    });
    $('#find_text').live('keyup',function(){
        if($(this).val().length>8){
            $(this).val($(this).val().substring(0, 8));
        }
    });
    $(document).live('keydown',function(event){
        if(event.keyCode == 27){
            $('#caution,#alert_bg').hide();
        }
    });

    /**
     * 确认退出该班级
     */
    $('#quit_class').live('click', function () {
        var classId = $(this).attr("clId");
        $.ajax({
            url: '/ajax/del-class',
            type: 'get',
            data: {classId: classId},
            success: function (result) {
                if (result.success) {
                    popBox.successBox(result.message);
                    setTimeout(function () {
                        window.location.href="/register/join-class";
                    }, 2000);
                } else {
                    popBox.errorBox(result.message);
                }
            }
        })
    });
});


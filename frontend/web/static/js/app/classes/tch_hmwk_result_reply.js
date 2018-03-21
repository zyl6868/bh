define(["popBox",'jquery_sanhai','jqueryUI'],function(popBox,jquery_sanhai){
    $('#reply_tab').tab();
    $(".tabItem li").click(function(){
        $(this).addClass("sel_ac").siblings().removeClass("sel_ac");

    });
    (function(){
        $('.stuOperation').live('click', function () {
            var _this = $(this);
            var answerId = _this.attr('modify');
            $.post("/classes/managetask/finish-correct", {homeworkanswerid: answerId}, function (data) {
                if (data.success) {
                    popBox.successBox('批改成功！');
                    setTimeout("location.reload();",2000);
                } else {
                    popBox.errorBox(data.message)
                }
            })
        });
        //查询未批改
        $('.checked-time').live('click',function(){
            var _this = $(this);
            var classId = _this.parents('ul').attr("clId");
            var checkTime = _this.attr('checked-time');
            var classhworkid = _this.parents('ul').attr('classhworkId');
            var type=$(".tabList .ac").attr("type");
            $.get("/class/work-detail",{classId:classId,classhworkid:classhworkid,checkTime:checkTime,type:type},function(result){
                $("#no_already_data").html(result);
            })
        });
        //查询已批改
        $('.marked-checked-time').live('click',function(){
            var _this = $(this);
            var classId = _this.parents('ul').attr("clId");
            var checkTime = _this.attr('checked-time');
            var classhworkid = _this.parents('ul').attr('classhworkId');
            var type=$(".tabList .ac").attr("type");

            $.get("/class/work-detail",{classId:classId,classhworkid:classhworkid,checkTime:checkTime,type:type},function(result){
                $('#already_data').html(result);
            })
        })
    })();

});
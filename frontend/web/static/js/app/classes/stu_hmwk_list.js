define(["popBox",'jquery_sanhai','jqueryUI'],function(popBox){
    $('.classes_file_list .row').openMore(36);

    $("#classes_sel_list .row").sel_list('single');
//班级 教师作业 页面 科目筛选
    $('.subject_list').live('click',function(){
        var _this = $(this);
        var subjectId = _this.attr('subject');

        var state = $(".click_state").find(".sel_ac").attr("state");
        var classId = $("#classes_sel_list").attr('cl');
        var url = '/class/student-homework';
        $.get(url,{ subjectId: subjectId ,classId:classId,state:state},function(data){
            $(".classbox").html(data);
        })
    });
    $('.click_state').live("click",function(){
        var _this = $(this);
        var state = _this.find(".sel_ac").attr("state");
        var subjectId = $(".sub_find").find('.sel_ac').attr('subject');
        var classId = $("#classes_sel_list").attr("cl");
        $.get("/class/student-homework",{classId:classId,state:state,subjectId:subjectId},function(data){
            $(".classbox").html(data);
        })
    })

});






define(['jquery_sanhai','popBox','jqueryUI'],function(jquery_sanhai,popBox){
    $('#problem_r_list').live('click',function(){
        $(this).children('ul').show();
        $(this).children('u').show();
    }).live('mouseover',function(){
        $(this).children('ul').show();
        $(this).children('u').show();
    }).live('mouseout',function(){
        $(this).children('ul').hide();
        $(this).children('u').hide();
    });
    //打开课程列表
    $('#show_sel_classesBar_btn').click(function () {

        $(".sel_classesBar").slideDown();
        return false;
    });
    //选择学科
    $("#sel_classesBar").sel_list('single');
    $("#sel_classesBar dd").click(function () {
        $('#sel_classes h5').text($(this).text());
        $("#sel_classesBar").hide();
    });

    //选中的试卷显示边框和删除标志
    $('#questionTypes .question_types').live("mouseover",function(){
        var self = $(this),
            id = self.data("id");
        $("#delBtnP"+id).addClass('ac');
        $("#delBtnP"+id).find("u.delBtn").show();
    });
    $('#questionTypes .question_types').live("mouseout",function(){
        var self = $(this),
            id = self.data("id");
        $("#delBtnP"+id).removeClass('ac');
        $("#delBtnP"+id).find("u.delBtn").hide();
    });

    $('#delPaper').dialog({
        autoOpen: false,
        width: 350,
        modal: true,
        resizable: false
    });
    //关闭弹窗
    $('.cancelBtn').click(function(){
        $('.popBox').dialog('close');
    });

    //弹出删除试卷弹框
    $('.clearfix .delBtn').click(function(){
        var _this =$(this);
        var paperId  = _this.attr('data-paperId');
        $('#delPaper .okBtn').attr("data-paperId",paperId);
        $('#delPaper').dialog('open');
    });

    //执行删除试卷
    $('#delPaper .okBtn').live('click',function(){
        var _this =$(this);
        var paperId  = _this.attr('data-paperId');
        $.post('/teacher/managepaper/delete-paper',{paperId:paperId},function(data){
            if(data.success){
                location.reload();
            }else{
                popBox.errorBox(data.message);
            }
        })
    });


});
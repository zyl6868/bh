define(['popBox','jquery_sanhai','jqueryUI'],function(popBox,jquery_sanhai){

    //单选
    $("#classes_sel_list").sel_list('single',function(){

    });
    $("#hard_list").sel_list('single',function(){

    });

    //选择课程 年级
    $('#sel_course').sUI_select();
    $('#sel_grade').sUI_select();

    //打开课程列表
    $('#show_sel_classesBar_btn').click(function(){
        $(".sel_classesBar").slideDown();
        return false;
    });

    //选择学科
    $("#sel_classesBar").sel_list('single');
    $("#sel_classesBar dd").click(function(){
        $('#sel_classes h5').text($(this).text());
        $("#sel_classesBar").hide();

    });

    //目录树
    $('.pointTree').tree();


});
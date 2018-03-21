﻿define(['jquery_sanhai'],function(){
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
    //搜索框提示
    $('#mainSearch').placeholder({
        value: "请输入真题试卷名称……",
        left: 15,
        top: 4
    });

    //选择课程
    $(".classes_sel_list").sel_list('single', function () {

    });

    $('.cls_rList .fav').click(function(){

    });
    $('.searchBtn').click(function(){
        $('.form-horizontal').submit();
    });

});



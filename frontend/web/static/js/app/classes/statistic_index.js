define(["popBox", 'jquery_sanhai', 'jqueryUI'], function(popBox) {

      //打开课程列表
    $('#sch_mag_classesBar_btn').click(function(){
        $(".sch_mag_homes").slideDown();
        return false;
    });

    //左侧激活样式
    $(".left_menu li a").click(function(){
        $(".left_menu li a").removeClass("cur");
        $(this).addClass("cur");
    });

    //选择考试
    $(".sel_test_bar .row").sel_list('single');

    $(".exam_click").live('click',function(){

        var examType = $(this).attr('examType');
        //var isSolved = $('.solved_type').find('.sel_ac').attr('isSolved');
        var examYear = $(".year_type").find(".sel_ac").attr("examYear");
        var classId = $('.grade_id').attr("classId");
        //var department = $('.grade_id').attr("department");
        $.get('/classstatistics/default/index',{examYear:examYear,examType:examType,classId:classId},function(data){
            $("#answerPage").html(data);
        })
    });
    //$(".solved_clcik").live('click',function(){
    //    var isSolved = $(this).attr('isSolved');
    //    var examType = $('.exam_type').find('.sel_ac').attr('examType');
    //    var examYear = $(".year_type").find(".sel_ac").attr("examYear");
    //    var gradeId = $(".grade_id").attr("gradeId");
    //    var department = $('.grade_id').attr("department");
    //    $.get('/statistics/default/index',{examYear:examYear,examType:examType,isSolved:isSolved,gradeId:gradeId,schoolLevel:department},function(data){
    //        $("#answerPage").html(data);
    //    })
    //})
    $(".year_click").live('click',function(){
        var examYear = $(this).attr('examYear');

        var examType = $('.exam_type').find('.sel_ac').attr('examType');
        // var isSolved = $('.solved_type').find('.sel_ac').attr('isSolved');
        var classId = $('.grade_id').attr("classId");
        //var department = $('.grade_id').attr("department");
        $.get('/classstatistics/default/index',{examYear:examYear,examType:examType,classId:classId},function(data){
            $("#answerPage").html(data);
        })
    })


});

define(["popBox",'FlexoCalendar','jquery_sanhai', 'jqueryUI'], function(popBox) {

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

    $('#time_tab').tab();
    //打开课程列表
    $('#sch_mag_classesBar_btn').click(function(){
        $(".sch_mag_homes").slideDown();
        return false;
    });

    //日
    //$("#calendar").flexoCalendar({
    //    selectDate: 'each-each-each',
    //    onselect: function (date) {
    //        $(".text2").attr("value", date);
    //    }
    //});

    //周
    $("#calendar-weekly").flexoCalendar({
        type: 'weekly',
        onselect: function (date) {
            $(".text1").attr("value", date);
            var reg = /^(\d+\-\d+\-\d+)\,(\d+\-\d+\-\d+)$/g, textAttr = reg.exec(date);
            $(".text1").attr("start", textAttr[1]);
            $(".text1").attr("end", textAttr[2]);
        }
    });

    //月
    $("#calendar-monthly").flexoCalendar({
        type: 'monthly',
        onselect: function (date) {
            $(".text0").attr("value", date);
        }
    });


    $(".text0").click(function () {
        $("#month").show();
    })
    $(".text1").click(function () {
        $("#week").show();
    })


    $(".search").click(function () {
        $(".shortKnowledge").show(400);
    });

    //按月查询
    $(".search").click(function () {
        $('.testPaper').html('');
        var subjectId = $('#subject_select').find("option:selected").attr('subjectId');
        var joinYear = $('#subject_select').attr('joinYear');
        var schoolLevelId = $('#subject_select').attr('schoolLevelId');
        var month = $('.text0').val();
        $.get('/shortboard/default/index',{subjectId:subjectId,joinYear:joinYear,schoolLevel:schoolLevelId,month:month},function(data){
            $("#shortboard").html(data);
        });
    });


    //按周查询
    $(".search1").click(function () {
        $('.testPaper').html('');
        var subjectId = $('#subject_select1').find("option:selected").attr('subjectId');
        var joinYear = $('#subject_select1').attr('joinYear');
        var schoolLevelId = $('#subject_select1').attr('schoolLevelId');
        var weekstart = $('.text1').attr('start');
        var weekend = $('.text1').attr('end');
        $.get('/shortboard/default/week-short',{subjectId:subjectId,joinYear:joinYear,schoolLevel:schoolLevelId,weekstart:weekstart,weekend:weekend},function(data){
            $("#shortboard").html(data);
        });

    });


})

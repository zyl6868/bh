define(["popBox", 'FlexoCalendar', 'jquery_sanhai', 'jqueryUI'], function (popBox) {

    $('#time_tab').tab();
    //打开课程列表
    $('#sch_mag_classesBar_btn').click(function(){
        $(".sch_mag_homes").slideDown();
        return false;
    });

    //日
    $("#calendar").flexoCalendar({
        selectDate: 'each-each-each',
        onselect: function (date) {
            $(".text2").attr("value", date);
        }
    });

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
    $(".text2").click(function () {
        $("#day").show();
    })





    $(".search").click(function () {
        $(".shortKnowledge").show(400);
    });

    //按月查询
    $(".search").click(function () {
        $('.testPaper').html('');
        var subjectId = $('#subject_select').find("option:selected").attr('subjectId');
        var month = $('.text0').val();
        $.get('/student/classshortboard/index',{subjectId:subjectId,month:month},function(data){
            $("#shortboard").html(data);
        });
    });


    //按周查询
    $(".search1").click(function () {
        $('.testPaper').html('');
        var subjectId = $('#subject_select1').find("option:selected").attr('subjectId');
        var weekstart = $('.text1').attr('start');
        var weekend = $('.text1').attr('end');
        $.get('/student/classshortboard/week-short',{subjectId:subjectId,weekstart:weekstart,weekend:weekend},function(data){
            $("#shortboard").html(data);
        });

    });

    $(".knowledgeNum").live("click", function () {
        var kid = $(this).attr('kid');
        if($('.text0').val()){
            var timezone = $('.text0').val();
            var select = 'month';

        }else if($('.text1').val()){
            var timezone = $('.text1').val();
            var select = 'week';
        }
        $(this).css({"color": "#10ade5"}).parent().siblings().children(".knowledgeNum").css({"color": "black"});
        $(".testPaper").show(400);

        $.get('/student/classshortboard/weakness-questions',{kid:kid,timezone:timezone,select:select},function(data){

            $('.testPaper').html(data);
        })
    });

    //查看解析答案按钮
    $('.show_aswerBtn').live('click',function () {
        var _this = $(this);
        var pa = _this.parents('.quest');
        pa.toggleClass('A_cont_show');
        _this.toggleClass('icoBtn_close');
        if (pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
        else _this.html('查看答案解析 <i></i>');
    });
});



















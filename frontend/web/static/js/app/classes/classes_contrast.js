define(["popBox",'echarts/echarts','echarts/chart/bar','echarts/chart/line','jquery_sanhai','jqueryUI'],function(popBox,ec){
    $("#chartOne").change(function(){
        var examId = $(this).attr('examId');
        var classId = $('.tabItem').attr('classId');
        var subjectId = $('#chartOne').find("option:selected").attr('value');
        var num=1;
        if(subjectId==''){subjectId='';}
        $.get('/classstatistics/default/classes-contrast',{examId:examId,subjectId:subjectId,num:num,classId:classId},function(data){
           eval( $('#chart_01').html(data));
        })
        });
    $("#chartTwo").change(function(){
        var examId = $(this).attr('examId');
        var classId = $('.tabItem').attr('classId');
        var subjectId = $('#chartTwo').find("option:selected").attr('value');
        var num=2;
        if(subjectId==''){subjectId='';}
        $.get('/classstatistics/default/classes-contrast',{examId:examId,subjectId:subjectId,num:num,classId:classId},function(data){
            eval($('#chart_02').html(data));
        })
    });
    $("#chartThree").change(function(){
        var examId = $(this).attr('examId');
        var classId = $('.tabItem').attr('classId');
        var subjectId = $('#chartThree').find("option:selected").attr('value');
        var num=3;
        if(subjectId==''){subjectId='';}
        $.get('/classstatistics/default/classes-contrast',{examId:examId,subjectId:subjectId,num:num,classId:classId},function(data){
            eval($('#chart_05').html(data));
        })
    });


    });
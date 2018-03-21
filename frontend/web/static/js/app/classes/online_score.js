define(["popBox",'echarts/echarts','echarts/chart/bar','echarts/chart/line','jquery_sanhai','jqueryUI'],function(popBox,ec){
    $("#grade_select").change(function(){
        var examId = $(this).attr('data-id');
        var classId = $(this).attr('classId');
        var selClassId = $(this).find('option:selected').attr('data-id');
        $.get('/classstatistics/onlinescore/index',{examId:examId,selClassId:selClassId,classId:classId},function(data){
          $('#statistics').html(data);
        })
    })



})
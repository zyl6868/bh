define(["popBox",'echarts/echarts','echarts/chart/bar','echarts/chart/line','jquery_sanhai','jqueryUI'],function(popBox,ec){
    $("#grade_select").change(function(){
        var examId = $(this).attr('data-id');
        var classId = $(this).find('option:selected').attr('data-id');
        $.get('/statistics/onlinescore/index',{examId:examId,classId:classId},function(data){
          $('#statistics').html(data);
        })
    })



})
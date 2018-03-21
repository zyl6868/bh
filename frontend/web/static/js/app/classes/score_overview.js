define(["popBox",'echarts/echarts','echarts/chart/bar','echarts/chart/line','jquery_sanhai','jqueryUI'],function(popBox,ec){


    $('#subject_select').change(function(){
        var examId = $(this).attr('data-id');
        var classId = $(this).attr('classId');
        var subjectId = $('#subject_select').find("option:selected").attr('data-id');
        //var classId = $('#grade_select').find("option:selected").attr('data-id');
        $.get('/classstatistics/default/overview',{subjectId:subjectId , classId:classId ,examId:examId},function(data){
            $('#overview_info').html(data);
        });
    });


});
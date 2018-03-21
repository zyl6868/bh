define(["popBox", 'jquery_sanhai', 'jqueryUI'], function(popBox) {

    //上传excel表
    $('.popBox').dialog({
        autoOpen:false,
        width:600,
        modal: true,
        resizable:false,
        close:function(){$(this).hide()}
    });



    //添加excel内容到数据库
    $('.excel_add_btn').click(function(){
        var url = $(this).attr('data-url');
        var classId = $(this).attr('data-classid');
        var examId = $(this).attr('data-examid');
        $.post('excel-to-db?classId='+classId+'&examId='+examId,{flag:"save",url:url},function(data){
            if(data.success){
                popBox.successBox('添加成功');
                window.location.href = 'auto-input?classId='+data.data.classId+'&examId='+data.data.examId;
            }else{
                $('#importExcelBox').dialog('close');
                $('#up_error_text').text(data.message);
                $('#importExcelBoxError').dialog('open');
            }
        });
    });

    //录入成绩保存教师关联
    $("#btn_sav").click(function () {
            popBox.successBox("保存成功！");
    });

})

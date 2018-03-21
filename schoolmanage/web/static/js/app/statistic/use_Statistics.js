define(["popBox",'jquery_sanhai','jqueryUI'],function(popBox){
    $('.sUI_tab').tab();

    //学部筛选
    $("#departmentId").change(function () {
        var subjectId = $("#subjectId").val();
        var department = $(this).val();
        $.get("/statistics/activate/index", {department: department, subjectId: subjectId}, function (data) {
            $("#personnel_list").html(data);
        })
    });
    //年级刷选
    $("#subjectId").change(function () {
        var subjectId = $(this).val();
        var department = $("#departmentId").val();
        $.get("/statistics/activate/index", {department: department, subjectId: subjectId}, function (data) {
            $("#personnel_list").html(data);
        })
    });

})
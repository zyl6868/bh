define(['popBox', 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN', 'jqueryUI'], function (popBox) {
    //验证
    $('#exam_form').validationEngine();//选择课程 年级
    $('#sel_course').sUI_select();
    $('#sel_grade').sUI_select();

    $('#sch_mag_classesBar_btn').click(function () {//打开课程列表
        $('.sch_mag_homes').slideDown();
        return false;
    });

    $('#sch_mag_homes').sel_list('single');//选择学科
    $('#sch_mag_homes dd').click(function () {
        $('#sel_classes h5').text($(this).text());
        $('#sch_mag_homes').hide();
    });

    $('.classes_file_list .row').sel_list('single', function (elm) {});//选择课程

    $('.left_menu li a').click(function () {//左侧激活样式
        $('.left_menu li a').removeClass('cur');
        $(this).addClass('cur');
    });
    $('.exam_click').on('click', function () {//选择状态
        var $grade_id = $('.grade_id');
        var examType = $(this).attr('examType');
        var isSolved = $('.solved_type').find('.sel_ac').attr('isSolved');
        var examYear = $('.year_type').find(".sel_ac").attr("examYear");
        var gradeId = $grade_id.attr("gradeId");
        var department = $grade_id.attr("department");
        var joinYear = $grade_id.attr("joinYear");
        $.get('/exam/default/index', {
            examYear: examYear,
            examType: examType,
            isSolved: isSolved,
            gradeId: gradeId,
            schoolLevel: department,
            joinYear: joinYear
        }, function (data) {
            $("#answerPage").html(data);
        })
    });
    $('.solved_clcik').on('click', function () {//选择考试
        var $grade_id = $('.grade_id');
        var isSolved = $(this).attr('isSolved');
        var examType = $('.exam_type').find('.sel_ac').attr('examType');
        var examYear = $('.year_type').find('.sel_ac').attr('examYear');
        var gradeId = $grade_id.attr('gradeId');
        var department = $grade_id.attr('department');
        var joinYear = $grade_id.attr('joinYear');
        $.get('/exam/default/index', {
            examYear: examYear,
            examType: examType,
            isSolved: isSolved,
            gradeId: gradeId,
            schoolLevel: department,
            joinYear: joinYear
        }, function (data) {
            $('#answerPage').html(data);
        })
    });
    $('.year_click').on('click', function () {//选择学年
        var $grade_id = $('.grade_id');
        var examYear = $(this).attr('examYear');
        var examType = $('.exam_type').find('.sel_ac').attr('examType');
        var isSolved = $('.solved_type').find('.sel_ac').attr('isSolved');
        var gradeId = $grade_id.attr('gradeId');
        var department = $grade_id.attr('department');
        var joinYear = $grade_id.attr('joinYear');
        $.get('/exam/default/index', {
            examYear: examYear,
            examType: examType,
            isSolved: isSolved,
            gradeId: gradeId,
            schoolLevel: department,
            joinYear: joinYear
        }, function (data) {
            $('#answerPage').html(data);
        })
    });
    $('.popBox').dialog({//初始化弹框
        autoOpen: false,
        width: 690,
        modal: true,
        resizable: false,
        close: function () {
            $(this).dialog("close")
        }
    });
    $(document).on('click', '#cj_exma', function () {//创建考试按钮弹窗
        var department = $('#testMag_home_sel_list').attr('department');
        $.post('/exam/default/get-exam-box', {
            department: department
        }, function (result) {
            $('#examConBox').html(result).dialog("open");//弹框
        });
    });
});

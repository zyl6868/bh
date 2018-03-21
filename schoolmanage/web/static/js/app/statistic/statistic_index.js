define(["popBox", 'jquery_sanhai', 'jqueryUI'], function (popBox) {

	//打开课程列表
	$('#sch_mag_classesBar_btn').click(function () {
		$(".sch_mag_homes").slideDown();
		return false;
	});

	//左侧激活样式
	$(".left_menu li a").click(function () {
		$(".left_menu li a").removeClass("cur");
		$(this).addClass("cur");
	});

	//选择考试
	$(".sel_test_bar .row").sel_list('single');

	$(".exam_click").on('click', function () {
		var $grade_id = $('.grade_id');
		var examType = $(this).attr('examType');
		var examYear = $(".year_type").find(".sel_ac").attr("examYear");
		var gradeId = $grade_id.attr("gradeId");
		var joinYear = $grade_id.attr("joinYear");
		var department = $grade_id.attr("department");
		$.get('/statistics/default/index', {
			examYear: examYear,
			examType: examType,
			gradeId: gradeId,
			schoolLevel: department,
			joinYear: joinYear
		}, function (data) {
			$("#answerPage").html(data);
		})
	});
	$(".solved_clcik").on('click', function () {
		var $grade_id = $(".grade_id");
		var isSolved = $(this).attr('isSolved');
		var examType = $('.exam_type').find('.sel_ac').attr('examType');
		var examYear = $(".year_type").find(".sel_ac").attr("examYear");
		var gradeId = $grade_id.attr("gradeId");
		var joinYear = $grade_id.attr("joinYear");
		var department = $grade_id.attr("department");
		$.get('/statistics/default/index', {
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
	$(".year_click").on('click', function () {
		var $grade_id = $('.grade_id');
		var examYear = $(this).attr('examYear');
		var examType = $('.exam_type').find('.sel_ac').attr('examType');
		var gradeId = $grade_id.attr("gradeId");
		var department = $grade_id.attr("department");
		var joinYear = $grade_id.attr("joinYear");
		$.get('/statistics/default/index', {
			examYear: examYear,
			examType: examType,
			gradeId: gradeId,
			schoolLevel: department,
			joinYear: joinYear
		}, function (data) {
			$("#answerPage").html(data);
		})
	})
});

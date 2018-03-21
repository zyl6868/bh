define(["popBox", 'FlexoCalendar', 'jquery_sanhai', 'jqueryUI'], function (popBox) {

	//打开课程列表
	$('#sch_mag_classesBar_btn').click(function () {
		$(".sch_mag_homes").slideDown();
		return false;
	});

	//左侧激活样式
	var left_menu_li_aDOM = $(".left_menu li a");
	left_menu_li_aDOM.click(function () {
		left_menu_li_aDOM.removeClass("cur");
		$(this).addClass("cur");
	});

	//周
	$("#calendar-weekly").flexoCalendar({
		type: 'weekly',
		onselect: function (date) {
			var text1DOM = $('.text1');
			text1DOM.attr("value", date);
			var reg = /^(\d+\-\d+\-\d+)\,(\d+\-\d+\-\d+)$/g, textAttr = reg.exec(date);
			text1DOM.attr("start", textAttr[1]);
			text1DOM.attr("end", textAttr[2]);
		}
	});

	$(".text0").click(function () {
		$("#month").show();
	});
	$(".text1").click(function () {
		$("#week").show();
	});
	$(".text2").click(function () {
		$("#day").show();
	});
//按周查询 优秀率
	$(".search1").click(function () {
		$('.testPaper').html('');
		var text1DOM = $('.text1');
		var weekStart = text1DOM.attr('start');
		var weekEnd = text1DOM.attr('end');
		$.get('/student/homeworkstatistics/homework-excellent-rate', {
			weekStart: weekStart,
			weekEnd: weekEnd
		}, function (data) {
			$("#statistics").html(data);
		});
	});
//按周查询 未完成
	$(".search2").click(function () {
		$('.testPaper').html('');
		var text1DOM = $('.text1');
		var weekStart = text1DOM.attr('start');
		var weekEnd = text1DOM.attr('end');
		$.get('/student/homeworkstatistics/homework-unfinished', {
			weekStart: weekStart,
			weekEnd: weekEnd
		}, function (data) {
			$("#statistics").html(data);
		});
	});
	//选择考试
	$(".sel_test_bar .row").sel_list('single');


	$("#select_year,#select_month li").on('click', function () {

		var url = $("#select_year").attr('data-url');
		var data_year = $('#select_year .sel_ac').attr('data-value');
		var data_month = $('#select_month .sel_ac').attr('data-value');

		$.post(url, {year: data_year, month: data_month}, function (data) {

			$("#statistics").html(data);

		});

	});


})

define(['jquery', 'popBox', 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN'],
	function ($, popBox) {

		$("#tabList").delegate("li", "click", function () {
			var self = $(this);
			var ID = self.data("id");
			var grade = $("#grade" + ID).find("a");
			grade.addClass("ac");
			grade.siblings().removeClass("ac");
		});
		$('#uploadPicBtn').click(function () {
			popBox.uploadPic();
		});

		$('#caution .cancelBtn,#caution_header i,#add_class_header i').live('click', function () {
			$('#caution,#alert_bg,#caution_add_class').hide();
		});
		//添加任教班级 8位邀请码
		$('#add_class').click(function () {

			$.get("/teacher/setting/find-class-view", {}, function (result) {
				$("#add_class_main").html(result);
				$('#caution_add_class').show().css({
					'top': ($(window).height() - $('#caution_add_class').height()) / 2 + $('body').scrollTop() + 'px',
					'left': ($('body').width() - $('#caution_add_class').width()) / 2 + 'px'
				});
			});
			$('#alert_bg').show().css({
				'height': $('body').height() + 'px',
				'width': $('body').width() + 'px'
			});
		});
		$(window).resize(function () {
			$('#caution_add_class').css({
				'top': ($(window).height() - $('#caution_add_class').height()) / 2 + $('body').scrollTop() + 'px',
				'left': ($('body').width() - $('#caution_add_class').width()) / 2 + 'px'
			});
			$('#caution').css({
				'top': ($(window).height() - $('#caution').height()) / 2 + $('body').scrollTop() + 'px',
				'left': ($('body').width() - $('#caution').width()) / 2 + 'px'
			});
			$('#alert_bg').css({
				'height': $('body').height() + 'px',
				'width': $('body').width() + 'px'
			});
		});
		$('#find_text').live('keyup', function () {
			if($(this).val().length>8){
				$(this).val($(this).val().substring(0, 8));
			}
		});
		$(document).live('keydown', function (event) {
			if (event.keyCode == 27) {
				$('#caution,#alert_bg,#caution_add_class').hide();
			}
		});
		/**
		 * 确认增添任教班级
		 */
		$('#find_class').live('click', function () {
			var code = $("#find_text").val();
			var verify = /[0-9a-zA-Z]/;

			if (!verify.exec(code)) {
				popBox.errorBox("请正确输入邀请码！");
				return false;
			}

			$('#find_text').val($('#find_text').val().substring(0, 8));
			//8位邀请码
			if (code.length != 8) {
				popBox.errorBox('请输入八位邀请码！');
				return;
			}

			$('#wait').html('正在检测班级 ……').removeClass('red').show();
			$('#class_content').removeClass('red');
			$.ajax({
				url: '/teacher/setting/invite-code',
				type: 'get',
				data: {code: code},
				success: function (data) {
					//等待隐藏
					$('#wait').hide();
					if (data.success == true) {
						$('#class_content').show();
						$('#class_content h4').html(data.data.className);//班级名称
						$('#class_content p').eq(0).children('span').html(data.data.schoolName);//学校
						if ([data.data.teacherName] != "") {
							$('#class_content p').eq(1).children('span').html(data.data.teacherName);//班主任名字
						} else {
							$('#class_content p').eq(1).children('span').addClass('red').html('未设置');//班主任名字
						}
					} else {
						$('#class_content').show();
						$('#class_content').html(data.message).addClass('red').show();
						return;
					}
				}
			});

		});
		//加入班级
		$(".join_class").live('click', function () {
			var code = $("#find_text").val();
			$.get("/ajax/join-class", {code: code}, function (data) {
				if (data.success) {
					popBox.successBox(data.message);
					setTimeout(function () {
						location.reload();
					}, 2000);
				} else {
					popBox.errorBox(data.message);
				}
			});
		});

		//退出该班弹窗
		$(".q_class").click(function () {
			var classId = $(this).parent(".clId").attr("clId");
			$.get("/teacher/setting/find-class-info", {classId: classId}, function (data) {
				$('#caution').html(data);
				$('#caution').show().css({
					'top': ($(window).height() - $('#caution').height()) / 2 + $('body').scrollTop() + 'px',
					'left': ($('body').width() - $('#caution').width()) / 2 + 'px'
				});
				$('#alert_bg').show().css({
					'height': $('body').height() + 'px',
					'width': $('body').width() + 'px'
				});
			});
		});

		/**
		 * 确认退出该班级
		 */
		$('#quit_class').live('click', function () {
			var classId = $(this).attr("clId");
			$.ajax({
				url: '/ajax/del-class',
				type: 'get',
				data: {classId: classId},
				success: function (result) {
					if (result.success) {
						popBox.successBox(result.message);
						setTimeout(function () {
							if(result.checkClass){
								location.reload();
							}else {
								window.location.href = "/register/join-class";
							}

						}, 2000);
					} else {
						popBox.errorBox(result.message);
					}
				}
			})
		});
	});

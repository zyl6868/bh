define(["popBox", 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN', 'jqueryUI'], function (popBox, jquery_sanha, validationEngine, validationEngine_zh_CN) {
	//搜索框提示
	$('#mainSearch').placeholder({
		value: "请输入资料名称关键字……",
		left: 15,
		top: 4
	});

	//单选
	$("#classes_sel_list").sel_list('single', function () {
	});
	$("#hard_list").sel_list('single', function () {
	});


	//打开课程列表
	$('#show_sel_classesBar_btn').click(function () {

		$(".sel_classesBar").slideDown();
		return false;
	});
	//选择学科
	$("#sel_classesBar").sel_list('single');
	$("#sel_classesBar dd").click(function () {
		$('#sel_classes h5').text($(this).text());
		$("#sel_classesBar").hide();
	});


	//添加作业内容
	$('#popBox').dialog({
		autoOpen: false,
		width: 500,
		modal: true,
		resizable: false,
		close: function () {
			$(this).dialog("close")
		}
	});

	$('#popBox1').dialog({
		autoOpen: false,
		width: 720,
		modal: true,
		resizable: false,
		close: function () {
			$(this).dialog("close")
		}
	});

	//我的创建 纸质作业 或 电子作业 筛选
	$('.check_work').click(function () {
		var department = $("#classes_sel_list").attr("de");
		var subjectId = $("#classes_sel_list").attr("sub");
		var type = $(this).attr('type');
		$.get('/teacher/resources/my-create-work-manage', {
			type: type,
			department: department,
			subjectId: subjectId
		}, function (data) {
			$('#work_list_page').html(data);
		})
	});
	//布置作业弹窗
	$('.notice').live('click', function () {
		var _this = $(this);
		var homeworkId = _this.attr('data-id');
		var name = _this.attr('data-content');
		var getType = _this.attr('data-type');

		if (getType == '') {

			$("#popBox").dialog("open");
			$('#name').text(name);
			$('#upUrl').attr('href', "/teacher/managetask/new-update-work" + "?homeworkid=" + homeworkId);
			$('#orgUrl').attr('href', "/teacher/managetask/new-preview-organize-paper" + "?homeworkid=" + homeworkId);
		} else {
			$.post('/teacher/resources/get-class-box', {homeworkid: homeworkId}, function (data) {
				$('#getClassBox').html(data);
				$("#popBox1").dialog("open");
			});
		}
	});
	//删除布置的作业
	$(".is_delete").live('click', function () {
		var _this = $(this);
		var relId = _this.attr('rel');
		var hmwid = _this.attr('hmwid');
		popBox.confirmBox('确认要删除该班的作业吗？', function () {
			$.post('/teacher/resources/delete-rel', {relId: relId}, function (data) {
				if (data.success) {
					popBox.successBox(data.message);
					//删除成功后刷新单条
					$.get("/teacher/resources/one-work-content", {hmwid: hmwid}, function (result) {
						$("#one-work-content" + hmwid).html(result);
					});
				} else {
					popBox.errorBox(data.message);
				}
			})
		})
	});
	//催作业
	$('.urge').live('click', function () {
		var $this = $(this);
		var relId = $(this).parents('li').attr('relId');
		$.post('/ajax/urge-homework', {relId: relId}, function (result) {
			if (result.success) {
				popBox.successBox('已成功给学生发送信息');
				$this.addClass('btn_disable').removeClass('urge');
				$this.unbind('click');
			} else {
				popBox.errorBox(result.message);
			}
		})
	});

	$('#cancelHomework').live('click', function () {
		$("#popBox1").dialog("close");
	});

	$(".myclass_table dt span").live('click', function () {
		var checkbox = $(this).siblings("input");
		if (checkbox.is(":checked")) {
			checkbox.prop("checked", false);
		} else {
			checkbox.prop("checked", true);
		}
		pitchOn(checkbox);
	});

	$(".myclass_table dt input").live('click', function () {
		var checkbox = $(this);
		pitchOn(checkbox);
	});

	function pitchOn(checkbox) {
		var dt = checkbox.parent('dt');
		if (checkbox.is(":checked")) {
			var classId = dt.attr('data-id');
			dt.siblings("input").val(classId);
		} else {
			dt.siblings("input").val('');
		}
	}

	//是否共享到平台
	$('#isShare').attr('checked', 'checked');
	$('#isShare').live('click', function () {
		_this = $(this);
		var isShare = _this.val();
		if (isShare == 1) {
			_this.attr('checked', false);
			_this.val('0');
		} else if (isShare == 0) {
			_this.attr('checked', 'checked');
			_this.val('1');
		}
	});

	//是否需要签字

    $('#isSignature').live('click', function () {
        _this = $(this);
        var isSignature = _this.val();
        if (isSignature == 1) {
            _this.attr('checked', false);
            _this.val('0');
        } else if (isSignature == 0) {
            _this.attr('checked', 'checked');
            _this.val('1');
        }
    });


	$("#saveHomework").live('click', function () {
		var checkbox = $(".unmyclass_table dt input");
		var checkedbox = $(".unmyclass_table dt input:checked");
		var hmwid = $(this).attr("hmwid");

		if ($(".unmyclass_table dt input[type='checkbox']").size() == 0) {
			popBox.errorBox('已经布置过作业！');
		} else if (!checkbox.is(":checked")) {
			popBox.errorBox('请选择班级！');
		} else {
			var code = true;
			checkedbox.parent('dt').siblings('dd').each(function () {
				var _this = $(this);
				var deadlineTime = _this.children('input').val();
				if (deadlineTime == '') {
					code = false;
					popBox.errorBox('请给选择的班级填写时间！');
				}
			});
			if (code) {
				$form_id = $('#form_id');
				$.post($form_id.attr('action'), $form_id.serialize(), function (data) {
                    $("#saveHomework").attr('disabled','disabled');
					if (data.success) {
						popBox.successBox(data.message);

						$.get("/teacher/resources/one-work-content", {hmwid: hmwid}, function (result) {
							$("#one-work-content" + hmwid).html(result);
						});

						$("#popBox1").dialog("close");

					} else {

						popBox.alertBox(data.message);

					}

				});
			} else {
				return false;
			}
		}
	});
})
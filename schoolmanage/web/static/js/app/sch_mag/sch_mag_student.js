define(["popBox", 'jquery_sanhai', 'jqueryUI', 'validationEngine', 'validationEngine_zh_CN'], function (popBox) {
	$('#edit_user_info_form').validationEngine();
	$('#mainSearch').placeholder({
		value: "请输入手机号或者用户名搜索……",
		left: 15,
		top: 4
	})

	//初始化弹框
	$('.popBox').dialog({
		autoOpen: false,
		width: 640,
		modal: true,
		resizable: false,
		close: function () {
			$(this).dialog("close")
		}
	});
//学部筛选
	$("#departmentId").change(function () {
		var classId = $("#classId").val();
		var gradeId = $("#gradeId").val();
		var department = $(this).val();
		$.get("/personnel/student/index", {
			department: department,
			gradeId: gradeId,
			classId: classId
		}, function (data) {
			$("#personnel_list").html(data);
			other_opr ();
		})
	});
	//年级刷选
	$("#gradeId").change(function () {
		var classId = $("#classId").val();
		var gradeId = $(this).val();
		var department = $("#departmentId").val();
		$.get("/personnel/student/index", {
			department: department,
			gradeId: gradeId,
			classId: classId
		}, function (data) {
			$("#personnel_list").html(data);
			other_opr ();
		})
	});
	//班级筛选
	$("#classId").change(function () {
		var classId = $(this).val();
		var gradeId = $("#gradeId").val();
		var department = $("#departmentId").val();
		$.get("/personnel/student/index", {
			department: department,
			gradeId: gradeId,
			classId: classId
		}, function (data) {

			$("#personnel_list").html(data);
			other_opr ();

		})
	});

	//有班级学生关键字搜索
	$("#search_word").click(function () {
		var classId = $("#classId").val();
		var gradeId = $("#gradeId").val();
		var department = $("#departmentId").val();
		var searchWord = $("#mainSearch").val();
		$.get("/personnel/student/index", {
			searchWord: searchWord,
			department: department,
			gradeId: gradeId,
			classId: classId}, function (data) {
			$("#personnel_list").html(data);
			other_opr ();
		})
	});

	//无班级学生关键字搜索
	$("#no_class_search_word").click(function () {
		var searchWord = $("#mainSearch").val();
		$.get("/personnel/student/no-class-students", {searchWord: searchWord}, function (data) {
			$("#personnel_list").html(data);
		})
	});

	var userId;
	//修改密码
	$(document).on("click", ".res_passwd", function () {
		userId = $(this).attr("uId");
		popBox.confirmBox('确认重置该生密码？', function () {
			$.get("/personnel/student/update-password", {userId: userId}, function (data) {
				if (data.success) {
					popBox.successBox(data.message);
					$("#reset_passwordBox").dialog("close");
				} else {
					popBox.errorBox(data.message);
				}
			})
		})
	});

	//查看详情
	$(document).on("click", ".viewInfo", function () {
		userId = $(this).parents(".fathers_td").attr("uid");
		$.get("/personnel/student/view-user-info", {userId: userId}, function (data) {
			$("#infoBox").html(data);
			$('#infoBox').dialog("open");
		})
	});

	//编辑详情
	$(document).on("click", ".editInfo", function () {
		userId = $(this).parents(".fathers_td").attr("uid");
		$.get("/personnel/student/update-stu-info-view", {userId: userId}, function (data) {
			$("#editInfoBox").html(data);
			$('#editInfoBox').dialog("open");
		})
	});

	//修改用户信息
	$(document).on("click", ".edit_info_btn", function () {
		if ($('#edit_user_info_form').validationEngine('validate')) {
			var _this = $(this);
			var userId = _this.attr("uId");
			var parentsId = _this.attr("pId");

			var stuNumber = $("#stu_number").val();

			var stuName = $("#stu_name").val();
			var stuSex = $("input[name='sex']:checked").val();
			var parentsName = $(".parents_name").val();

			var patn = /^([0-9a-zA-Z]+)$/;
			var pattern = /[\u4E00-\u9FA5\uF900-\uFA2D]/;

			if(pattern.test(stuName) == false){
				popBox.errorBox("请正确输入名称！");
				return false;
			}

			if (patn.test(stuNumber) == false) {
				popBox.errorBox("只能为数字或者字母和数字组合！");
				return false;
			}

			if (stuName.length == "") {
				popBox.errorBox("用户名不能为空！");
				return false;
			}
			if (stuName.length < 2) {
				popBox.errorBox("用户名至少2个字符！");
				return false;
			}

			$.post("/personnel/student/update-user-info", {
				userId: userId,
				parentsId: parentsId,
				stuNumber: stuNumber,
				stuName: stuName,
				stuSex: stuSex,
				parentsName: parentsName
			}, function (data) {
				if (data.success) {
					popBox.successBox(data.message);
					$.get("/personnel/student/student-one-detail",{userId:userId},function(result){
						$(".u"+userId).html(result);
						other_opr ();
					});
					$("#editInfoBox").dialog("close");
				} else {
					popBox.errorBox(data.message);
				}
			})
		}
	});


	var alert_ob = {};//弹出框对象
	alert_ob.alert_type = true;//控制弹出框
	//弹出框 学生移除本校
	alert_ob.alert_txt_1 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">移除学校<div id="alert_remove" class="alert_remove"></div></div>' +
		'<h4 style="color:#F87472;font-weight:bold;"><span id="outName"></span>&nbsp;是否离开学校？</h4>' +
		'<p style="text-align:center">离校后,该学生将与本校解除绑定关系,将不能在本校平台中进行任何学习操作！</p>' +
		'<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2" data-out="leave_out">离校</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';




	//班级调动
	alert_ob.alert_txt_2 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">班级调动<div id="alert_remove" class="alert_remove"></div></div>' +
		'<h4 class="detail"><ul id="user_mes" class="user_mes"><li>--</li><li>--</li><li>--</li><li >--</li></ul></h4>' +
		'<p style="text-align:center"><span>将学生调班至：</span><select data-department="on">' +
		'</select>'+
		'<select data-grade="on">' +
		'</select>'+
		'<select data-class="on">' +
		'</select></p>' +
		'<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2" data-btn="classModify">调班</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
	alert_ob.alert_n = function (txt) {
		alert_ob.alert_type = false;
		$("body").append(txt);
		$("#alert").css("top", $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2));
		$("#alert").css("left", ($(window).width() - $("#alert").width()) / 2);
		$("#alert_bg").css({"height": $(document).height()});
		return;
	};

	//点击叉号图标关闭弹框
	$("#alert_remove").live("click", function () {//remove 弹出框
		alert_ob.alert_type = true;
		$("#alert").remove();
		$("#alert_bg").remove();
		return;
	});

	//点击取消弹框关闭
	$("#btn_3").live("click", function () {//remove 弹出框
		alert_ob.alert_type = true;
		$("#alert").remove();
		$("#alert_bg").remove();
		return;
	});

	//离校弹窗
	$(".live-sch").live('click',function(){
		if (alert_ob.alert_type) {
			alert_ob.alert_n(alert_ob.alert_txt_1);
			var trueName = $(this).attr("data-trueName");
			var userId = $(this).attr("data-userId");
			$("#outName").html(trueName);
			$("#btn_2").attr("data-userId",userId);
		}
	});

	//学生调班弹窗
	$(".class-mob").live('click',function(){
		add_grade='';//清空当前选中年部
		if (alert_ob.alert_type) {
			alert_ob.alert_n(alert_ob.alert_txt_2);
			userId = $(this).attr("data-userId");
			$.post("/personnel/student/student-info", {userID: userId}, function(data){
				if(data.success){
					var _data=data.data;
					a(_data.departmentList,_data.department,_data.gradeList,_data.classList,_data.trueName,_data.gradeID,_data.className);
				}else{
					popBox.errorBox(data.message);
				}
			});
		}
	});
	//学部下拉列表
	var add_department="";
	var add_department_txt='';
	$("[data-department=on]").live('change',function(){
			if(add_department!=$("[data-department=on] option:selected").val()) {
				var department = $("[data-department=on] option:selected").val();
				add_department_txt = $("[data-department=on] option:selected").html();
				if(!department){popBox.errorBox("请选择学段");return;}
				$.post("/personnel/student/get-grade", {department: department}, function(data){
					add_grade=data.data.firstGradeId;
					if(data.success){
						b(data.data.gradeList);
						c(data.data.classList);
					}else{
						popBox.errorBox(data.message);
					}
				});
			}
		add_department=$("[data-department=on] option:selected").val();
	});
	//年级下拉列表
	var add_grade="";
	$("[data-grade=on]").live("change",function(){
		if(add_grade!=$("[data-grade=on] option:selected").val()) {
			var gradeId = $("[data-grade=on] option:selected").val();
			if(!add_department){popBox.errorBox("请选择学段");return;}
			if(!gradeId){popBox.errorBox("请选择年级");return;}
			$.post("/personnel/student/get-classes", {department: add_department, gradeId:gradeId}, function(data){
				if(data.success){
					c(data.data);
				}else {
					popBox.errorBox(data.message);
					c();
				}
			});
		}
		add_grade=$("[data-grade=on] option:selected").val();
	});
	//班级下拉列表
	var add_class="";
	$("[data-class=on]").live("change",function(){
		add_class=$("[data-class=on] option:selected").val();
	});
	function a(data,department,grade,class_,trueName,gradeID,className){
		$("#user_mes li").eq(0).html(trueName)[0].overfloat();
		if(department){
			$("#user_mes li").eq(1).html(department);
		}else{
			$("#user_mes li").eq(1).html('--');
		}

		//年部下拉
		alert_ob.alert_txt_2_1='';
		$.each(data,function($val,$class){
			if($class==department){
				alert_ob.alert_txt_2_1+='<option value="'+$val+'" selected>'+$class+'</option>';
			}else{
				alert_ob.alert_txt_2_1+='<option value="'+$val+'">'+$class+'</option>';
			}
		});
		$("[data-department=on]").html(alert_ob.alert_txt_2_1);
		add_department=$("[data-department=on] option:selected").val();
		add_department_txt=$("[data-department=on] option:selected").html();
		//年级下拉
		b(grade,gradeID);
		//班级下拉
		c(class_,className);
	}
	//年级下拉
	function b(grade,gradeID){
		alert_ob.alert_txt_2_1='';
		var gradeID_value='';
		if(gradeID){
			$.each(gradeID,function(gradeID_val,gradeID_txt){
				add_grade=gradeID_val;
				gradeID_value=gradeID_val;
				if(gradeID_val){
					$("#user_mes li").eq(2).html(gradeID_txt);
				}else{
					$("#user_mes li").eq(2).html('--');
				}

			});
		}
		$.each(grade,function($val,$class){
			if(!add_grade){
				add_grade=$val;
			}
			if(gradeID_value==$val) {
				alert_ob.alert_txt_2_1 += '<option value="' + $val + '" selected>' + $class + '</option>';
			}else{
				alert_ob.alert_txt_2_1 += '<option value="' + $val + '">' + $class + '</option>';
			}
		});
		$("[data-grade=on]").html(alert_ob.alert_txt_2_1);
	}
	//字符串长度过长处理
	Element.prototype.overfloat=function(){
		var txt=this.innerHTML;
		if(txt.length>4){
			var txtNode='<span id="over_float" style="display:none">'+txt+'</span>';
			$(this).mouseover(function(){
				$("body").append(txtNode);
			});
			$(this).mousemove(function(event){
				event=event||window.event;
				$("#over_float").css({"position":"absolute","left":event.pageX,"top":event.pageY,"display":"inline","z-index":"1000","border":"1px solid #ccc"});
			});
			$(this).mouseout(function(){
				$("#over_float").remove();
			});
			return this.innerHTML=txt.substring(0,3)+"...";
		}
		return;
	};

	//班级下拉
	function c(class_,className){
		alert_ob.alert_txt_2_1='';
		var className_value='';
		if(className){
			$.each(className,function(className_val,className_txt){
				add_class=className_val;
				className_value=className_val;
				$("#user_mes li").eq(3).html($(".u"+userId+" td").eq(5).html());
				$("#user_mes li").eq(3).attr("disabled","disabled");
				$("#user_mes li")[0].overfloat();
			});
		}
		$.each(class_,function($val,$class){
			stu_year=$class;
			if(className_value==$val) {
				alert_ob.alert_txt_2_1 += '<option value="' + $val + '" selected>' + $class + '</option>';
			}else{
				alert_ob.alert_txt_2_1 += '<option value="' + $val + '">' + $class + '</option>';
			}
		});
		$("[data-class=on]").html(alert_ob.alert_txt_2_1);

	}
	var stu_year="";
	//学生调班的操作
	$("[data-btn=classModify]").live("click",function(){
		alert_ob.alert_type=true;
		add_class=$("[data-class=on] option:selected").val();
		if(!add_department){popBox.errorBox("请选择学段");return;}
		if(!add_class){popBox.errorBox("请选择班级");return;}
		$.post("/personnel/student/student-class-modify", {userId:userId, department:add_department, classId:add_class}, function(data){
			if(data.success){
				$(".u"+userId+" td").eq(4).html($("[data-department=on] option:selected").html());
				$(".u"+userId+" td").eq(5).html($("[data-class=on] option:selected").html());
				popBox.successBox(data.message);
				$("#alert").remove();
				$("#alert_bg").remove();
			}else{
				popBox.errorBox(data.message);
			}
		});

	});
	//对学生的离校操作
	$("[data-out=leave_out]").live('click',function(){
		userId = $(this).attr("data-userId");
		popBox.confirmBox('确认让该生离开学校？', function () {
			$.post("/personnel/student/student-leave-school", {userId: userId}, function (data) {
				if (data.success) {
					$("#alert").remove();
					$("#alert_bg").remove();
					window.location.reload();
					popBox.successBox(data.message);
				} else {
					popBox.errorBox(data.message);
				}
			})
		})
	})



	$(document).on('click','.other_operation',function(){
		var _this=$(this);
		var title=_this.children('em');
		var sel_list=_this.find('.sUI_selectList');
		var sel_item=_this.find('a');
		sel_list.show();
		sel_item.click(function(){
			if(typeof(_this.attr("data-noChange"))=="undefined"){
				title.text($(this).text())
			}
			sel_list.hide();
			return;
		});
		return;
	});
	$(".reset_pwd").live('click', function () {
		//用于修改密码弹窗
		userId = $(this).parents(".fathers_td").attr("uid");
		$.get("/personnel/student/alert-password", {userId: userId}, function (data) {
			$("#reset_passwordBox").html(data);
			$('#reset_passwordBox').dialog("open");
		})
	});

	function other_opr (){

	};
	other_opr ();


})

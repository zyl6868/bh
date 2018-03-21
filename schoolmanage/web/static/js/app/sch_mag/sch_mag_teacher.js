define(["popBox", 'jquery', 'jquery_sanhai', 'jqueryUI', 'validationEngine', 'validationEngine_zh_CN'], function (popBox) {
    $('#edit_user_info_form').validationEngine();
    $('#add_user_info_form').validationEngine();
    $('#mainSearch').placeholder({
        value: "请输入手机号或者用户名搜索……",
        left: 15,
        top: 4
    });

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
        var subjectId = $("#subjectId").val();
        var department = $(this).val();
        $.get("/personnel/teacher/index", {department: department, subjectId: subjectId}, function (data) {
            $("#personnel_list").html(data);
            other_opr();
        })
    });
    //年级刷选
    $("#subjectId").change(function () {
        var subjectId = $(this).val();
        var department = $("#departmentId").val();
        $.get("/personnel/teacher/index", {department: department, subjectId: subjectId}, function (data) {
            $("#personnel_list").html(data);
            other_opr();
        })
    });

    //关键字搜索
    $("#search_word").click(function () {
        var subjectId = $("#subjectId").val();
        var department = $("#departmentId").val();
        var searchWord = $("#mainSearch").val();
        $.post("/personnel/teacher/index", {
            searchWord: searchWord,
            department: department,
            subjectId: subjectId
        }, function (data) {
            $("#personnel_list").html(data);
            other_opr();
        })
    });

    //重置密码
    $(document).on("click", ".res_passwd", function () {
        var userId = $(this).attr("uId");
        popBox.confirmBox('确认重置该教师密码？', function () {
            $.get("/personnel/teacher/update-password", {userId: userId}, function (data) {
                if (data.success) {
                    popBox.successBox(data.message);
                    $("#reset_passwordBox").dialog("close");
                } else {
                    popBox.errorBox(data.message);
                }
            })
        })
    });

    //添加老师弹窗
    $(document).on("click", ".addTeahcerAccount", function () {
        $.get("/personnel/teacher/add-tea-info-view", function (data){
            $("#addTeacher").html(data);
            $('#addTeacher').dialog("open");
        })
    });
    //添加老师账号
    $(document).on("click", ".add_info_btn", function () {
        if ($('#add_user_info_form').validationEngine('validate')) {
            var _this = $(this);
            var trueName = $("#tea_name").val();
            var bindphone = $("#tea_mol").val();
            var sex = $("input[name='sex']:checked").val();

            var department = $("#department").val();
            var subjectID = $("#subject").val();
            var textbookVersion = $("#version").val();

            if (department.length == 0) {
                popBox.errorBox("请选择学段！");
                return false;
            }
            if (subjectID.length == 0) {
                popBox.errorBox("请选择学科！");
                return false;
            }
            if (textbookVersion.length == 0) {
                popBox.errorBox("请选择版本！");
                return false;
            }

            if (trueName.length < 2) {
                popBox.errorBox("用户名不能小于2个字符！");
                return false;
            }

            $.post("/personnel/teacher/add-teacher-account", {
                trueName: trueName,
                bindphone: bindphone,
                sex: sex,
                department: department,
                subjectID: subjectID,
                textbookVersion: textbookVersion
            }, function (data) {
                if (data.success) {
                    $.get("/personnel/teacher/index", function (data) {
                        $("#personnel_list").html(data);
                    })
                    $("#addTeacher").dialog("close");
                    $('#addTeacherSuccess').find(".phoneReg").html(data.data);
                    $('#addTeacherSuccess').dialog("open");
                } else {
                    popBox.errorBox(data.message);
                }
            })
        }
    });


    //查看详情
    $(document).on("click", ".viewInfo", function () {
        //查看详情
        var userId = $(this).parents(".fathers_td").attr("uid");
        $.get("/personnel/teacher/view-user-info", {userId: userId}, function (data) {
            $("#infoBox").html(data);
            $('#infoBox').dialog("open");
        })
    });

    //编辑详情
    $(document).on("click", ".editInfo", function () {
        //点击修改 获取用户
        var userId = $(this).parents(".fathers_td").attr("uid");
        $.get("/personnel/teacher/update-tea-info-view", {userId: userId}, function (data) {
            $("#editInfoBox").html(data);
            $('#editInfoBox').dialog("open");
        })

    });
    //修改用户信息
    $(document).on("click", ".edit_info_btn", function () {
        if ($('#edit_user_info_form').validationEngine('validate')) {
            var _this = $(this);
            var userId = _this.attr("uId");
            var teaName = $("#tea_name").val();
            var teaSex = $("input[name='sex']:checked").val();

            var subject = $("#subject").val();
            var version = $("#version").val();

            var pattern = /[\u4E00-\u9FA5\uF900-\uFA2D]/;
            if (pattern.test(teaName) == false) {
                popBox.errorBox("请正确输入名称！");
                return false;
            }
            if (subject.length == 0) {
                popBox.errorBox("请选择学科！");
                return false;
            }

            if (teaName.length < 2) {
                popBox.errorBox("用户名不能小于2个字符！");
                return false;
            }

            $.post("/personnel/teacher/update-user-info", {
                userId: userId,
                teaName: teaName,
                teaSex: teaSex,
                subject: subject,
                version: version

            }, function (data) {
                if (data.success) {
                    popBox.successBox(data.message);
                    $.get("/personnel/teacher/teacher-one-detail", {userId: userId}, function (result) {
                        $(".u" + userId).html(result);
                        other_opr()
                    });
                    $("#editInfoBox").dialog("close");
                } else {
                    popBox.errorBox(data.message);
                }
            })
        }
    });
    $(".addmemor_btn").click(function () {
        $("#confirmBox").dialog("open");

    });
    $(document).on('click', '.other_operation', function () {
        var _this = $(this);
        var title = _this.children('em');
        var sel_list = _this.find('.sUI_selectList');
        var sel_item = _this.find('a');
        sel_list.show();
        sel_item.click(function () {
            if (typeof(_this.attr("data-noChange")) == "undefined") {
                title.text($(this).text())
            }
            sel_list.hide();
            return;
        })
        return false;
    });

    $(".reset_pwd").live("click", function () {
        var userId = $(this).parents(".fathers_td").attr("uid");
        $.get("/personnel/teacher/alert-password", {userId: userId}, function (data) {
            $("#reset_passwordBox").html(data);
            $('#reset_passwordBox').dialog("open");
        })
    });
    function other_opr() {
        //$('.other_operation').sUI_select();
        //$(".reset_pwd").click(function () {
        //	var userId = $(this).parents(".fathers_td").attr("uid");
        //	$.get("/personnel/teacher/alert-password", {userId: userId}, function (data) {
        //		$("#reset_passwordBox").html(data);
        //		$('#reset_passwordBox').dialog("open");
        //	})
        //});
    };
    other_opr();

    var alert_ob = {};//弹出框对象
    alert_ob.alert_type = true;//控制弹出框
    alert_ob.alert_txt_7 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">修改班级<div id="alert_remove" class="alert_remove"></div></div><div id="alert_main" class="alert_main">' +
        '<div class="select_t"><label class="division_lab" for="division">学部：<span id="departmentName" data-departmentId=""></span></label>' +
        '<label class="class_lab" for="class">年级：</label><select data-btn="test" id="department_select"><option value="011">请选择</option></select></div>' +
        '<span style="margin-left:45px;">班级：</span>' +
        '<ul id="add_parent" class="add_parent">' +
        '<div class="centent">' +
        '<select multiple id="select1" class="select1">' +
            /*'<option value="1">2015年一班</option>'+*/
        '</select>' +
        '</div>' +
        '<div style="padding:0;margin-top:48px;" class="centent"><button id="add" class="add">添加</button><br />' +
        '<button id="remove" class="remove">删除</button></div>' +
        '<div class="centent">' +
        '<select multiple id="select2" class="select2">' +
            /*'<option value="8"></option>'+*/
        '</select>' +
        '<div>' +
        '</div>' +
        '</div></div></ul>' +


        '<div id="btn_c" class="btn_c"><button id="btn_2" class="save_modifyClass btn_2">保存</button><button id="btn_3" class="cancel_modifyClass btn_3">取消</button></div></div><div id="alert_bg" class=alert_bg></div>';
    alert_ob.alert_txt_8 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">移除本校<div id="alert_remove" class=alert_remove></div></div><div id="alert_main" class="alert_main">' +
        '<h3><span id="teacherName">11</span>&nbsp;老师是否离开本校?</h3><p style="text-align: center">离校后,该教师将与本校解除绑定关系,将不能在本校平台中进行任何教学操作!</p></div>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2 kicked_out_school" data-userId="">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    alert_ob.alert_n = function (txt) {
        alert_ob.alert_type = false;
        $("body").append(txt);
        $("#alert").css("top", $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2) + 'px');
        $("#alert").css("left", ($(window).width() - $("#alert").width()) / 2 + 'px');
        $("#alert_bg").css({"height": $('body').height() + 'px', 'width': $('body').width() + 'px'});
        return false;
    };
    window.onresize = function () {
        $("#alert").css("top", $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2) + 'px');
        $("#alert").css("left", ($(window).width() - $("#alert").width()) / 2 + 'px');
        $("#alert_bg").css({"height": $('body').height() + 'px', 'width': $('body').width() + 'px'});
    };
    /**
     * 弹出框关闭 remove
     */
    $("#alert_remove").live("click", function () {//remove 弹出框    点击 x
        alert_ob.alert_type = true;
        $("#alert").remove();
        $("#alert_bg").remove();
        rightBox = [];
        return false;
    });
    $("#btn_3").live("click", function () {//remove 弹出框  取消
        alert_ob.alert_type = true;
        $("#alert").remove();
        $("#alert_bg").remove();
        rightBox = [];
        return false;
    });
    $(window).keyup(function (event) {//remove 弹出框  取消
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 27) { // 按 Esc
            alert_ob.alert_type = true;
            $("#alert").remove();
            $("#alert_bg").remove();
            rightBox = [];
            return false;
        }
    });

    //老师移除学校事件
    $(".live-school-th").live("click", function () {
        userId = $(this).attr('data-userId');
        userName = $(this).attr('data-userName');
        if (alert_ob.alert_type) {
            alert_ob.alert_n(alert_ob.alert_txt_8);
            $('#teacherName').html(userName);
            $('.kicked_out_school').attr('data-userId', userId);
        }
    });
    //老师移除学校  确定事件
    $(document).on("click", ".kicked_out_school", function () {
        var userId = $(this).attr("data-userId");

        popBox.confirmBox('确认将该教师移除学校吗？', function () {
            $.post("/personnel/teacher/kicked-out-school", {userId: userId}, function (data) {
                if (data.success) {
                    popBox.successBox(data.message);
                    alert_ob.alert_type = true;
                    $("#alert").remove();
                    $("#alert_bg").remove();
                    window.location.reload();
                } else {
                    popBox.errorBox(data.message);
                }
            })
        })
    });

    //学部下的所有年级
    function grade(gradeList) {
        var gradeOption = "";
        if (gradeList.length == 0) {
            gradeOption += '<option>没有班级</option>';
            $('#department_select').html(gradeOption);
        } else {
            var i = 1;
            gradeOption += '<option value="">请选择</option>';
            $.each(gradeList, function (n, value) {
                gradeOption += '<option id="opt' + i + '" data-id="' + i + '" value="' + n + '">' + value + '</option>';
                $('#department_select').html(gradeOption);
                i++;
            });
        }
    }

    //老师教的班级
    function classes(classesList) {
        var gradeOption = "";
        if (classesList.length != 0) {
            var i = 1;
            $.each(classesList, function (n, value) {
                gradeOption += '<option id="opt' + i + '" data-id="' + i + '" value="' + n + '">' + value + '</option>';
                $('#select2').html(gradeOption);
                i++;
            });
        }
    }

    //获取年级下面相应的班级
    function gradeClasses(classesList) {
        var gradeOption = "";
        if (classesList.length == 0) {
            gradeOption += '';
            $('#select1').html(gradeOption);
        } else {
            var i = 1;
            $.each(classesList, function (n, value) {
                gradeOption += '<option id="opt' + i + '" data-id="' + i + '" value="' + n + '">' + value + '</option>';
                $('#select1').html(gradeOption);
                i++;
            });
        }
    }

    //修改班级弹框
    var rightBox = [];
    var arr_repeat_val = {};
    $(".update_class").live("click", function () {
        var userId = $(this).attr('data-userId');
        var departmentName = $(this).attr('data-departmentName');
        var departmentId = $(this).attr('data-departmentId');

        if (alert_ob.alert_type) {
            alert_ob.alert_n(alert_ob.alert_txt_7);

            $('#departmentName').html(departmentName);
            $('#departmentName').attr('data-departmentId', departmentId);
            $('#departmentName').attr('data-userId', userId);
            $.post('/personnel/teacher/get-grade', {departmentId: departmentId}, function (data) {
                grade(data.data);
            });
            $.post('/personnel/teacher/teaching-classes', {userId: userId}, function (data) {
                classes(data.data);
                for (var key in data.data) {
                    rightBox.push(key);
                }
            })
        }

    });

    //根据年级获取相应的班级
    $("[data-btn=test]").live("change", function () {
        if ($("[data-btn=test] option:selected").val() != '') {

            var gradeId = $("[data-btn=test] option:selected").val();
            ;
            var departmentId = $("#departmentName").attr("data-departmentId");
            $.post('/personnel/teacher/get-classes', {gradeId: gradeId, departmentId: departmentId}, function (data) {
                gradeClasses(data.data);
                //判断是否重复
                for (var i = 0, len = $("#select1 option").length; len > i; i++) {
                    var rightValue = $("#select1 option").eq(i).val();
                    if ($.inArray(rightValue, rightBox) >= 0) {
                        $("#select1 option").eq(i).attr({"disabled": "disabled", "selected": false});
                    }
                }
            })
        } else if ($("[data-btn=test] option:selected").val() == '') {
            $("#select1").html('');
        }
    });


    //保存修改班级事件
    $(".save_modifyClass").live('click', function () {
        if (rightBox.length == 0) {
            popBox.errorBox("请选择班级");
        } else {
            popBox.confirmBox('确认修改班级吗？', function () {
                var userId = $("#departmentName").attr('data-userId');
                var departmentId = $("#departmentName").attr('data-departmentId');
                if (userId == "" || userId == null) {
                    popBox.errorBox('用户不能为空');
                }
                if (departmentId == "" || departmentId == null) {
                    popBox.errorBox('学部不能为空');
                }
                var classIdList = [];
                $('#select2 option').each(function () {
                    var classId = $(this).attr('value');
                    classIdList.push(classId);
                });
                $.unique(classIdList);

                $.post('/personnel/teacher/teacher-class-modify', {
                    userId: userId,
                    classIdList: classIdList
                }, function (data) {
                    if (data.success) {
                        popBox.successBox(data.message);
                        alert_ob.alert_type = true;
                        $("#alert").remove();
                        $("#alert_bg").remove();
                        window.location.reload();
                    } else {
                        popBox.errorBox(data.message);
                    }
                })
            })
        }
    });

    //向右添加
    $("#add").live("click", function () {
        if (!$("#select1 option:selected").val()) {
            popBox.errorBox("请选择添加的班级");
        }
        for (var i = 0, len = $("#select1 option:selected").length; len > i; i++) {
            var val = $("#select1 option:selected").eq(i).val();
            arr_repeat_val[val] = false;
            rightBox.push(val);
            $($("#select1 option:selected")[i].outerHTML).appendTo("#select2");
        }
        $("#select1 option:selected").attr({"disabled": "disabled", "selected": false});
    });
    //向左删除
    $("#remove").live("click", function () {
        if (!$("#select2 option:selected").val()) {
            popBox.errorBox("请选择删除的班级");
        }
        for (var i = 0, len = $("#select2 option:selected").length; len > i; i++) {
            var value = $("#select2 option:selected").eq(i).val();
            $("#select1 option[value='" + value + "']").attr('disabled', false);
            rightBox.splice($.inArray(value, rightBox), 1);
        }
        $("#select2 option:selected").remove();
    });

})

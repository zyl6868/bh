define(['jquery', 'popBox', 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN'], function ($, popBox) {
    //var s="测试";
    var alert_ob = {};//弹出框对象
    alert_ob.alert_type = true;//控制弹出框
    //班级小学部。初中部。高中部
    $("#status_selected").attr("selected", "selected");
    var department = {'20201': '小学部', '20202': '初中部', '20203': '高中部'};
    /**
     *
     * @param data 年部小学部。初中部。高中部
     * @param year 入学年份
     */
        //var test='';
        // 弹出框 创建班级
    alert_ob.alert_txt_1 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">创建班级<div id="alert_remove" class="alert_remove"></div>' +
        '</div><div id="alert_main" class="alert_main"><p><span class="text_l"><i>*</i>学部:</span>' +
        '<span class="text_r" data-php="on">123</span></p>' +
        '<p><span class="text_l"><i>*</i>年级:</span><span class="text_r">' +
        '<select id="class_push" data-php="grade">' +
        '<option value ="">请选择</option>' +
        '</select></span></p>' +
        '<p><span class="text_l"><i>*</i>班级:</span><span class="text_r">' +
        '<select id="classNumber"><option value ="">请选择</option>' ;

        for(var i=1;i<=30;++i){
            alert_ob.alert_txt_1 +=  '<option value ="'+i+'">'+i+'班</option>' ;
        }

    alert_ob.alert_txt_1 +='</select></span>' +
        '</p><p><span class="text_l"><i>*</i>入学年份:</span>' +
        '<span class="text_r"><select data-php="year"  id="joinYear"><option value ="">请选择</option>' +
        '</select></span></p>' +
        '<p><span class="text_l" style="float:left;">提示:</span>' +
        '<span class="text_r">1、"入学年份"请选择本学段中学生入学年份;<br>&nbsp;&nbsp;2、如果希望创建的班级与已存在的班级冲突,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请确认现存班级是否继续使用,如不再使用,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请将现有冲突班级进行<a href="javascript:;" style="text-decoration:underline;">毕业/升级/封班</a>操作。</span></p></div>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class=btn_2 data-btn="add_class">保存</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    alert_ob.alert_txt_2 = '<div id="alert" style="width:650px;" class="alert">' +
        '<div id="alert_header" class="alert_header">封班<div id="alert_remove" class="alert_remove"></div></div>' +
        '<div id="alert_main" class="alert_main"><p><span class="text_l"><i>*</i>年级:</span><span class="text_r"><select close-class="grade" id="sel_grade"><option value="0">全部</option><option value ="1">初一</option><option value ="2">初二</option><option value="3">初三</option></select></span></p>' +
        '<ul class="seal_class"  close-class="class">' +
        '<li style="float:left;"><input type="checkbox" name="seal_class" value="初一_1班">初一&nbsp;1班</li>' +
        '</ul>' +
        '<p class="seal_class CheckedAll"><input type="checkbox">全选</p></div>' +
        '<p class="sealed_class clearfix"><lable style="float:left;width:48px;margin-left:30px;">提示：</lable><span style="float:right;width:444px;">操作后在本班中将不能再进行任何教学活动，班级中所有成员将脱离现有班级组织关系，但仍存在于本学校中，适用于分班时操作。</span></p>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="seal_class_btn btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    //'<button id="seal_class_btn">封班</button></div><div id="alert_bg"></div><div id="alert_bg"></div>';
    //弹出框 升级
    alert_ob.alert_txt_3 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">升级<div id="alert_remove" class="alert_remove"></div></div>' +
        '<h4>是否确定进行升级操作?</h4><p style="margin-left:50px;">1、升级后,所有班级的年级属性增长一级(如一年级1班升为二年级1班),<br>毕业年级的所有班级将置为毕业状态;<br>2、本次操作不可逆;<br>3、每年限操作一次</p>' +
        '<div id="btn_c" class=btn_c><button id="btn_2" class="upgrade btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div><div id="alert_bg" class="alert_bg"></div>';
    //弹出框 老师移出本班
    alert_ob.alert_txt_4_1 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">移出本班<div id="alert_remove" class="alert_remove"></div></div>' +
        '<h4 style="color: #f97373"><span class="name_on_box">李芳</span>&nbsp;老师是否离开本班？</h4>' +
        '<p style="text-align:center">移出班级后,该老师将于本班级解除绑定关系<br>将不能在本班中进行任何教学操作！<br></p>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    //弹出框 学生移出本班
    alert_ob.alert_txt_4_2 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">移出本班<div id="alert_remove" class="alert_remove"></div></div>' +
        '<h4 class="red" style="color: #f97373"><span class="name_on_box">李芳</span>&nbsp;是否离开本班？</h4>' +
        '<p style="text-align:center">移出班级后,该学生将于本班级解除绑定关系<br>将不能在本班中进行任何学习操作！<br></p>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    //弹出框 学生移出本校
    alert_ob.alert_txt_4_3 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">移出本校<div id="alert_remove" class="alert_remove"></div></div>' +
        '<h4 class="red" style="color: #f97373"><span class="name_on_box">李芳</span>&nbsp;是否离开本校？</h4>' +
        '<p style="text-align:center">离校后,该学生将于本校解除绑定关系<br>将不能在本校中进行任何学习操作！<br></p>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    //弹出框修改教师身份
    alert_ob.alert_txt_5 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">修改教师身份<div id="alert_remove" class="alert_remove"></div></div>' +
        '<h4><span class="name_on_box">李芳</span>&nbsp;在本班的身份将置被为</h4>' +
        '<p style="margin-left:35%;"><input type="radio" name="s_f" value="20401" style="margin-right: 8px;">班主任<input class="space" type="radio" name="s_f" value="20402" style="margin-right: 8px;">任课老师</p>' +
        '<div id="btn_c" class=btn_c><button id="btn_2" class=btn_2>确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class=alert_bg></div>';
    //弹出框修改学生身份
    alert_ob.alert_txt_6 = '<div id="alert" class=alert><div id="alert_header" class=alert_header>修改学生身份<div id="alert_remove" class="alert_remove"></div></div>' +
        '<h4><span class="name_on_box">李芳</span>&nbsp;在本班的身份将置被为</h4>' +
        '<table id="s_f" class="s_f"><tr>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20107">学生</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20101">班长</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20108">副班长</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20104">学习委员</td>' +
        '</tr><tr>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20106">体育委员</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20109">生活委员</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20110">宣传委员</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20102">团支书</td>' +
        '</tr><tr>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20111">文艺委员</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20105">卫生委员</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20103">信息委员</td>' +
        '<td><input class="radio_space" type="radio" name="s_f" value="20112">其他班干部</td>' +
        '</tr></table>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div><div id="alert_bg" class="alert_bg"></div>';
    alert_ob.alert_txt_7 = '<div id="alert" class="alert"><div id="alert_header" class="alert_header">添加老师<div id="alert_remove" class="alert_remove"></div></div>' +
        '<div id="alert_main" class="alert_main"><p><span class="text_r">添加老师:</span><span class="text_l glass" id="glass"><input type="text" id="find_teacher" class="find_teacher" placeholder="请输入教师帐号/姓名/手机号"><span></span></span></p>' +
        '<p id="no_find_name" class="no_find_name"></p>' +
        '<table id="find_name" class="find_name"></table>' +
        '<div id="btn_c" class="btn_c"><button id="btn_2" class="btn_2">确定</button><button id="btn_3" class="btn_3">取消</button></div></div></div><div id="alert_bg" class="alert_bg"></div>';
    //$("#find_teacher").on("focus",function(){
    //    if($("#find_teacher").html()=="请输入教师帐号/姓名/手机号"){
    //        $("#find_teacher").html("");
    //        $("#find_teacher").css("color","black");
    //    }
    //});
    /**
     * 弹出框函数
     * @param txt 传入节点字符串 html
     * @returns {boolean}
     */
    alert_ob.alert_n = function (txt) {
        alert_ob.alert_type = false;
        $("body").append(txt);
        $("#alert").css("top", $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2));
        $("#alert").css("left", ($(window).width() - $("#alert").width()) / 2);
        $("#alert_bg").css({"height": $(document).height()});
        $("#alert_bg").css({"width": $(document).width()});
        return false;
    };
    window.onresize = function () {
        $("#alert").css("top", $(window).scrollTop() + (($(window).height() - $("#alert").height()) / 2));
        $("#alert").css("left", ($(window).width() - $("#alert").width()) / 2);
        $("#alert_bg").css({"height": $(document).height()});
        $("#alert_bg").css({"width": $(document).width()});
    };
    $(window).keyup(function (event) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 27 && !alert_ob.alert_type) {
            alert_ob.alert_type = true;
            $("#alert").remove();
            $("#alert_bg").remove();
            return false;
        }
    });
    /**
     * 弹出框关闭 remove
     */
    $("#alert_remove").live("click", function () {//remove 弹出框
        alert_ob.alert_type = true;
        $("#alert").remove();
        $("#alert_bg").remove();
        return false;
    });
    $("#btn_3").live("click", function () {//remove 弹出框

        alert_ob.alert_type = true;
        $("#alert").remove();
        $("#alert_bg").remove();
        return false;
    });
    /**
     * 学校部关联学段
     * @type {string}
     */
    $("#class_name").live("focus", function () {
        //if (this.value == "请输入10字以内") {
        //    this.value = "";
        this.style.color = "black";
        //}
    });
    $("#class_name").live("blur", function () {
        //if (this.value == "") {
        //    this.value = "请输入10字以内";
        this.style.color = "black";
        //}
    });
    $(".CheckedAll input").live("click", function () {
        $("[name=seal_class]:checkbox").prop("checked", this.checked);
    });
    /**
     * 弹出框 触发事件
     */
        //升级
    $("#update").live("click", function () {
        if (alert_ob.alert_type) {

            alert_ob.alert_n(alert_ob.alert_txt_3);
        }
    });

    //升级
    $(".upgrade").live('click', function () {
        var departmentId = $(".class_grade").attr('departmentId');
        $.post("/organization/default/upgrade", {departmentId: departmentId}, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                setTimeout("window.location.reload()", 1000);
            } else {
                popBox.errorBox(data.message);
            }
        });

    });

    //封班弹框
    $("#found").live("click", function () {
        if (alert_ob.alert_type) {
            var departmentId = $(".class_grade").attr('departmentId');
            $.post("/organization/default/close-class", {departmentId: departmentId}, function (data) {
                var close_grade = '<option value ="">全部</option>';
                $.each(data.gradeArr, function (key, val) {
                    close_grade += '<option value ="' + key + '">' + val + '</option>';
                });

                var close_class = '';
                $.each(data.classListArr, function (key, val) {
                    close_class += '<li><input type="checkbox" name="seal_class" value="' + val.classID + '">' + val.className + '</li>';
                });
                alert_ob.alert_n(alert_ob.alert_txt_2);
                $("[close-class=grade]").html(close_grade);
                $("[close-class=class]").html(close_class);
            });

        }
    });


    //完成封班

    $(".seal_class_btn").live('click', function () {
        var schoolId = $(".class_grade").attr('schoolId');
        var classIds = [];
        $('input[name="seal_class"]:checked').each(function () {
            classIds.push($(this).val());
        });
        //console.log(classIds.length);
        if (classIds.length == 0) {
            popBox.errorBox('请选择班级');
            return false;
        }
        $.post("/organization/default/finish-close-class", {schoolId: schoolId, classIds: classIds}, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                setTimeout("window.location.reload()", 1000);
            } else {
                popBox.errorBox(data.message);
            }
        })
    });

    //封班：更换年级
    $("#sel_grade").live('change', function () {
        $(".CheckedAll input").attr("checked", false);
        var departmentId = $(".class_grade").attr('departmentId');
        var gradeId = $(this).val();
        $.get("/organization/default/get-class", {gradeId: gradeId, departmentId: departmentId}, function (data) {
            var close_class = '';
            $.each(data.classListArr, function (key, val) {
                close_class += '<li><input type="checkbox" name="seal_class" value="' + val.classID + '">' + val.className + '</li>';
            });
            $("[close-class=class]").html(close_class);
        })
    });

    //创建班级函数
    function new_section(departmentId, data, grade, year) {
        alert_ob.alert_txt_1_1 = '';
        for (var i = 0, len = data.length; len > i; i++) {
            var ischecked = '';
            if (data[i].id == departmentId) {
                ischecked = 'checked';
            }
            alert_ob.alert_txt_1_1 += '<input ' + ischecked + ' type="radio" class="department" name="department" value="' + data[i].id + '">' + department[data[i].id];
        }
        //年级
        alert_ob.alert_txt_1_3 = '<option value ="">请选择</option>';
        $.each(grade, function (i, item) {

            alert_ob.alert_txt_1_3 += '<option value ="' + i + '">' + item + '</option>';
        });
        //年份
        alert_ob.alert_txt_1_2 = '<option value ="">请选择</option>';
        //var year_arr = year.split(',');
        var year_arr = year;
        for (var i = 0, len = year_arr.length; len > i; i++) {
            alert_ob.alert_txt_1_2 += '<option value ="' + year_arr[i] + '">' + year_arr[i] + '年</option>';
            if (i == 10) {
                break;
            }
        }
    }

    //创建班级
    $("#closure").live("click", function () {
        if (alert_ob.alert_type) {
            var departmentId = $(".class_grade").attr('departmentId');
            $.get("/organization/default/get-department-year", {departmentId: departmentId}, function (data) {

                if (data.success) {
                    //console.log(data.gradeArr);return;s
                    new_section(departmentId, data.departmentArr, data.gradeArr, data.joinYear);

                    alert_ob.alert_n(alert_ob.alert_txt_1);
                    $("[data-php=on]").html(alert_ob.alert_txt_1_1);
                    $("[data-php=grade]").html(alert_ob.alert_txt_1_3);
                    $("[data-php=year]").html(alert_ob.alert_txt_1_2);
                }
            });
        }
    });


    //保存创建班级
    $('[data-btn=add_class]').live('click', function () {
        var departmentId = $('input[name="department"]:checked').val();
        var gradeId = $("#class_push").val();
        var joinYear = $("#joinYear").val();
        var classNumber = $("#classNumber").val();

        if (gradeId == '') {
            popBox.errorBox('请选择年级');
            return false;
        }
        if (classNumber == '') {
            popBox.errorBox('请选择班级');
            return false;
        }
        if (joinYear == '') {
            popBox.errorBox('请选择入学年份');
            return false;
        }
        $.get("/organization/default/create-class", {
            departmentId: departmentId,
            gradeId: gradeId,
            classNumber: classNumber,
            joinYear: joinYear
        }, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                setTimeout("window.location.reload()", 1000);
            } else {
                popBox.errorBox(data.message);
                return false;
            }

        });
    });


    //打开左侧列表
    $('#sch_mag_classesBar_btn').click(function () {
        $(".sch_mag_homes").slideDown();
        return false;
    });


    //年级刷选
    $("#gradeId").change(function () {
        var classId = $("#classId").val();
        var gradeId = $(this).val();
        var departmentId = $(".class_grade").attr('departmentId');
        var status = $("#classStatus").val();
        $.get("/organization/default/index", {
            departmentId: departmentId,
            gradeId: gradeId,
            classId: classId,
            status: status
        }, function (data) {
            $(".table_con").html(data);
        })
    });

    //状态筛选
    $("#classStatus").change(function () {
        var status = $(this).val();
        var classId = $("#classId").val();
        var gradeId = $("#gradeId").val();
        var departmentId = $(".class_grade").attr('departmentId');
        $.get("/organization/default/index", {
            departmentId: departmentId,
            gradeId: gradeId,
            classId: classId,
            status: status
        }, function (data) {
            $(".table_con").html(data);
        })
    });


    //点击学部更换年级
    $('.department').live("click", function () {
        var departmentId = $('input[name="department"]:checked').val();
        $.get("/organization/default/get-grade", {departmentId: departmentId}, function (data) {
            alert_ob.alert_txt_1_3 = '<option value ="">请选择</option>';
            $.each(data, function (i, item) {
                alert_ob.alert_txt_1_3 += '<option value ="' + i + '">' + item + '</option>';
            });
            $("[data-php=grade]").html(alert_ob.alert_txt_1_3);
        })
    });


    //添加老师
    $("#addTh").live("click", function () {
        if (alert_ob.alert_type) {
            alert_ob.alert_n(alert_ob.alert_txt_7);
            $('#btn_c').hide();
            $('#btn_2').click(function () {
                var userID = $('input:radio[name="find_name"]:checked').val();

                alert_ob.alert_type = true;
                $("#alert").remove();
                $("#alert_bg").remove();
                var classID = $('#classID').attr('data-value');
                if (userID != null) {
                    $.post('add-teacher-to-class', {'classID': classID, 'userID': userID}, function (result) {
                        if (result.success) {
                            popBox.successBox(result.message);
                            location.reload();
                            return false;
                        }
                        popBox.errorBox(result.message);
                    });

                    return false;
                }
                popBox.errorBox('请选择老师');
            });
            $('#find_teacher').focus();
        }
    });
    //修改老师身份
    $(".editIdentity").live("click", function () {
        var userID = $(this).parent('.operate ').attr('userID');

        var classID = $('#classID').attr('data-value');


        if (alert_ob.alert_type) {
            var name = $(this).parents('.tea').find('.name').html();
            alert_ob.alert_n(alert_ob.alert_txt_5);
            $('.name_on_box').html(name);

            $('#btn_2').click(function () {

                var identity = $('input:radio[name="s_f"]:checked').val();

                alert_ob.alert_type = true;

                $("#alert").remove();

                $("#alert_bg").remove();

                if (identity != null) {

                    $.post('change-identity', {
                        userID: userID,

                        classID: classID,

                        identity: identity,

                        type: 1

                    }, function (result) {

                        if (result.success) {
                            popBox.successBox(result.message);
                            location.reload();
                            return false;
                        }
                        popBox.errorBox(result.message);

                    });

                    return false;
                }
                popBox.errorBox('请选择身份');
            })
        }
    });
    //修改学生身份
    $(".updateIden").click(function () {
        if (alert_ob.alert_type) {

            var name = $(this).parents('.stu').find('.name').html();
            alert_ob.alert_n(alert_ob.alert_txt_6);

            $('.name_on_box').html(name);


            var userID = $(this).parents('.pop').attr('userID');

            var classID = $('#classID').attr('data-value');

            $('#btn_2').click(function () {

                var identity = $('input:radio[name="s_f"]:checked').val();

                alert_ob.alert_type = true;

                $("#alert").remove();

                $("#alert_bg").remove();
                if (identity != null) {

                    $.post('change-identity', {
                        userID: userID,

                        classID: classID,

                        identity: identity,

                        type: 0

                    }, function (result) {

                        if (result.success) {
                            popBox.successBox(result.message);
                            location.reload();
                            return false;
                        }
                        popBox.errorBox(result.message);

                    });

                    return false;
                }
                popBox.errorBox('请选择身份');
            })
        }
    });
    //老师离开班级
    $(".th_remove_class").click(function () {

        if (alert_ob.alert_type) {
            var classID = $('#classID').attr('data-value');

            var userID = $(this).parent('.operate ').attr('userID');

            var name = $(this).parents('.tea').find('.name').html();

            alert_ob.alert_n(alert_ob.alert_txt_4_1);

            $('.name_on_box').html(name);

            $('#btn_2').click(function () {

                $("#alert").remove();

                $("#alert_bg").remove();

                $.post('leave-class', {classID: classID, userID: userID}, function (result) {

                    if (result.success) {
                        popBox.successBox(result.message);
                        location.reload();
                        return false;
                    }
                    popBox.errorBox(result.message);


                })
            })
        }
    });
    //学生离开班级
    $(".student_remove_class").click(function () {
        if (alert_ob.alert_type) {
            var classID = $('#classID').attr('data-value');

            var userID = $(this).parents('.pop').attr('userID');

            var name = $(this).parents('.stu').find('.name').html();

            alert_ob.alert_n(alert_ob.alert_txt_4_2);
            $('.name_on_box').html(name);

            $('#btn_2').click(function () {

                $("#alert").remove();

                $("#alert_bg").remove();

                $.post('leave-class', {classID: classID, userID: userID}, function (result) {

                    if (result.success) {
                        popBox.successBox(result.message);
                        location.reload();
                        return false;
                    }
                    popBox.errorBox(result.message);

                })
            })
        }
    });
    //学生离开学校
    $(".student_remove_school").click(function () {

        if (alert_ob.alert_type) {
            var name = $(this).parents('.stu').find('.name').html();
            var userID = $(this).parents('.pop').attr('userID');
            alert_ob.alert_n(alert_ob.alert_txt_4_3);
            $('.name_on_box').html(name);
            $('#btn_2').click(function () {

                popBox.confirmBox('确认让该生离开学校？', function () {
                    $.post("/personnel/student/student-leave-school", {userId: userID}, function (data) {
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
        }
    });
    $('.popBox').dialog({
        autoOpen: false,
        width: 840,
        modal: true,
        resizable: false,
        close: function () {
            $(this).dialog("close")
        }
    });
    $("#class_grade").delegate("li", "click", function () {
        var self = $(this);
        var ID = self.data("id");
        var grade = $("#grade" + ID);
        grade.addClass("ac");
        grade.siblings().removeClass("ac");
    });
//打开课程列表
    $('#sch_mag_classesBar_btn').click(function () {
        $(".sch_mag_homes").slideDown();
        return false;
    });
    //修改密码
    $(document).on("click", ".res_passwd", function () {
        var userId = $(this).attr("uId");
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

    //学生编辑详情
    $(document).on("click", ".editInfo", function () {
        var userID = $(this).parents('.fathers_td').find('.pop').attr('userID');
        $.get("/personnel/student/update-stu-info-view", {userId: userID}, function (data) {
            $("#editInfoBox").html(data);
            $('#editInfoBox').dialog("open");
        })
    });
    //学生查看详情
    $(document).on("click", ".viewInfo", function () {
        var userID = $(this).parents('.fathers_td').find('.pop').attr('userID');
        $.get("/personnel/student/view-user-info", {userId: userID}, function (data) {
            $("#stuInfoBox").html(data);
            $('#stuInfoBox').dialog("open");
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

            if (pattern.test(stuName) == false) {
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
                    $.get("/personnel/student/student-one-detail", {userId: userId}, function (result) {
                        location.reload();

                    });
                    $("#editInfoBox").dialog("close");
                } else {
                    popBox.errorBox(data.message);
                }
            })
        }
    });
});

define(['jquery', "popBox", 'dialogBox', 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN'],

    function ($, popBox, dialogBox, jquery_sanhai, validationEngine, validationEngine_zh_CN) {
        $('form').validationEngine({
            validateNonVisibleFields: true,
            promptPosition: "centerRight",
            maxErrorsPerField: 1,
            showOneMessage: true,
            addSuccessCssClassToField: 'ok'
        });

        $('#provience').trigger("change");

        //根据地区查询学校列表
        $("#searchClass").on('click', function () {
            var provience = $("#provience").val();
            var city = $("#city").val();
            var country = $("#country").val();
            if (provience == '' || city == '' || country == '') {
                popBox.errorBox('省,市,区都不能为空！');
                return false;
            }

            $.get('/teacher/searchschool/index', {country: country}, function (result) {
                $('#schoolArea').attr('schoolCountryId', country);
                $('#schoolList').html(result);
            });
        });

        document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if(ev.keyCode==13) {
               searchSchool();
            }
        };

        //根据名字查询学校
        $("#searchBtn").on('click', function () {
            searchSchool();
        });

        function searchSchool() {
            var schoolName = $("#schoolName").val();
            schoolName = $.trim(schoolName);

            // var verify = /[\w\u4e00-\u9fa5]/;
            //
            // if (!verify.exec(schoolName)) {
            //     popBox.errorBox("请输入正确的学校名！");
            //     return false;
            // }

            if (schoolName.length == 0) {
                window.location.href = '/teacher/searchschool/index';
                return false;
            }
            if(schoolName.length >30){
                popBox.errorBox('名称长度不能大于30个字符！');
                return false;
            }
            window.location.href = '/teacher/searchschool/find-school-by-name?schoolName=' + encodeURIComponent(schoolName);
        }


        //学校下的班级列表
        $(".schoolClass").on('click', function () {
            $(".schoolClass").removeClass('ac');
            $(this).addClass('ac');
            var departmentId = $(this).attr('departmentId');
            var schoolId = $("#selectDepartment").attr('schoolId');
            $.get('class-list', {departmentId: departmentId, schoolId: schoolId}, function (result) {
                $("#classList").html(result);
            })
        });

        //去创建班级
        $('#createClass').on('click', function () {
            var schoolId = $("#selectDepartment").attr('schoolId');
            var departmentId = $(".schoolClass.ac").attr('departmentId');
            window.location.href = '/teacher/searchschool/create-class?schoolId=' + schoolId + '&departmentId=' + departmentId;
        });

        //创建班级页面
        $(".create_class").on('click', function () {
            $(".create_class").removeClass('ac');
            $(this).addClass('ac');
            var departmentId = $(this).attr('departmentId');
            var schoolId = $("#createClass_dep").attr('schoolId');
            window.location.href = '/teacher/searchschool/create-class?schoolId=' + schoolId + '&departmentId=' + departmentId;
        });

        //确认创建班级
        $('.affirm').on('click', function () {
            var schoolId = $("#createClass_dep").attr('schoolId');
            var departmentId = $(".create_class.ac").attr('departmentId');
            var gradeId = $("#gradeId").val();
            var gradeName = $("#gradeId").find("option:selected").text();
            var classId = $("#classId").val();
            var joinYear = $("#joinYear").val();

            $.post('/teacher/searchschool/confirm-create-class', {
                schoolId: schoolId,
                departmentId: departmentId,
                gradeId: gradeId,
                classId: classId,
                joinYear: joinYear
            }, function (result) {

                var info = '';
                if(result.success){
                    info = '创建成功';
                }else{
                    info = '已存在';
                }
                dialogBox({
                    title: '加入班级',
                    content: '<p class="tc"><span class="blue">' + gradeName + '&nbsp;' + joinYear + '年' + classId + '班&nbsp;'+info+'</span>，是否确认加入此班级？</p>',
                    TrueBtn: {
                        name: '确定加入',
                        fn: function () {
                            $.post('/teacher/searchschool/join-class', {classId: result.data}, function (result) {
                                if (result.success) {
                                    popBox.successBox(result.message);
                                    setTimeout(function () {
                                        window.location.href = "/class/" + result.data + "/index";
                                    }, 1500);
                                } else {
                                    popBox.errorBox(result.message);
                                }
                            });

                        }
                    },
                    FalseBtn: {
                        name: '取消'
                    }
                });

            })

        })

        $(document).on('click', ".joinClass", function () {
            var classId = $(this).attr('classId');
            var className = $(this).prev('span').html();
            dialogBox({
                title: '加入班级',
                content: '<p class="tc">是否确认加入&nbsp;<span class="blue">' + className + '</span>？</p>',
                TrueBtn: {
                    name: '确定加入',
                    fn: function () {
                        $.post('/teacher/searchschool/join-class', {classId: classId}, function (result) {
                            if (result.success) {
                                popBox.successBox(result.message);
                                setTimeout(function () {
                                    window.location.href = "/class/" + classId + "/index";
                                }, 1500);
                            } else {
                                popBox.errorBox(result.message);
                            }
                        });
                    }
                },
                FalseBtn: {
                    name: '取消'
                }
            });

        })

        //去申请学校
        $("#schoolArea").on('click', function () {
            var schoolCountryId = $(this).attr('schoolCountryId');
            window.location.href = '/teacher/searchschool/apply-school?schoolCountryId=' + schoolCountryId;
        });


        $(".applyBtn").on('click', function () {
            var provinceId = $(this).attr('provinceId');
            var cityId = $(this).attr('cityId');
            var countryId = $(this).attr('countryId');
            var applySchoolName = $("#applySchoolName").val();
            if($.trim(applySchoolName) == ''){
                popBox.errorBox('学校名不能为空！');
                return false;
            }

            $.post('/teacher/searchschool/confirm-apply-school', {
                provinceId: provinceId,
                cityId: cityId,
                countryId: countryId,
                applySchoolName: applySchoolName
            }, function (result) {
                if (result.success) {

                    $.get('/site/logout',{},function () {})

                    dialogBox({
                        title: '班班提醒',
                        content: '<p class="tc" style="font-size: 1.5em;color: #81da94;margin: 10px 0;"><img src="/static/images/correct.jpg" style="vertical-align: sub;margin-right: .2em" alt="">申请成功，请耐心等候！</p><p class="tc" style="line-height: 2">将会有工作人员联系您创建学校和班级。</p><p class="tc" style="line-height: 2">在没有加入学校和班级的情况下没办法使用班海。</p>',
                        TrueBtn: {
                            name: '退出登录',
                            fn: function () {
                                window.location.href = '/site/login';
                            }
                        },
                        noRemove: true
                    });

                } else {
                    popBox.errorBox(result.message);
                }
            })

        })


    });
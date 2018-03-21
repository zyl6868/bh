define(['jquery_sanhai','dialogBox', 'popBox', 'jqueryUI'], function (jquery_sanhai,dialogBox, popBox) {

    $('#modify').dialog({
        autoOpen: false,
        width: 350,
        modal: true,
        resizable: false
    });
    $('#addGroup').dialog({
        autoOpen: false,
        width: 350,
        modal: true,
        resizable: false
    });
    $('#delGroup').dialog({
        autoOpen: false,
        width: 350,
        modal: true,
        resizable: false
    });
    $('#delCourse').dialog({
        autoOpen: false,
        width: 350,
        modal: true,
        resizable: false
    });
    $('#popBox4').dialog({
        autoOpen: false,
        width: 700,
        modal: true,
        resizable: false,
        close: function () {
            $(this).dialog("close");
        }
    });


    $('.collections .modify').live('click', function () {
        $('#modify').dialog('open');
    });
    $('.custom_groups .addGroup').click(function () {
        $('#addGroup input').val('');
        $('#addGroup').dialog('open');
    });
    $('.collections .delGroup').live('click', function () {
        $('#delGroup').dialog('open');
    });

    /**
     * 课件移动到其他组
     */
    $('.manipulate .move').live('click', function () {
        if ($('.manipulate .move_to').css('display') == 'none') {
            $('.manipulate .move_to').css('display', 'block');
        } else {
            $('.manipulate .move_to').css('display', 'none');
        }
    });
    $('.manipulate .move_to li a').live('click', function () {
        if ($('.oneCheck:checked').length <= 0) {
            popBox.errorBox('请选择要移动的课件！');
        } else {
            var checkedBox = $('.oneCheck:checked');
            var collectArray = [];
            checkedBox.each(function (index, el) {
                var collectId = $(el).parents('li').attr('collectId');
                collectArray.push(collectId);
            });
            var groupId = $(this).attr('groupId');
            $.post('/teacher/favoritematerial/move-group', {
                groupId: groupId,
                collectArray: collectArray
            }, function (result) {
                if (result.success == true) {
                    popBox.successBox(result.message);
                    location.reload();
                } else {
                    popBox.successBox(result.message);
                    return false;
                }

            });

        }
    });

    /**
     * 删除组
     */
    $('.manipulate .remove').live('click', function () {
        if ($('.oneCheck:checked').length <= 0) {
            popBox.errorBox('请选择要删除的课件！');
        } else {
            $('#delCourse').dialog('open');
        }
    });
    $('.cancelBtn').live('click', function () {
        $(this).parents('.popBox').dialog('close');
    });
    $('#delCourse .okBtn').click(function () {
        var $this = $(this);

        var groupType = $('#sel_classes').attr('data-type');
        var checkedBox = $('.oneCheck:checked');
        var collectArray = [];
        checkedBox.each(function (index, el) {
            var collectId = $(el).parents('li').attr('collectId');
            collectArray.push(collectId);
        });
        $.post('/teacher/favoritematerial/delete-material', {
            collectArray: collectArray,
            'groupType': groupType
        }, function (result) {
            $this.parents('.popBox').dialog('close');
            if (result.success) {
                popBox.successBox(result.message);
                location.reload();
                return false;
            }
            popBox.errorBox(result.message);
        });

    });

    //类型搜索
    $(document).on('click', '.select_mattype', function () {
        var _this = $(this);
        var url = _this.attr('data-url');
        $.get(url, {}, function (data) {
            $("#material_list").html(data);
        })
    });

    //收藏，取消收藏
    $('.fav').live('click', function () {
        var _this = $(this);
        var id = _this.attr('data-id');
        var type = _this.attr('data-type');
        var url = _this.attr('data-url');
        var department = _this.attr('data-department');
        var subjectId = _this.attr('data-subjectId');
        var groupId = _this.attr('data-groupId');
        var groupType = _this.attr('data-groupType');
        var cancelUrl = _this.attr('data-url-cancel');
        var defaultGroupId = _this.attr('data-default-groupId');

        if (_this.hasClass('cur')) {
            $.post(cancelUrl, {fileId: id}, function (data) {
                if (data.success) {
                    _this.parents('li').remove();
                    //刷新组列表
                    $.get('/teacher/favoritematerial/group-list', {
                        department: department,
                        subjectId: subjectId,
                        groupType: groupType,
                        groupId: groupId,
                        defaultGroupId:defaultGroupId
                    }, function (data) {
                        $("#groupList").html(data);
                    })
                } else {
                    popBox.errorBox(data.message);
                }
            });
        } else {
            $.post(url, {fileId: id}, function (data) {
                if (data.success) {
                    _this.children('.collection').text('取消收藏');
                    var collectNum = _this.children('.collectionNum').text();
                    _this.children('.collectionNum').text(++collectNum);
                    _this.addClass('cur');
                } else {
                    if(data.code == 401 ){
                        dialogBox({
                            title:'收藏课件',
                            content:'<p class="tc">'+data.message+'</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                            TrueBtn:{
                                name:'知道了'
                            }
                        });
                    }else{
                        popBox.errorBox(result.message);
                    }
                }

            });
        }
    });

//预览课件
    $(document).on('click',"#previewMaterial",function () {
        var _this = $(this);
        var fileId = _this.attr("fileId");

        $.get('/ajax/preview-material',{fileId:fileId},function (result) {

            if(result.success == false){

                if(result.code == 401 ){
                    dialogBox({
                        title:'预览课件',
                        content:'<p class="tc">'+result.message+'</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                        TrueBtn:{
                            name:'知道了'
                        }
                    });
                }else{
                    popBox.errorBox(result.message);
                }

            }else{
                var readNum = _this.children('.readNum').text();
                _this.children('.readNum').text(++readNum);
                window.open(result.data);
            }

        });

    });

    //下载课件
    $(document).on('click',"#downloadMaterial",function () {
        var _this = $(this);

        var fileId = _this.attr("fileId");
        var price = _this.attr("price");


        $.post('/ajax/is-privilege-to-download',{fileId:fileId},function (data) {
            if(data.success == false){
                dialogBox({
                    title:'下载课件',
                    content:'<p class="tc">抱歉,此资源为高级会员专属,普通用户不能下载.</p><p class="tc">请到手机app端申请成为高级会员.</p>',
                    TrueBtn:{
                        name:'知道了'
                    }
                });
            }else{
                dialogBox({
                    title: '下载课件',
                    content: '<p class="tc">普通会员'+price+'学米</p><p class="tc">高级会员'+Math.ceil(price/2)+'学米</p>',
                    TrueBtn: {
                        name: '确定',
                        fn: function () {
                            $('#mask').remove();

                            $.post('/ajax/download-material',{fileId:fileId},function (result) {
                                if(result.success == false){

                                    if(result.code == 401 ){
                                        defaultMessage='请到手机app端申请成为高级会员.';
                                        if(result.message.indexOf("学米") > 0){
                                            defaultMessage = '';
                                        }
                                        dialogBox({
                                            title:'下载课件',
                                            content:'<p class="tc">'+result.message+'</p><p class="tc">'+defaultMessage+'</p>',
                                            TrueBtn:{
                                                name:'知道了'
                                            }
                                        });
                                    }else{
                                        popBox.errorBox(result.message);
                                    }

                                }else{
                                    var downloadNum = _this.children('.downloadNum').text();
                                    _this.children('.downloadNum').text(++downloadNum);
                                    window.open(result.data);
                                }

                            });
                        }
                    },
                    FalseBtn: {
                        name: '取消'
                    }
                });
            }
        });
    });

//dom增加阅读数
//     $('.addReadNum').live('click', function () {
//         var _this = $(this);
//         var readNum = _this.children('.readNum').text();
//         _this.children('.readNum').text(++readNum);
//     });
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
    //创建组
    $('#sureAddCroup').click(function () {
        groupName = $.trim($('#addGroup input').val());

        if (groupName.length > 16) {
            popBox.errorBox('最多15个字符');
            return false;
        }
        if (groupName.length == 0) {
            popBox.errorBox('请输入组名！');
            return false;
        }
        var department = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var groupType = $('#sel_groupType .ac').attr('data-groupType');
        $.post('/teacher/favoritematerial/add-group', {
            'department': department,
            'subjectId': subjectId,
            'groupName': groupName
        }, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                $("#addGroup").dialog("close");
                location.reload();
            } else {
                popBox.alertBox(data.message);
            }

        })
    });

    //修改组
    $('#updateGroupName').live('click', function () {

        var department = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var groupName = $.trim($('#modify input').val());

        if (groupName.length <= 0) {
            popBox.errorBox('请输入组名！');
            return false;
        }
        if (groupName.length > 16) {
            popBox.errorBox('最多15个字符');
            return false;
        }
        groupId = $(this).attr('data-groupId');
        $.post('/teacher/favoritematerial/update-group-name', {
            'groupId': groupId,
            'department': department,
            'subjectId': subjectId,
            'groupName': groupName
        }, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                $("#modify").dialog("close");
                location.reload();
            } else {
                popBox.alertBox(data.message);
            }
        })
    });

    //删除组
    $('#deleteGroup').live('click', function () {

        var department = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var groupId = $(this).attr('data-groupId');
        $.post('/teacher/favoritematerial/delete-group', {
            'department': department,
            'subjectId': subjectId,
            'groupId': groupId
        }, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                $("#delGroup").dialog("close");
                location.href = '/teacher/favoritematerial/index?department=' + department + '&subjectId=' + subjectId;
            } else {
                popBox.alertBox(data.message);
            }
        })
    });

    //分享弹框
    $('.cls_rg_list .share').live('click', function () {
        var $_this = $(this);
        var id = $_this.attr('data_id');
        $.post("/teacher/favoritematerial/get-material-box", {id: id}, function (data) {
            $("#popBox4").dialog("open");
            $("#collectShare").html(data);
        });
    });

    //分享对象的选择高亮
    $('.testClsList li').live('click', function () {
        if ($(this).hasClass('ac')) {
            $(this).removeClass('ac');
        } else {
            $(this).addClass('ac');
        }
    });

    //分享的班级
    selectCollect = function () {
        var classAll = [];
        $("#popBox4 .class").children('.ac').each(function () {
            classAll.push($(this).attr('data_classId'));
        });
        return classAll.join(',');
    };

    //分享到班级或者教研组
    $('#popBox4 .okBtn').live('click', function () {
        var shareId = $('#popBox4 #share').val();
        var classId = selectCollect();
        var groupId = $("#popBox4 .group").children('.ac').attr('data_groupId');

        if (groupId == undefined && classId == "") {
            popBox.errorBox('请选择教研组或班级');
            return false;
        }
        $.post("/teacher/favoritematerial/shared-material", {
            shareId: shareId,
            classId: classId,
            groupId: groupId
        }, function (data) {
            if (data.success) {
                $('.test_paper_sort .btn').addClass('batch');
                $('.cek').hide();
                $('.cek').children('label').removeClass('chkLabel_ac');
                popBox.successBox(data.message);
                setTimeout(function(){
                    location.reload();
                },1800)

            } else {
                popBox.errorBox(data.message);
            }
        })
    });


});
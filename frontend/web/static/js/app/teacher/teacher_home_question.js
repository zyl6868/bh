define(['jquery_sanhai','popBox','jqueryUI'],function(jquery_sanhai,popBox){

////////////////////////////////////////////////////////////platform_question_search

////////////////////////////////////////////////////////////

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
  $('#delQuestion').dialog({
    autoOpen: false,
    width: 350,
    modal: true,
    resizable: false
  });



    //弹出修改组名弹框
    $('.collections .modify').click(function(){
        $('#modify').dialog('open');
        var groupId = $(this).attr('gId');
        groupNameOld = $( '.groupNameOld' + groupId).attr('data-groupNameOld');
        if(groupNameOld){
            $('#groupNameNew').val(groupNameOld);
        }else{
            $('#groupNameNew').val('我的收藏');
        }
    });

    //修改自定义收藏组名
    $('#modify .okBtn').click(function(){
        var _this = $(this);
        var departmentId = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var groupId = $('#sel_classes').attr('data-groupId');
        var groupNameEmpty = $('#groupNameNew').val();
        var groupName = $.trim(groupNameEmpty);
        if(groupName == '' || groupName == null ){ popBox.errorBox('请输入组名！'); return; }
        if( groupName == groupNameOld){ popBox.errorBox('请修改组名！'); return; }

        $.post('/teacher/question/modify-group-name', {
            groupId: groupId,
            groupName: groupName,
            department: departmentId,
            subjectId: subjectId,
        }, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                $.post('/teacher/question/define-group', {department:departmentId,subjectId:subjectId,groupId:groupId}, function(result){
                    if(result.success==true) {
                        $('#groupRefresh').html(result.data);
                        $('#gName').html(groupName);
                    }
                });
            } else {
                popBox.errorBox(data.message);
            }
            $('#modify').dialog('close');
        });
    });

    //弹出添加组弹框
    $('.custom_groups .addGroup').click(function(){
        $('#addGroup').dialog('open');
        $('#groupName').val('');

    });

    //添加自定义收藏组
    $('#addGroup .okBtn').click(function(){
        var departmentId = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var groupNameEmpty = $('#groupName').val();
        var groupName = $.trim(groupNameEmpty);
        var groupId = $('#sel_classes').attr('data-groupId');
        if(groupName == '' || groupName == null){
            popBox.errorBox('请输入组名！');
            return false;
        }

        $.post('/teacher/question/add-group', {
            department: departmentId,
            subjectId: subjectId,
            groupName: groupName
        }, function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                $.post('/teacher/question/define-group', {department:departmentId,subjectId:subjectId,groupId:groupId}, function(result){
                    if(result.success==true){
                        $('#groupRefresh').html(result.data);
                    }
                });
                window.location.reload();
            } else {
                popBox.errorBox(data.message);
            }
            $('#addGroup').dialog('close');
        });
    });


    //移动题目到指定组
    $('.checkMove').click(function(){
        if($('.oneCheck:checked').length <= 0){
            popBox.errorBox('请选择要移动的题目！');
            return false;
        }else{
            var questionIds = [];
            $('input[name="Check"]:checked').each(function(){
                questionIds.push($(this).val());
            });
            var groupId = $(this).attr('data-groupId');
            $.post('/teacher/question/batch-move-group', {questionIds:questionIds,groupId:groupId}, function(data){
                if (data.success) {
                    popBox.successBox(data.message);
                    window.location.reload();
                }else{
                    popBox.errorBox(data.message);
                }
            });
        }
    });




    //弹出删除题目弹框
    $('.remove').click(function(){
        if($('.oneCheck:checked').length <= 0){
            popBox.errorBox('请选择要删除的题目！');
            return false;
        }else{
            $('#delQuestion').dialog('open');return false;
        }
    });

    //执行删除题目操作
    $('#delQuestion .okBtn').click(function(){
        var _this = $(this);
        var departmentId = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var questionIds = [];
        $('input[name="Check"]:checked').each(function(){
            questionIds.push($(this).val());
        });
        var groupId = $('#sel_classes').attr('data-groupId');
        var type = _this.attr('data-typeId');
        var complexity = _this.attr('data-complexity');
        $.post('/teacher/question/batch-del-question', {questionIds:questionIds,groupId:groupId}, function(data){
            if (data.success) {
                popBox.successBox(data.message);
                $('#delQuestion').dialog('close');
                window.location.href="/teacher/question/index?department="+departmentId+"&subjectId="+subjectId+"&groupId="+groupId+"&type="+type+"&complexity="+complexity;
            }else{
                popBox.errorBox(data.message);
            }
        });
    });


    //弹出删除组弹框
  $('.collections .delGroup').click(function(){
    $('#delGroup').dialog('open');
  });

    //删除自定义收藏组
    $('#delGroup .okBtn').click(function(){
        var _this = $(this);
        var departmentId = $('#sel_classes').attr('data-department');
        var subjectId = $('#sel_classes').attr('data-subjectId');
        var groupId = $('#sel_classes').attr('data-groupId');
        var collectGroupId = _this.attr('data-collectGroupId');

        $.post('/teacher/question/del-group', {groupId: groupId}, function (data) {
            if (data.success) {
                popBox.successBox('删除成功');
                $.post('/teacher/question/define-group', {department:departmentId,subjectId:subjectId,groupId:groupId}, function(result){
                    if(result.success==true){
                        $('#groupRefresh').html(result.data);
                    }
                });
                window.location.href="/teacher/question/index?department="+departmentId+"&subjectId="+subjectId+"&groupId="+collectGroupId;
            } else {
                popBox.errorBox(data.message);
            }
            $('#delGroup').dialog('close');
        });
    });

    //关闭弹窗
    $('.cancelBtn').click(function(){
        $('.popBox').dialog('close');
    });

  $('.manipulate .move').click(function(){
      $('.manipulate .move_to').show();
      return false;

  });

    //题目列表
    var getContent=function(obj){
        var url=$(obj).attr('href');
        $.get(url,function(data){
            $(".content").html(data);
        });
        return false;
    }

    $('#questionNum').html(0);



});
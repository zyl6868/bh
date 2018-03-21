define(['popBox','sanhai_tools','jquery_sanhai','jqueryUI'],function(popBox,sanhai_tools){

    $('#pop_sel_classes').dialog({
        autoOpen: false,
        width: 720,
        modal: true,
        resizable: false
    });


    $('#pop_system_msg').dialog({
        autoOpen: false,
        width: 720,
        modal: true,
        resizable: false,
        buttons: [{
            text: "确定",
            click: function() {
                $(this).dialog("close");
            }
        }

        ]
    });




  $('.textareaBox').speak('请输入意见反馈...',300);

  //查看解析答案按钮
  $('.show_aswerBtn').click(function(){
    var _this=$(this);
    var pa=_this.parents('.quest')
    pa.toggleClass('A_cont_show');
    _this.toggleClass('icoBtn_close');
    if(pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
    else _this.html('查看答案解析 <i></i>');
  });

  function placeholder(obj, defText) {
    obj.val(defText)
      .css("color", "#ccc")
      .focus(function() {
        if ($(this).val() == defText) {
          $(this).val("").css("color", "#333");
        }
      }).blur(function() {
        if ($(this).val() == "") {
          $(this).val(defText).css("color", "#ccc");
        }
      });
  }
  /*布置给学生弹窗*/
    /*布置给学生弹窗*/
    $('#upbtn').click(function () {
        var homeworkIsExist = $(this).attr('data-exist');
        var homeworkId = $(this).attr('data-id');
        $.post('/teacher/managetask/is-exist', {homeworkID: homeworkId}, function (result) {
            if (result.success) {
                var type = 1;
                $.post('/teacher/managetask/get-class-box-new', {
                    homeworkid: homeworkId,
                    type: 1
                }, function (data) {
                   $('#pop_sel_classes').html(data);
                   $("#pop_sel_classes").dialog("open");

                   $('.popBox .cancelBtn').click(function(){
                        $(this).parents('.popBox').dialog("close");
                   });
                });
            }
            else {
                popBox.confirmBox("请先收藏作业，确认收藏作业吗？", function () {

                    var url = '/teacher/managetask/library-join-teacher';
                    $.post(url, {homeworkID: homeworkId}, function (result) {
                        $.post('/teacher/managetask/get-class-box-new', {
                            homeworkid: homeworkId,
                            type: 1
                        }, function (data) {
                            $('#pop_sel_classes').html(data);
                            $("#pop_sel_classes").dialog("open");

                            $('.popBox .cancelBtn').click(function(){
                                $(this).parents('.popBox').dialog("close");
                            });
                        });
                    })
                })
            };

        });
    });


  /*收藏作业弹窗*/
    $('#upbtnBox').click(function () {
        var homeworkID = $(this).attr('data-id');
        var url = '/teacher/managetask/library-join-teacher';
        $.post(url, {homeworkID: homeworkID}, function (result) {
            if (result.success) {
                $("#pop_system_msg").dialog("open");
            } else {
                popBox.errorBox(result.message);
            }
        })

    });

    $(".isAssigned").click(function () {
        popBox.errorBox('当前作业已经被加入了');
    })

    $(".btn_Submit").click(function(){
        var suggestion = $(".add_txt").val();
        var homeworkID=$(this).attr('data-id');
        $.post("/teacher/managetask/add-suggest",{homeworkID:homeworkID,suggestion:suggestion},function(result){
            if (result.success) {
                $(".add_txt").val('');
                popBox.successBox('反馈提交成功');
            }
        })
    });

//是否需要签字

    $('#isSignature').live('click', function () {
        _this = $(this);
        var isSignature = _this.val();
        if (isSignature == 0) {
            _this.attr('checked', 'checked');
            _this.val('1');
        } else if (isSignature == 1) {
            _this.attr('checked', false);
            _this.val('0');
        }
    });


})





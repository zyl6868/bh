define(["popBox",'userCard','jquery_sanhai','jqueryUI'],function(popBox,userCard,jquery_sanhai){
    $('#slide').slide({'width':821});


        var scroll_Left=0;
        //右侧点击状态
        $("#q_list li").click(function(){
            scroll_Left=$('.cor_questions').scrollLeft();
            $(this).addClass("act").siblings().removeClass("act");
            $(".original").removeClass("show_original");
        });



        var q_lis=$("#q_list li");
        var ul_w=0;

        q_lis.each(function(index, element) {
            ul_w+=$(this).outerWidth(true);
        });
        $("#q_list").width(ul_w+20);

        //批改状态
        $('.cor_btn a').click(function(){
            var homeworkAnswerID = $(".cur").attr("homeworkAnswerID");
            if(homeworkAnswerID == null){
                popBox.errorBox("请选择学生答题卡");
            }
            var questionID = $(".act").attr('questionID');
            var aid = $(".act").attr('aid');
            if(questionID!=null) {
            var num=$("#q_list li").size();
            var index=0;
            var cls_name=$(this).attr('class');
                function chk(cls_name){
                    index=$("#q_list .act").index()+1;
                    scroll_Left+=100;
                    $("#q_list .act i").removeClass().addClass(cls_name+"_btn");
                    $("#q_list .act").removeClass('act').next().addClass('act');
                    $('.cor_questions').scrollLeft(scroll_Left);
                }
                //cls_name=="check" && chk("check")||cls_name=="half" && chk("half")||cls_name=="wrong" && chk("wrong");
                function update(homeworkAnswerID, correctResult, aid) {
                    $.post("/class/ajax-org-correct", {
                        homeworkAnswerID: homeworkAnswerID,
                        correctResult: correctResult,
                        aid: aid
                    }, function (result) {
                        if (result.success) {
                            switch (correctResult) {
                                case 1:
                                    chk("wrong");
                                    break;
                                case 2:
                                    chk("half");
                                    break;
                                case 3:
                                    chk("check");
                                    break;
                            }
                            var topic_num = $("#q_list i[class$=btn]").size();
                            $('#userList .cur span').text(topic_num);

                            if (topic_num == num)  popBox.confirmBox('是否确定全部题目已批改完成？',
                                function () {
                                    $.post("/class/update-hom-correct-level", {homeworkAnswerID: homeworkAnswerID}, function (result) {
                                        if (result.success == false) {
                                            popBox.errorBox('更新失败');
                                        }else{
                                            //window.location.reload();
                                            if(window.location.href.split('type=')[1] == 1){
                                                window.location.reload();
                                                return;
                                            }
                                            var aUrl;
                                            if($('#userList dl').length > 1){
                                                aUrl = $('#userList dl').not('.cur').eq(0).find('a').attr('href');
                                            } else {
                                                aUrl = $('#userList a').eq(0).attr('href');
                                            }
                                            window.location.href = aUrl;
                                        }
                                    })
                                },
                                function () {
                                }
                            );
                        }
                    });
                }

                switch (cls_name) {
                    case "check":
                        correctResult = 3;
                        update(homeworkAnswerID, correctResult, aid);
                        break;
                    case "half":
                        correctResult = 2;
                        update(homeworkAnswerID, correctResult, aid);
                        break;
                    case "wrong":
                        correctResult = 1;
                        update(homeworkAnswerID, correctResult, aid);
                        break;
                }
            }else{
                popBox.errorBox("请选择题目");
            }

        });


    //原题弹窗
    $(".original").click(function(){
        var questionID = $('.act').attr('questionID');
        if(questionID!=null){
            if ($(this).hasClass('show_original')) {
                // $(".exhibition").toggle();
            } else {
                $.post('/class/get-question-content', {questionID: questionID}, function (result) {
                    $(".exhibition").html(result);
                });
            }
            $(this).toggleClass("show_original");
        }else{
            popBox.errorBox('请选择题目');
        }
    });


});
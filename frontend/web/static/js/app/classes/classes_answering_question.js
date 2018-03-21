define(["popBox",'userCard','jquery_sanhai','validationEngine','validationEngine_zh_CN','jqueryUI'],

    function(popBox,userCard,jquery_sanhai,validationEngine,validationEngine_zh_CN){

        $(document).on('click','.delBtn',function(){
            $(this).parent().remove();
           });


        (function(){
            //选择课程
            $('.classes_file_list .row').openMore(36);
            $('#classes_sel_list .row').sel_list('single');

            //科目变化，列表自动刷新
            $(".subject_list").click(function(){
                var subjectID = $(this).find('.sel_ac').attr('subject');
                var solved_type = $('.is_solved').find('.sel_ac').attr("solved_type");
                var classId =$('.class_id').attr('cl');
                $.get('/class/answer-questions',{ subjectID: subjectID, classId: classId, solved_type: solved_type },function(data){
                    $(".check_answer_list").html(data);
                })
            });

            //解决状态筛选
            $(".is_solved").click(function(){
                var _this = $(this);
                var solved_type = _this.find('.sel_ac').attr("solved_type");
                var subjectID = $('.subject_list').find('.sel_ac').attr('subject');
                var classId = $('.clsId').attr("cls");
                $.get('/class/answer-questions',{ subjectID: subjectID, classId: classId, solved_type: solved_type},function(data){
                    $(".check_answer_list").html(data);
                })
            });

            //打开回答
            $('.reply').live('click',function () {

                var _this = $(this);
                var pa = $(this).parents('.QA_li');
                if(!pa.hasClass('open_ask')){
                    pa.addClass('open_ask').removeClass('open_answer');
                    pa.siblings('li').removeClass('open_ask open_answer');

                    var aqId = _this.parents('.aqId').attr("aqId");
                    $.get('/answernew/response-open',{aqId:aqId},function(data){
                        $('#response' + aqId).html(data);
                    })
                }
                else{
                    pa.removeClass('open_ask');
                }
            });

            //回答
            $('.answer_questions_btn').live('click',function () {

                var _this = $(this);
                var img_num = _this.parents('.form_r').find('.picList li img').length;

                var pa = _this.parents('.QA_li');
                var aqid = _this.attr('val');
                var answer = $(".textarea_content" + aqid).val();
                var img_val = $('.uploadFile ').parents('.picList').find(' li input').val();
                //$.trim($('[name="SeClassEvent[briefOfEvent]"]').val())=='';

                if ($.trim(answer) == '' && img_num<=0) {

                    popBox.errorBox("内容不能为空!");

                    return false;
                }
                if (answer.length > 1001) {
                    popBox.alertBox('超过1000字数限制，请重新编辑！');
                    return false;
                } else {
                    _this.removeClass("answer_questions_btn");
                    $.post('/answernew/result-question', {answer: answer, aqid: aqid,img_val:img_val}, function (data) {
                        if (data.success) {
                            popBox.successBox('回答成功');

                            $(".textarea_content" + aqid).val("");
                            //$("#upload_pic" + aqid).empty();
                            $(".upload_img").remove();
                            pa.removeClass('open_ask').addClass('open_answer').siblings('li').removeClass('open_answer open_ask');
                            answerNumber = $("a[aqid=" + aqid + "]").find("b").html();
                            answerNumber = parseInt(answerNumber) + 1;
                            $("a[aqid=" + aqid + "]").find("b").html(answerNumber);
                            //打开回答列表
                            $.post('/answernew/reply-list', {apid: aqid}, function (result) {
                                $('#reply_list' + aqid).html(result);
                            })
                        } else {
                            popBox.errorBox(data.message);
                        }
                    });
                    _this.parent().parent('.pop_up_js').hide();
                }
            });

            //答案列表
            $('.answer').live('click',function () {
                var rep_num = $(this).find("b").html();
                var pa = $(this).parents('.QA_li');

                if (rep_num == 0) {
                    popBox.errorBox('暂无答案！');
                    return false;
                } else {
                    if (!pa.hasClass('open_answer')) {
                        pa.addClass('open_answer').removeClass('open_ask');
                        pa.siblings('li').removeClass('open_answer open_ask');
                        var apid = $(this).attr('aqid');
                        $.post("/answernew/reply-list", {apid: apid}, function (data) {
                            $('#reply_list' + apid).html(data);
                        })
                    }
                    else {
                        pa.removeClass('open_answer')
                    }
                }
            });

            $('.QA_cancelBtn').live('click',function(){

                var pa = $(this).parents('.QA_li');
                pa.removeClass('open_ask');
                pa.find(".upload_img").remove();
                pa.find('.uploadFileBtn').show();

            });

            $('.QA_answerBtn').live('click',function(){});
            /*增加同问的数字*/
            $('.quiz_btn_add').live('click', function () {
                var aqid = $(this).attr('val');
                var creatorid = $(this).attr('user');
                var userid = $(this).attr('uuser');
                if (creatorid == userid) {
                    popBox.errorBox("请勿同问自己问答！");
                    return false;
                } else {
                    var aqid = $(this).attr('val');
                    //同问数+1
                    var same_number = $(this).children('#same' + aqid).attr('val');
                    same_number++;
                    $.get('/answernew/same-question', {aqid: aqid}, function (data) {
                        if (data.success) {
                            popBox.successBox(data.message);
                            $.get('/answernew/also-ask-head',{aqId:aqid},function(data){
                                $('#head_img'+aqid ).children('span').append().html(data);
                            });
                            $("#same" + aqid).text(same_number);
                        } else {
                            popBox.errorBox(data.message);
                        }
                    })
                }
            });

            /*点击采用变成已采用*/
            $('.adopt_btn').live('click', function () {
                var _this = $(this);
                _this.removeClass('adopt_rem');
                _this.parent().find('li').addClass('bestAnswer');
                _this.parents('.QA_li').addClass('solve');
                var creatorID = _this.parents("li").attr('creatorID');
                var aqid = _this.attr('u');
                var resultid = _this.attr('val');
                $.post('/answernew/use-the-answer', {
                    resultid: resultid,
                    creatorID: creatorID,
                    aqid:aqid
                }, function (data) {
                    if (data.success) {
                        popBox.successBox(data.message);
                        $.post('/answernew/answer-detail', {aqid: aqid}, function (datas) {
                            $('.answerBigBox' + aqid).children('.answerW').show();
                            //打开回答列表
                            $.post('/answernew/reply-list', {apid: aqid}, function (result) {
                                $('#reply_list' + aqid).html(result);
                            })
                        });
                    }
                    else
                    {
                        popBox.errorBox(data.message);
                    }
                })
            });

        })();

        //	显示卡片
        (function(){
            var overTime=null;
            var outTime=null;
            $('.icon_card').live({
                mouseover:function(){
                    clearTimeout(overTime);
                    var _this=$(this);
                    var userID = _this.attr('creatorID');
                    var source = _this.attr('source');
                    overTime=setTimeout(function(){
                        $.ajax({
                            url: "/answernew/show-per-msg",
                            data: {userID: userID, source: source},
                            type: 'get',
                            global: false,
                            success: function (data) {
                                if(data.success){
                                    userCard.userCard(_this,data.data);
                                }
                            }
                        });
                    },300);
                },
                mouseout:function(){
                    clearTimeout(overTime);
                    var card=card=$('.userCard');
                    function removeCard(){
                        outTime=setTimeout(function(){
                            card.remove();
                        },100);
                    }
                    removeCard();
                    overTime=setTimeout(function(){removeCard()},100);
                    card.mouseover(function(){
                        clearTimeout(overTime);
                        clearTimeout(outTime);
                    });
                    card.mouseout(function(){
                        removeCard();
                    });
                }
            });
        })();
        //答疑统计
        $('#anwser_rate_tab').tab(function(){
            alert('ajax');

        });

        //回答答疑可以继续添加的剩余图片的计算
        function leftImg(e){
            var _this = $(e);
            var liSize = _this.parents(".form_r").find('.picList li').length;
            $('.uploadFileBtn').find('span').html(2-liSize);
            if(liSize>1){
                $(".disabled").hide();
            }else{
                $('.disabled').show();
            }
        }

        $(document).on('click','.delBtn',function(){
            $(this).parent().remove();
            leftImg();
        });

        return {leftImg:leftImg}

});
define(['jquery','popBox','userCard','jqueryUI','jquery_sanhai','fancybox' ],
    function ($,popBox,userCard,jquery_sanhai,fancybox) {
        $('.fancybox').die().fancybox();
        $('.classes_file_list .row').openMore(40);
        $("#AllSubjects,#FullState").sel_list('single', function () {
        });
        $('.UPloadFil ul').sortable({items: "li:not(.disabled)"});
        $('.remove_images').live('click', function () {
            $(this).parent('li').remove();
            window.img_num++;
            $(".addPicUl li").css('display', 'block');
        });
        var overTime = null;
        var outTime = null;
        $('.icon_card').live({
            mouseover: function () {
                clearTimeout(overTime);
                var _this = $(this);
                var userID = _this.attr('creatorID');
                var source = _this.attr('source');
                overTime = setTimeout(function () {
                    $.ajax({
                        url: "/answernew/show-per-msg",
                        data: {userID: userID, source: source},
                        type: 'get',
                        global: false,
                        success: function (data) {
                            if (data.success) {
                                userCard.userCard(_this, data.data);
                            }
                        }
                    });
                }, 300);
            },
            mouseout: function () {
                clearTimeout(overTime);
                var card = card = $('.userCard');

                function removeCard() {
                    outTime = setTimeout(function () {
                        card.remove();
                    }, 100);
                }

                removeCard();
                overTime = setTimeout(function () {
                    removeCard()
                }, 100);
                card.mouseover(function () {
                    clearTimeout(overTime);
                    clearTimeout(outTime);
                });
                card.mouseout(function () {
                    removeCard();
                });
            }
        });


        /*增加同问的数字*/
        $('.quiz_btn_add').live('click', function () {
            var aqid = $(this).attr('aqID');
            var creatorid = $(this).attr('user');
            var userid = $(this).attr('userId');
            if (creatorid == userid) {
                popBox.errorBox("请勿同问自己问答！");
                return false;
            } else {
                //同问数+1
                var same_number = $('#alsoAskNum').text();
                same_number++;
                $.get('/answernew/same-question', {aqid: aqid}, function (data) {
                    if (data.success) {
                        popBox.successBox(data.message);
                        $.get('/answernew/also-ask-head',{aqId:aqid},function(data){
                            $('#head_img' ).children('span').append().html(data);
                        });
                        $("#alsoAskNum").text(same_number);
                    } else {
                        popBox.errorBox(data.message);
                    }
                })
            }
        });

        /*点击采用变成已采用*/
        $('.adopt_btn').live('click', function () {
            var _this = $(this);
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
                    location.reload();
                }
                else
                {
                    popBox.errorBox(data.message);
                }
            })
        });


        //回答
        $('.answer_questions_btn').live('click',function () {

            var _this = $(this);
            var img_num = $('.UPloadFil').find('.picList li img').length;

            var aqid = _this.attr('aqID');
            var answerID = _this.attr('answerID');
            var creatorID = $(".icon_card").attr('creatorID');
            var answer = $("#textarea_content").val();
            var img_val = $('.UPloadFil').find('.picList li.upload_img input').val();

            if(creatorID == answerID){
                popBox.errorBox('您不能回答自己的问题！');
                return false;
            }
            if ($.trim(answer) == '' && img_num<=0) {

                popBox.errorBox("内容不能为空!");

                return false;
            }
            if (answer.length > 1001) {
                popBox.alertBox('超过1000字数限制，请重新编辑！');
                return false;
            } else {
                $.post('/answernew/result-question', {answer: answer, aqid: aqid,img_val:img_val,creatorID:creatorID}, function (data) {
                    if (data.success) {
                        popBox.successBox('回答成功');
                        location.reload();
                    } else {
                        popBox.errorBox(data.message);
                    }
                });
            }
        });
        if( !('placeholder' in document.createElement('input')) ){
            $('input[placeholder],textarea[placeholder]').each(function(){
                var that = $(this),
                    text= that.attr('placeholder');
                if(that.val()===""){
                    that.val(text).addClass('placeholder');
                }
                that.focus(function(){
                        if(that.val()===text){
                            that.val("").removeClass('placeholder');
                        }
                    })
                    .blur(function(){
                        if(that.val()===""){
                            that.val(text).addClass('placeholder');
                        }
                    })
                    .closest('form').submit(function(){
                    if(that.val() === text){
                        that.val('');
                    }
                });
            });
        }
    });
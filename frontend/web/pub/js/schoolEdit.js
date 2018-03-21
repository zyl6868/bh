// JavaScript Document
$(function () {
    function has() {
        var oBtn = $('.b_jq_number');
        oBtn.each(function (index, element) {
            $(this).click(function () {
                //oBtn.hide();
                $(this).siblings('.b_jq_number').children('.overJs').hide();
                $(this).children('.overJs').show().animate({left: '-16px', top: '-10px'}, 0);

            });
            //alert(oBtn.length)
        });
        /*显示val和两个按钮*/
        $('.take_addClass').live('click', function () {
            $(this).siblings('.span_hide').show();
            $(this).hide();
            var oTxt03 = $(this).siblings('.text_one').val('');
            var oTxt04 = $(this).siblings('.text_tow').val('');
        });

        /*获取val的值*/
        /*添加班级的*/
        $('.overJs .take_ok2').bind('click', function () {
            //alert('为什么');
            var oTxt03 = $(this).siblings('.text_one').val();
            var oTxt04 = $(this).siblings('.text_tow').val();
            //alert(oTxt04)
            if (oTxt03 == '') {
                alert('此处不能为空');
                //return false;
            }
            else if (oTxt04 == '') {
                alert('此处不能为空2');
                //return false;
            }
            else {
                $(this).parent().parent().siblings('.addL').append('<span class="add_name"><em>' + oTxt03 + '</em><i>' + oTxt04 + '</i></span>');
                $(this).parent().hide();
                $(this).parent().siblings('.take_addClass').show();
                var oTxt03 = $(this).siblings('.text_one').val('');
                var oTxt04 = $(this).siblings('.text_tow').val('');
            }
        });
        $('.btn_cancel').bind('click', function () {
            $(this).parent().hide();
            $(this).parent().siblings('.take_addClass').show();
            var oTxt03 = $(this).siblings('.text_one').val('');
            var oTxt04 = $(this).siblings('.text_tow').val('');
        });

        $('.gradeJs').bind('click', function () {
            $('.overJs').hide();

        });
    }

    has();

    /*添加组织*/
    function add_no() {
        $('.take_add').bind('click', function () {
            $(this).siblings('.span_hide').show();
            $(this).hide();
        });
        $('.take_ok').bind('click', function () {
            var textVal = $(this).siblings('.text_Width').val();
            if (textVal == '') {
                //popBox.conformBox('亲,里面不填东西怎么行呢？')
            }
            else {
                $(this).parent().parent().siblings('.takeC').append('<div class="tack_box"><span>' + textVal + '</span></div>');
            }
            var textVal = $(this).siblings('.text_Width').val('');
            $(this).parent().hide();
            $(this).parent().siblings('.take_add').show()
        });
        $('.btn_cancel').bind('click', function () {
            $(this).parent().hide();
            $(this).parent().siblings('.take_add').show();
            var textVal = $(this).siblings('.text_Width').val('');
        })
    }
    add_no();

    function add() {
        var _this_left = 0;
        var _this_index = 0;
        $('.gradeJs').bind('click', function () {
            $(this).siblings('.span_hide').show();
            $(this).hide();
        });
        $('.take_oks').bind('click', function () {
            var textVal = $(this).siblings('.text_js').val();
            if (textVal == '') {
                alert('亲,里面不填东西怎么行呢？')
            }
            else {
                /*生成出来的html*/
                var html = '';
                html += '<div class="tack_box b_jq_number">';
                html += '<span class="tackL">' + textVal + '<i></i></span>';

                html += '<div class="add_class clearfix hide overJs pop">';
                html += '<div class="u_tran_t">111</div>';
                html += '<div class="addL">';

                html += '</div>';
                html += '<div class="addR">';
                html += '<span class="span_hide span_click hide">';
                html += '<input type="text" value="第一" class="text text_Width text_01">';
                html += '<input type="text" value="第二" class="text text_Width text_02">';

                html += '<button type="button" class="btn take_ok">确定</button>';
                html += '<button type="button" class="btn btn_cancel">取消</button>';
                html += '</span>';
                html += '<script>';
                html += '</script>';
                html += '<button type="button" class="takeR_btn take_addClass" style="float:right;">+添加班级</button>';
                html += '</div>';
                html += '</div>';

                $('.tackL').live('click', function (event) {
                    $(this).siblings('.overJs').show();
                    event.stopPropagation();
                });

                $('.take_addClass').live('click', function () {
                    $(this).siblings('.span_hide').show();
                    $(this).hide();
                });


                /*	$('.text_01').focus(function(){

                 $(this).val('');
                 })
                 $('.text_01').blur(function(){
                 $(this).val('第一');
                 })*/


                /*添加班级的*/
                $('.overJs .take_ok').die('click').live('click', function () {
                    //alert('为什么');
                    var oTxt01 = $(this).siblings('.text_01').val();
                    var oTxt02 = $(this).siblings('.text_02').val();
                    if (oTxt01 == '') {
                        alert('此处不能为空')
                    }
                    else if (oTxt02 == '') {
                        alert('此处不能为空')
                    }
                    else {
                        $(this).parent().parent().siblings('.addL').append('<span class="add_name"><em>' + oTxt01 + '</em><i>' + oTxt02 + '</i></span>');
                        $(this).parent().hide();
                        $(this).parent().siblings('.take_addClass').show();
                        var oTxt01 = $(this).siblings('.text_01').val('');
                        var oTxt02 = $(this).siblings('.text_02').val('');
                    }
                });
                $('.btn_cancel').live('click', function () {
                    $(this).parent().hide();
                    $(this).parent().siblings('.take_addClass').show();
                    var oTxt01 = $(this).siblings('.text_01').val('');
                    var oTxt02 = $(this).siblings('.text_02').val('');
                });
                html += '</div>';

                $(this).parent().parent().siblings('.takeC').append(html);


                /*生成出来的班级多了，选项卡切换*/
                function tab_new() {
                    var nav = $('.takeC .tackL');
                    var nbox = $('.takeC .overJs');
                    nav.click(function () {
                        nav.next("div").hide();
                        $(this).next("div").show();
                        return false;
                    })
                }

                tab_new();


                //控制每个三角的left
                _this_left = $('.takeC').children('.b_jq_number').eq(_this_index).offset().left - $(this).parents('.clearfix').children('.takeL').offset().left - $(this).parents('.clearfix').children('.takeL').width() + ($('.takeC').children('.b_jq_number').eq(_this_index).width() / 2 - 14);

                //$('.tackL').css('backgroundColor','red');


                $('.takeC').children('.b_jq_number').eq(_this_index).find('.u_tran_t').css('left', +_this_left);

                _this_index++;

            }
            var textVal = $(this).siblings('.text_js').val('');
            $(this).parent().hide();
            $(this).parent().siblings('.gradeJs').show()
        });
        $('.no_ok').bind('click', function () {
            $(this).parent().hide();
            $(this).parent().siblings('.gradeJs').show();
        });


    }
    add();

    function edit_tab() {
        var oTab = $('.edit_list li');
        var aDiv = $('.editBox .edit_Div');
        oTab.click(function () {
            oTab.removeClass('beforeOne');
            $(this).addClass('beforeOne');
            aDiv.eq($(this).index()).show().siblings().hide();


        })
    }

    edit_tab();


});
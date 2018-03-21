define(["popBox", 'jquery_sanhai', 'sanhai_tools', 'jqueryUI'], function (popBox, jquery_sanhai, sanhai_tools) {

    //标记答题卡
    $('input:radio').click(function () {
        var pa = $(this).parents('.quest');
        var p_id = pa.attr('id');
        $('#' + p_id + '_clip').removeClass('state6');
        $('#' + p_id + '_clip').addClass('state2');

    });

    $('input:checkbox').click(function () {
        var pa = $(this).parents('.quest');
        if (pa.size() > 1) {
            pa = $(this).parents('.sub_quest');
        }
        var p_id = pa.attr('id');
        var chked_num = pa.find(':checked').size();
        if (chked_num != 0) {
            $('#' + p_id + '_clip').removeClass('state6');
            $('#' + p_id + '_clip').addClass('state2');
        }
        else {
            $('#' + p_id + '_clip').removeClass('state2');
            $('#' + p_id + '_clip').addClass('state6')
        }
        ;
    });


    //fixed答题卡
    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
        var testpaperArea = $('.testpaperArea');
        var answer_card = $('#answer_card');
        var answer_card_h = answer_card.height();
        var homwork_info;//答题卡之前的元素
        if ($(".homwork_ladder")[0]) {
            homwork_info = $(".homwork_ladder");
        } else {
            homwork_info = $(".homwork_info");
        }
        var homwork_info_top = homwork_info.offset().top + homwork_info.height() + 20;
        if (scrollTop > homwork_info_top) {
            answer_card.addClass('answer_card_fixed');
            testpaperArea.css('marginTop', answer_card_h);
        }
        else {
            answer_card.removeClass('answer_card_fixed');
            testpaperArea.css('marginTop', 18)
        }
    });


    //显示隐藏答题卡
    (function () {
        var open = false;
        var homwork_info;//答题卡之前的元素
        if ($(".homwork_ladder")[0]) {
            homwork_info = $(".homwork_ladder");
        } else {
            homwork_info = $(".homwork_info");
        }
        var homwork_info_top = homwork_info.offset().top + homwork_info.height() + 17;
        $('#open_cardBtn').click(function () {
            var _this = $(this);
            if (open == false) {
                $('#answer_card').addClass('answer_card_show');
                _this.html('收起<i></i>');
                open = true;
            }
            else {
                $('#answer_card').removeClass('answer_card_show');
                _this.html('展开<i></i>');
                open = false;
                if ($('#answer_card').hasClass("answer_card_fixed")) {
                    $(window).scrollTop(homwork_info_top);
                }
            }
        })
    })();

    //radio checkbox效果
    sanhai_tools.input();

    //查看解析答案按钮
    $('.show_aswerBtn').click(function () {
        var _this = $(this);
        var pa = _this.parents('.quest');
        pa.toggleClass('A_cont_show');
        _this.toggleClass('icoBtn_close');
        if (pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
        else _this.html('查看答案解析 <i></i>');
    });

    //提交作业操作
    $('#answerSubmit .btn').click(function () {
        $form = $("#form-homework");
        $.post($form.attr('action'), $form.serialize(), function (data) {
            if (data.success) {
                popBox.successBox(data.message);
                setTimeout(function () {
                    location.reload();
                }, 2000);

            }
        });
    });
    $('#img_add').css('minWidth',$('#img_add').children().length * 198 + 'px');
    $('#answer').css({
        top: $(document).scrollTop() + 0 + 'px',
        right: '9px'
    });
    $(window).resize(function () {
        $('#answer').css({
            top: $(document).scrollTop() + 0 + 'px',
            right: '9px'
        });
    });
    $(window).scroll(function () {
        $('#answer').css({
            top: $(document).scrollTop() + 0 + 'px',
            right: '9px'
        });
    });
    //var answer_type = true;
    //var answer_height = $('#answerDetails').height();
    //$(document).on('click', '#answerDetails', function (event) {
    //    event.stopPropagation();
    //}).on('click', '#answer', function () {
    //    answer_type ?
    //        $('#answerDetails').css({
    //            'display': 'block',
    //            'height': '40px',
    //            'width': '0',
    //            'border': '1px solid #10ade5'
    //        }).stop().animate({'width': '858px'}, 500, function () {//border:1px solid #10ade5;
    //            $('#answerDetails').stop().animate({'height': answer_height + 'px'});
    //            answer_type = false;
    //        }) : $('#answerDetails').css({
    //        'width': '858px',
    //        'height': answer_height + 'px'
    //    }).stop().animate({'height': '40px'}, 500, function () {
    //        $('#answerDetails').stop().animate({'width': '0'}, 500, function () {
    //            $('#answerDetails').css('border', '0');
    //        });
    //        answer_type = true;
    //    });
    //})

});
define(["popBox",'userCard','jquery_sanhai','jqueryUI'],function(popBox,userCard,jquery_sanhai){

    //fixed答题卡
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        var testpaperArea=$('.testpaperArea');
        var answer_card=$('#answer_card');
        var answer_card_h=answer_card.height();
        var homwork_info;//答题卡之前的元素
        if($(".homwork_ladder")[0]){
            homwork_info=$(".homwork_ladder");
        }else{
            homwork_info=$(".homwork_info");
        }
        var homwork_info_top=homwork_info.offset().top + homwork_info.height() + 20;
        if(scrollTop>homwork_info_top){
            answer_card.addClass('answer_card_fixed');
            testpaperArea.css('marginTop',answer_card_h);
        }
        else{
            answer_card.removeClass('answer_card_fixed');
            testpaperArea.css('marginTop',18)
        }
    });



    //显示隐藏答题卡
    (function(){
        var open=false;
        var homwork_info;//答题卡之前的元素
        if($(".homwork_ladder")[0]){
            homwork_info=$(".homwork_ladder");
        }else{
            homwork_info=$(".homwork_info");
        }
        var homwork_info_top=homwork_info.offset().top + homwork_info.height() + 17;
        $('#open_cardBtn').click(function(){
            var _this=$(this);
            if(open==false){
                $('#answer_card').addClass('answer_card_show');
                _this.html('收起<i></i>');
                open=true;
            }
            else{
                $('#answer_card').removeClass('answer_card_show');
                _this.html('展开<i></i>');
                open=false;
                if($('#answer_card').hasClass("answer_card_fixed")){
                    $(window).scrollTop(homwork_info_top);
                }
            }
        })
    })();

    function leftPicCal(){
        var liSize=$('.upImgFile').find('li').size();
        $('.uploadFileBtn').find('span').html(21-liSize);
        if(liSize > 20){
            $('.addResult').hide();
        }else{
            $('.addResult').show();
        }
    }

//拖拽排序
    $('.fixedImage ul').sortable({items:"li:not(.disabled)"});

    $(document).off('click','.delBtn').on('click','.delBtn',function(){
        $(this).parent().remove();
        leftPicCal();
    });
    //幻灯
    $('#slide').slide({'width':1151});
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
    //            'display':'block',
    //            'height': '40px',
    //            'width': '0',
    //            'border': '1px solid #10ade5'
    //        }).stop().animate({'width': '858px'}, 500, function () {//border:1px solid #10ade5;
    //            $('#answerDetails').stop().animate({'height': answer_height + 'px'});
    //            answer_type = false;
    //        }) : $('#answerDetails').css({
    //        'width': '858px',
    //        'height': answer_height+'px'
    //    }).stop().animate({'height': '40px'}, 500, function () {
    //        $('#answerDetails').stop().animate({'width': '0'}, 500, function () {
    //            $('#answerDetails').css('border', '0');
    //        });
    //        answer_type = true;
    //    });
    //})
});
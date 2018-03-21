define(["popBox", 'userCard','FlexoCalendar', 'jquery_sanhai', 'jqueryUI','validationEngine','validationEngine_zh_CN'], function (popBox,userCard) {
    $('form').validationEngine({
        validateNonVisibleFields:true,
        promptPosition:"centerRight",
        maxErrorsPerField:1,
        showOneMessage:true,
        addSuccessCssClassToField:'ok'
    });
    function alert__() {
        $("#confirm_integral").css({
            'display': 'block',
            'top': $(window).scrollTop() + (($(window).height() - $("#confirm_integral").height()) / 2),
            'left': ($(window).width() - $("#confirm_integral").width()) / 2,
            'z-index':'100'
        });
        $('body').append('<div id="alert_bg"  class="alert_bg" style="z-index:99;width:100%;height:'+$(document).height()+'px;position:absolute;top:0;left:0;background:#666;opacity: .5;filter:Alpha(Opacity=50);"></div>');
        $('#box_name').html(arguments[0]);
        $('#num').html(arguments[1]);
        $('#confirm').attr('data-id', arguments[2]);
        //$('#goodsId').attr('value', arguments[2]);
        return false;
    }

    $('.btn40').live('click', function () {
        var _this = $(this);
        var content = _this.parent().parent().parent().attr('data-content');
        var content_id = _this.parent().parent().parent().attr('data-content-id');
        var id = _this.parent().parent().parent().attr('data-id');


        alert__(content, content_id, id);
    });

    //确定兑换
    $('#confirm').click(function () {

        var goodsId = $(this).attr('data-id');
        var contact = $('.contact').val();
        var contactPhone = $('.contactPhone').val();
        var address = $('.address').val();

        if( $('.contact').validationEngine('validate')&& $(' .contactPhone ').validationEngine('validate') && $('.address').validationEngine('validate') ){
            $.post('/ajax/jf-exchange', {goodsId: goodsId,contact:contact,contactPhone:contactPhone,address:address}, function (data) {

                if (data.success) {
                    popBox.successBox(data.message);
                    setTimeout("window.location.reload()", 600);
                } else {
                    popBox.errorBox(data.message);
                }

            });
        }

    });


    $('#cancel,#confirm_integral_header i').live('click', function () {
        $('#confirm_integral').css('display', 'none');
        $('#alert_bg').remove();
    });
    $(window).keyup(function (event) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 27) {
            $('#alert_bg').remove();
            $('#confirm_integral').css('display', 'none');
        }
    });

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
});
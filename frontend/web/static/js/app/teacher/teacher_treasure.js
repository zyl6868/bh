define(["popBox",'userCard','dialogBox', 'FlexoCalendar', 'jquery_sanhai', 'jqueryUI','validationEngine','validationEngine_zh_CN'], function (popBox, userCard, dialogBox) {
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
        $('#confirm').attr('monthAccountId', arguments[3]);
        //$('#goodsId').attr('value', arguments[2]);
        return false;
    }
    //去兑换商品
    $('.btn40').live('click', function () {
        var _this = $(this);
        var content = _this.parent().parent().parent().attr('data-content');
        var content_id = _this.parent().parent().parent().attr('data-content-id');
        var id = _this.parent().parent().parent().attr('data-id');
        var isPrivilege = _this.parent().parent().parent().attr('isPrivilege');
        var monthAccountId = $("#myXuemi").attr('monthAccountId');

        $.get('/ajax/user-privilege', {}, function (result) {

            if(result.success){
                if(result.data == 0 && isPrivilege == 1){
                    dialogBox({
                        title: '周周通特权',
                        content: '<p class="tc">成为周周通特权用户可兑换全部商品！</p>',
                        TrueBtn: {
                            name: '知道了'
                        }
                    });
                }else{
                    alert__(content, content_id, id,monthAccountId);
                }
            }

        });

    });

    //确定兑换
    $('#confirm').click(function () {

        var monthAccountId = $(this).attr('monthAccountId');
        var goodsId = $(this).attr('data-id');
        var contact = $('.contact').val();
        var contactPhone = $('.contactPhone').val();
        var address = $('.address').val();
        var total = $("#myXuemi").attr('total');
        var num  = $('#num').html();
        if(total == 0 || parseInt(total) < parseInt(num) ){
            popBox.errorBox('学米不足');
            return false;
        }

        if( $('.contact').validationEngine('validate') && $('.address').validationEngine('validate') && $(' .contactPhone ').validationEngine('validate')){
            $.post('/ajax/xuemi-exchange', {goodsId: goodsId,monthAccountId:monthAccountId,contact:contact,contactPhone:contactPhone,address:address}, function (data) {
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
    (function () {
        var overTime, outTime;
        $('.icon_card').live({
            mouseover: function () {
                clearTimeout(overTime);
                var _this = $(this);
                overTime = setTimeout(function () {
                    var userID = _this.attr('creatorID');
                    var source = _this.attr('source');
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
                var card = $('.userCard');

                function removeCard() {
                    outTime = setTimeout(function () {
                        card.remove();
                    }, 60);
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
    })();

    /*结转学米*/
    $(document).on('click','.convert',function () {
        var monthAccountId = $(this).attr('monthAccountId');
        var month = parseInt($(this).prev().prev().prev().html());

        dialogBox({
            title: '结转学米',
            content: '<p class="tc">确定结转'+month+'月学米到结转账户么？</p><p class="tc">结转后总学米只可兑换结转商品</p>',
            TrueBtn: {
                name: '确定结转',
                fn: function () {$('#mask').remove();
                    $.post('/teacher/mytreasure/convert-xuemi',{monthAccountId:monthAccountId},function (result) {
                        if(result.success){
                            popBox.successBox(result.message);
                            setTimeout("window.location.reload()", 600);
                        }else{
                            popBox.errorBox(result.message);
                        }

                    });
                }
            },
            FalseBtn: {
                name: '取消'
            }
        });

    })
});
define(['popBox','jquery_sanhai','jqueryUI','validationEngine','validationEngine_zh_CN'],function(popBox,jquery_sanhai){
    $('#homework_form').validationEngine();
    //弹框
    function bskt_conf_hmwk_Box(){
        $('#pointTree').tree();

        //初始化弹框
        $('.popBox').dialog({
            autoOpen: true,
            width:840,
            modal: true,
            resizable:false,
            close:function(){$(this).hide()}
        });

        $('#bskt_conf_hmwk_Box .cancelBtn').click(function(){
            $('#bskt_conf_hmwk_Box').dialog('close');
        });

        //向右侧添加节点
        $('#add_custom_btn').click(function(){
            var sel_item=$('.pointTree .ac');
            if(sel_item.size()>0) {
                var txt = sel_item.text();
                var id = sel_item.attr('data-value');
                if ($('#custom_sel_list #' + id).size() != 1) {
                    $('#custom_sel_list').append('<li id="' + id + '">' + txt + '</li>');
                }
                else {
                    popBox.errorBox('该章节已添加!');
                }
            }else{
                popBox.errorBox("请选择章节");
            }
        });

        //选择右侧"已选"项
        $('.cha_r').on('click','#custom_sel_list li',function(){
            $(this).addClass('ac').siblings().removeClass('ac');
        });

        $('#del_custom_btn').click(function(){
            if($('#custom_sel_list .ac').size()>0){
                var id=$('#custom_sel_list .ac').attr('id');
                $('#'+id).remove();
            }
            else{ popBox.errorBox('请选择要删除项目!') }
        })


    }
    function bskt_conf_hmwk_Show(cartId){
        $.get('/basket/get-basket-num',{cartId:cartId},function (result) {
            if(result.success == false){
                popBox.errorBox(result.message);
                return false;
            }

            if($('#bskt_conf_hmwk_Box').hasClass('ui-dialog-content')){
                $('#bskt_conf_hmwk_Box').dialog('open');
            }else{
                bskt_conf_hmwk_Box();
            }

        })

    }


    //显示确认菜单
    $('#conformBtn').click(function(){

        if($('.join_basket').size()==0){
          popBox.errorBox('选题篮不能为空');
            return ;
        }
        var questList =$('.quest');
        var dataArray=[];
        questList.each(function(index,el){
            var orderNumber=$(el).find('.del_question').attr('orderNumber');
            var cartQuestionId=$(el).find('.pd25').attr('cartQuestionId');
            var data={'cartQuestionId':cartQuestionId,'orderNumber':orderNumber};
            dataArray.push(data);
        });
        $.post('/basket/save-basket-order',{dataArray:dataArray},function(result){

        });
        $('#conformList').show();
        return false;
    });
    //显示弹框
    $('#conformList a').click(function(){
        var popBoxID=$(this).attr('data-popBox');
        var cartId=$(this).attr('cartId');
        switch(popBoxID){
            case "hmwk":
            bskt_conf_hmwk_Show(cartId);

            break;
        }
        $('#conformList').hide();
    });



    //查看解析答案按钮
	$('.show_aswerBtn').click(function(){
        var _this=$(this);
        var pa=_this.parents('.quest')
        pa.toggleClass('A_cont_show');
        _this.toggleClass('icoBtn_close');
        if(pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
        else _this.html('查看答案解析 <i></i>');
    });
	

    $(".del_question").click(function(){
        var _this = $(this);

        var cartQuestionId= _this.parents('.quest').find('.pd25').attr('cartQuestionId');
        popBox.confirmBox('真的要删除该题吗?',function() {
            $.get("/basket/del-question", {cartQuestionId: cartQuestionId}, function (data) {
                if (data.success) {
                    popBox.successBox(data.message);
                    _this.parents('.quest').remove();
                    var count_quetion = $('.count_question span').text() - 1;
                    $('.count_question span').html(count_quetion);
                    for(var i = 0;i < count_quetion;i++){
                        $('.pannel_l').eq(i).children('b').html(i+1);
                    }
                }else {
                    popBox.errorBox(data.message);
                }
            })
        })
    });


    //选题蓝上移下移
    $('.move_up_btn,.move_down_btn').click(function(){
        var originQuest = $(this).parents('.quest');
        var prevQuest = originQuest.prev();
        var nextQuest = originQuest.next();
        var originTitle = originQuest.children('.quest_title');
        var prevTitle = prevQuest.children('.quest_title');
        var nextTitle = nextQuest.children('.quest_title');
        var originPlace = originQuest.children('.pd25');
        var prevPlace = prevQuest.children('.pd25');
        var nextPlace = nextQuest.children('.pd25');
        if(prevQuest[0] && ($(this).attr('class') == 'move_up_btn')){
            originQuest.css('z-index',1);
            prevQuest.css('z-index',0);
            originQuest.animate({top:'-'+prevQuest.height()+'px'},'slow',function(){
                originPlace.insertAfter(prevTitle);
                prevPlace.insertAfter(originTitle);
            });
            originQuest.animate({top:0},0);
            prevQuest.animate({top:'+'+originQuest.height()+'px'},'slow');
            prevQuest.animate({top:0},0);
        }else if(nextQuest[0] && ($(this).attr('class') == 'move_down_btn')){
            originQuest.css('z-index',1);
            nextQuest.css('z-index',0);
            originQuest.animate({top:'+'+nextQuest.height()+'px'},'slow',function(){
                originPlace.insertAfter(nextTitle);
                nextPlace.insertAfter(originTitle);
            });
            originQuest.animate({top:0},0);
            nextQuest.animate({top:'-'+originQuest.height()+'px'},'slow');
            nextQuest.animate({top:0},0);
        }
    });
    (function(){
        var allQuest = $('.quest').not($('.sub_quest'));
        var firstQuest = allQuest.first();
        var lastQuest = allQuest.last();
        firstQuest.find('.move_up_btn').parent('span').addClass('dis');
        lastQuest.find('.move_down_btn').parent('span').addClass('dis');
    })();


});

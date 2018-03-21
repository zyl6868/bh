define(["popBox",'userCard','jquery_sanhai','jqueryUI'],function(popBox,userCard,jquery_sanhai){
    //$('#slide').slide({'width':821});
    $('#slide').slide({'width':821,'Clip_width':193});
    $(".userList dl").click(function(){
        $(this).addClass("cur").siblings().removeClass("cur");
        $(".original").removeClass("show_original");
    });


    //批改状态
    $('.cor_btn a').click(function(){
        var cls_name=$(this).attr('class');
        function chk(cls_name){
            $(".userList .cur em").removeClass().addClass(cls_name+"_btn");
            //$(".userList .cur").removeClass('cur').next().addClass('cur');
        }
        var  homeworkAnswerID=$('#homeworkAnswerID').val();
        switch(cls_name){
            case "check":
                correctLevel=4;
                chk("check");
                break;
            case "half":
                correctLevel=3;
                chk("half");
                break;
            case "wrong":
                correctLevel=2;
                chk("wrong");
                break;
            case "bad":
                correctLevel=1;
                chk("bad");
                break;
        }
        $.post("/class/ajax-pic-correct",{correctLevel:correctLevel,homeworkAnswerID:homeworkAnswerID},function (result){
            if (result.success == false) {
                popBox.errorBox('更新失败');
            }else{
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
                window.open(aUrl,'_self');
            }
        });

    });


});
define(["popBox",'jquery_sanhai','validationEngine','validationEngine_zh_CN','jqueryUI'],function(popBox,jquery_sanhai,validationEngine,validationEngine_zh_C){
    $(document).on('click','.delBtn',function(){
        $(this).parent().remove();
    });

    $('#form1').validationEngine();
    $('.imgFile ul').sortable({items:"li:not(.disabled)"});

    $('.delBtn').live('click',function(){
        $('.more').css('display','block');
    });
    //防止表单重复提交
    var type=false;
    $('[type=submit]').live('click',function(){
        if(type){
            return false;
        }
        setTimeout(function(){
            type=false;
        },1000);
        type=true;
        return true;
    });

    $('#form1').submit(function(){
        var uploadedLiSize=$('.imgFile').find('li').size();
        var briefOfEvent=$('[name="picurls[briefOfEvent]"]').val();
        if($.trim(briefOfEvent)==''&&uploadedLiSize==1){
            popBox.errorBox('请填写描述或者上传图片');
            return false;
        }
    });
});
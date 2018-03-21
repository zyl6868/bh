define(["popBox",'jquery_sanhai','validationEngine','validationEngine_zh_CN','jqueryUI'],function(popBox,jquery_sanhai,validationEngine,validationEngine_zh_C){


//添加大事记验证
    $('#event_form').validationEngine();
    $('.upImgFile ul').sortable({items:"li:not(.disabled)"});
    //添加和编辑大事记可以继续添加的剩余图片的计算
    function leftPicCal(){
        var liSize=$('.upImgFile').find('li').size();
        $('.uploadFileBtn').find('span').html(21-liSize);
        if(liSize==21){
            $('.uploadFileBtn').hide();
        }else{
            $('.uploadFileBtn').show();
        }
    }

   leftPicCal();
    $('#event_form').submit(function(){
        var uploadedLiSize=$('.upImgFile').find('li').size();
        var briefOfEvent=$('[name="SeClassEvent[briefOfEvent]"]').val();
        if($.trim(briefOfEvent)==''&&uploadedLiSize==1){
            popBox.errorBox('请填写描述或者上传图片');
            return false;
        }
    });
    //删除按钮
    //$('.delBtn').live('click',function(){
    //    $(this).parent().remove();
    //    leftPicCal();
    //});
    $('.ui-sortable').on('click','.delBtn',function(){
        var self = $(this);
        self.parent().remove();
        leftPicCal();
    });
    $('#memor_name').placeholder({'value':'请输入标题'});
    return {leftPicCal:leftPicCal}

});
define(['jquery_sanhai','jqueryUI'],function(jquery_sanhai){
    //单选
    $("#classes_sel_list").sel_list('single',function(){
    });
    $("#hard_list").sel_list('single',function(){
    });

    //打开课程列表
    $('#show_sel_classesBar_btn').click(function(){
        $(".sel_classesBar").slideDown();
        return false;
    });

    //选择学科
    $("#sel_classesBar").sel_list('single');
    $("#sel_classesBar dd").click(function(){
        $('#sel_classes h5').text($(this).text());
        $("#sel_classesBar").hide();
    });




    //目录树
    $('.pointTree').tree();




    //查看解析答案按钮
 function answerShowAndHide(){

     //查看解析答案按钮
     $('.show_aswerBtn').click(function(){
         var _this=$(this);
         var pa=_this.parents('.quest');
         pa.toggleClass('A_cont_show');
         _this.toggleClass('icoBtn_close');
         if(pa.hasClass('A_cont_show')){_this.html('收起答案解析 <i></i>');}
         else{_this.html('查看答案解析 <i></i>');}
     })
 }
    return {
        answerShowAndHide:answerShowAndHide
    }



});
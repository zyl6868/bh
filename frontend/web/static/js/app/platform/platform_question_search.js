define(['jquery_sanhai','jqueryUI'],function(jquery_sanhai){
    $('#mainSearch').placeholder({
        'value':'   请输入关键字.....',
        left: 15,
        top: 4});
    $('#show_sel_classesBar_btn').click(function(){
        $(".sel_classesBar").slideDown();
        return false;
    });

});
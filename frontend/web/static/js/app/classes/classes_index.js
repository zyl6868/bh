define(["popBox",'jquery_sanhai','jqueryUI','fancybox','jQuery_cycle'],function(popBox,jquery_sanhai,fancybox){


    $('#classes_AD_banner_list').cycle({
        fx:'scrollLeft',
        pager:'.slideBtn',
        showSlideNum:true,
        speed:1000,
        timeout:4000
    });


    $(".fancybox").die().fancybox();
    $('.slider-box').slide_min({
        autoplay:0,
        defaultNum:3
    });

    //换一换
    $('#changeBrand').live('click', function () {
        var classId= $(this).attr("data-classId");
        $.get('/class/change-new', {classId:classId}, function (data) {
             $('#attentionBrand').html(data);
        })
    });

    $(".centerBox").hover(
        function() {
            $(this).addClass('centerBox_hover');
        },
        function() {
            $(this).removeClass('centerBox_hover');
        }
    )

});
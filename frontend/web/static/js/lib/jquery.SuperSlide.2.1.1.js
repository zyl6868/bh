$(function() {
    (function() {
        var fistChildWidth = $(".slider-box li:eq(0)").width();
        var marginR = $(".slider-box li:eq(0)").css("margin-right");
        var ul = $(".slider-box ul");
        var items = $(".slider-box ul li");
        var maxsize = items.size();
        var index = 0;
        var maxvis = 7;
        var itemWidth = fistChildWidth + parseInt(marginR, 10);

        $(".slider-box li:eq(0)").addClass("active");
        $(".slider-box ul").width(maxsize * itemWidth+100);

        function scroll(index) {
            ul.animate({
                "left": index * itemWidth * -1
            }, 300);
        }
        $(".slider-box a.prev").click(function() {
            if (index > 0) {
                index--;
                $(".slider-box ul li.active").prev().addClass("active").siblings().removeClass("active");
                scroll(index);
            } else {
                $(".slider-box ul li.active").prev().addClass("active").siblings().removeClass("active");
            }
        });
        $(".slider-box a.next").click(function() {
            if (index + maxvis < maxsize) {
                index++;
                $(".slider-box ul li.active").next().addClass("active").siblings().removeClass("active");
                scroll(index);
            } else {
                $(".slider-box ul li.active").next().addClass("active").siblings().removeClass("active");
            }
        });
    })();
});

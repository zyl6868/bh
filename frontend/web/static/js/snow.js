(function($){
    $.fn.snow = function(options){
        var $flake = $('<div class="snowbox" />').css({'position': 'absolute','z-index':'9999', 'top': '-50px'}).html('&#10052;'),
            documentHeight = 1050,
            documentWidth	= $(document).width(),
            defaults = {
                minSize	: 8,
                maxSize	: 15,
                newOn	: 1000,
                flakeColor	: ["#FFDA65", "#00AADD", "#aaaacc", "#F5A7E0", "#8989F5", "#DE5FF0", "#3BD31A", "#08E0E5"] /* 此处可以定义雪花颜色，若要白色可以改为#FFFFFF */
            },
            options	= $.extend({}, defaults, options);
        var randowcolor = defaults.flakeColor;
        function random(range){
            var rand = Math.floor(range * Math.random());
            return rand;
        }
        var interval= setInterval( function(){
            var startPositionLeft = Math.random() * documentWidth-100,
                startOpacity = 0.5 + Math.random(),
                sizeFlake = options.minSize + Math.random() * options.maxSize,
                endPositionTop = documentHeight - 200,
                endPositionLeft = startPositionLeft - 300 + Math.random() * 300,
                durationFall = documentHeight * 10 + Math.random() * 5000;
            $flake.clone().appendTo('body').css({
                left: startPositionLeft,
                opacity: startOpacity,
                'font-size': sizeFlake,
                color: options.flakeColor[random(randowcolor.length)]
            }).animate({
                top: endPositionTop,
                left: endPositionLeft,
                opacity: 0.2
            },durationFall,'linear',function(){
                $(this).remove()
            });
        }, options.newOn);
    };
})(jQuery);
$(function(){
    $.fn.snow({
        minSize: 8, /* 定义雪花最小尺寸 */
        maxSize: 15,/* 定义雪花最大尺寸 */
        newOn: 500  /* 定义密集程度，数字越小越密集 */
    });
});
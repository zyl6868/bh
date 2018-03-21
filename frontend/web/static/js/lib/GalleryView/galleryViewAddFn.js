$(function(){
    $('#myGallery').galleryView({
        transition_speed: 0, 		//INT - duration of panel/frame transition (in milliseconds)
        transition_interval: 0, 		//INT - delay between panel/frame transitions (in milliseconds)
        easing: 'swing', 				//STRING - easing method to use for animations (jQuery provides 'swing' or 'linear', more available with jQuery UI or Easing plugin)
        show_panels: true, 				//BOOLEAN - flag to show or hide panel portion of gallery
        show_panel_nav: true, 			//BOOLEAN - flag to show or hide panel navigation buttons
        enable_overlays: false, 			//BOOLEAN - flag to show or hide panel overlays

        panel_width: 715, 				//INT - width of gallery panel (in pixels)
        panel_height: 470, 				//INT - height of gallery panel (in pixels)
        panel_animation: 'fade', 		//STRING - animation method for panel transitions (crossfade,fade,slide,none)
        panel_scale: 'fit', 			//STRING - cropping option for panel images (crop = scale image and fit to aspect ratio determined by panel_width and panel_height, fit = scale image and preserve original aspect ratio)
        overlay_position: 'top', 	//STRING - position of panel overlay (bottom, top)
        pan_images: true,				//BOOLEAN - flag to allow user to grab/drag oversized images within gallery
        pan_style: 'drag',				//STRING - panning method (drag = user clicks and drags image to pan, track = image automatically pans based on mouse position
        pan_smoothness: 15,				//INT - determines smoothness of tracking pan animation (higher number = smoother)
        start_frame: 1, 				//INT - index of panel/frame to show first when gallery loads
        show_filmstrip: true, 			//BOOLEAN - flag to show or hide filmstrip portion of gallery
        show_filmstrip_nav: true, 		//BOOLEAN - flag indicating whether to display navigation buttons
        enable_slideshow: false,			//BOOLEAN - flag indicating whether to display slideshow play/pause button
        autoplay: false,				//BOOLEAN - flag to start slideshow on gallery load
        show_captions: true, 			//BOOLEAN - flag to show or hide frame captions
        filmstrip_size: 4, 				//INT - number of frames to show in filmstrip-only gallery
        filmstrip_style: 'scroll', 		//STRING - type of filmstrip to use (scroll = display one line of frames, scroll filmstrip if necessary, showall = display multiple rows of frames if necessary)
        filmstrip_position: 'bottom', 	//STRING - position of filmstrip within gallery (bottom, top, left, right)
        frame_width: 164, 				//INT - width of filmstrip frames (in pixels)
        frame_height: 80, 				//INT - width of filmstrip frames (in pixels)
        frame_opacity: 0.5, 			//FLOAT - transparency of non-active frames (1.0 = opaque, 0.0 = transparent)
        frame_scale: 'crop', 			//STRING - cropping option for filmstrip images (same as above)
        frame_gap: 3, 					//INT - spacing between frames within filmstrip (in pixels)
        show_infobar: true,				//BOOLEAN - flag to show or hide infobar
        infobar_opacity: 1				//FLOAT - transparency for info bar
    });
    //图片工具
    $('#slide').hover(
        function () {
            if ($(this).children('.slideTools').length == 0) {
                $(this).append('<div class="slideTools"><i class="rotateLeft"></i><i class="rotateRight"></i><i class="amplify"></i></div>');
                $('.slideTools').css('zIndex', '101');
            }
        },
        function () {
            $('.slideTools').remove();
        }
    );
    /**
     * 图片附加放大旋转功能 向下兼容IE6
     */
    function imgFn() {
        this.rotateDegNum = 0;
        //判断浏览器是否支持 transform 如果不支持使用 Matrix
        //数组下表4为判断布尔值 true 支持
        this.rotateDegArr = (function () {
            var testDiv = document.createElement("div").style;
            var transformArr = ["transform", "MozTransform", "webkitTransform", "OTransform", "msTransform"];
            for (var i = 0, len = transformArr.length; i < len; i++) {
                if (transformArr[i] in testDiv) {
                    return true;
                }
            }
            return false;
        })() ? [{'transform': 'rotate(0deg)'},
            {'transform': 'rotate(90deg)'},
            {'transform': 'rotate(180deg)'},
            {'transform': 'rotate(270deg)'},
            true]
            : [{'filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=4,SizingMethod="clip to original")'},
            {'filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=1,SizingMethod="clip to original")'},
            {'filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=2,SizingMethod="clip to original")'},
            {'filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=3,SizingMethod="clip to original")'},
            false];
        this.initialOutLineHeight = $('.gv_galleryWrap').height();
        this.initialParentsHeight = $('.gv_panelWrap').height();
        this.magnifierType = true;
        this.itheTop = 105;
        this.itheLeft = 105;
        this.imgRotateHeight = 300;//旋转后的高度*旋转前的宽度
        this.imgGapHeight = 150;//留白高度
    }

    /**
     * 判断图片是否加载完成
     * @param url 需判断的URL
     * @param callback 回调
     */
    imgFn.prototype.loadImage = function (url, callback) {
        var img = new Image();
        img.src = url;
        if (img.complete) {
            callback.call(img);
            return;
        }
        img.onload = function () {
            callback.call(img);
        };
    };
    /**
     * 旋转角度的当前状态
     * @num 向左传 -1 向右传 1
     * @return style对象
     */
    imgFn.prototype.changeRotateDegNum = function (num) {
        if (num == 'init') {
            this.rotateDegNum = 0;
            this.magnifierType = true;
        } else {
            this.rotateDegNum += num;
            if (this.rotateDegNum > 3) {
                this.rotateDegNum = 0;
            } else if (this.rotateDegNum < 0) {
                this.rotateDegNum = 3;
            }
        }
        return this.rotateDegArr[this.rotateDegNum];
    };
    /**
     * 旋转角度
     * @num 向左传 -1 向右传 1
     */
    imgFn.prototype.changeRotate = function (num) {
        var that = this,
            style = this.changeRotateDegNum(num),
            $img = $("#slide img"),
            imgHeightChange = (function () {//确定旋转基准点  和旋转后宽比高多出的距离
                if (that.rotateDegNum == 0 || that.rotateDegNum == 2) {
                    if (that.rotateDegArr[4]) {
                        $img.css('transformOrigin', '50% 50%');
                    }
                    return 0;
                } else if (that.rotateDegNum == 1) {
                    var rotateOrigin;
                    if (that.rotateDegArr[4]) {
                        rotateOrigin = ($img.width() / 2 - ($img.width() - $img.height()) / 4) + 'px '
                            + ($img.height() / 2 + ($img.width() - $img.height()) / 4) + 'px';//计算旋转偏移量
                        $img.css('transformOrigin', rotateOrigin);
                    }
                } else {
                    if (that.rotateDegArr[4]) {
                        rotateOrigin = ($img.width() / 2 + ($img.width() - $img.height()) / 4) + 'px '
                            + ($img.height() / 2 + ($img.width() - $img.height()) / 4) + 'px';//计算旋转偏移量
                        $img.css('transformOrigin', rotateOrigin);
                    }
                }
                return $img.width() - $img.height();
            })(),//旋转后高度变化的值
            outLineHeight = this.initialOutLineHeight + imgHeightChange,
            parentsHeight = this.initialParentsHeight + imgHeightChange;
        //更改 GallerView 组件大图部分的style
        $('.gv_galleryWrap').height(outLineHeight + 'px');
        $('.gv_gallery').height(outLineHeight + 'px');
        $('.gv_panelWrap').height(parentsHeight + 'px');
        $('.gv_panel').height(parentsHeight + 'px');
        $img.css(style);
    };
    window.imgR = new imgFn();

    $(document).on('click', '.slideTools .rotateLeft', function () {
        imgR.changeRotate(1);
        imgR.imgLeft = parseInt($('.gv_panel img').position().left);
        imgR.imgTop = parseInt($('.gv_panel img').position().top);
    }).on('click', '.slideTools .rotateRight', function () {
        imgR.changeRotate(-1);
        imgR.imgLeft = parseInt($('.gv_panel img').position().left);
        imgR.imgTop = parseInt($('.gv_panel img').position().top);
    }).on('click', '.slideTools .amplify', function () {
        if(!imgR.magnifierType){
            $('.bigImg').remove();
            imgR.magnifierType = true;//放大镜只能点击一次
            return;
        }
        imgR.magnifierType = false;//放大镜只能点击一次
        var img = $('.gv_panel img');
        imgR.imgLeft = parseInt(img.position().left);
        imgR.imgTop = parseInt(img.position().top);
        imgR.loadImage(img.attr('src'), function () {
            $('.gv_panel').append('<span class="bigImg"></span><div class="the bigImg"><img id="bigImg" src="' + $('.gv_panel img').eq(0).attr('src') + '"></div>');
            var $bigImg = $('#bigImg');
            $('#bigImg').css(imgR.rotateDegArr[imgR.rotateDegNum]);
            var changeWidth,
                changeHeight;
            if ((imgR.rotateDegNum == 1 || imgR.rotateDegNum == 3) && !imgR.rotateDegArr[4]) {
                changeWidth = 'height';
                changeHeight = 'width';
            } else {
                changeWidth = 'width';
                changeHeight = 'height';
            }
            imgR.imgWidth = parseInt(img.css(changeWidth));
            imgR.imgHeight = parseInt(img.css(changeHeight));
            imgR.bigImg = {
                width : parseInt(img.css(changeWidth)) * 3,
                height : parseInt(img.css(changeHeight)) * 3
            };
            $bigImg.css('height', imgR.bigImg.height + 'px');
            $bigImg.css('width', imgR.bigImg.width + 'px');
        });
    });
    $(document).on('mousemove', '.gv_panel', function (e) {
        if($(".the").length == 0){
            return;
        }
        var ev = e || window.event,
            $ithe = $(".the"),
            $tthe = $(".the img");
        $ithe.css('display', 'block');
        var ot = ev.clientY - ($(".gv_panel img").offset().top - $(document).scrollTop()) - 50;
        var ol = ev.clientX - ($(".gv_panel img").offset().left - $(document).scrollLeft()) - 50;
        if (ol <= 0) {
            ol = 0;
            imgR.itheLeft = 105;
        }
        if (ot <= 0) {
            ot = 0;
            imgR.itheTop = 105;
        }
        if (imgR.rotateDegNum == 0 || imgR.rotateDegNum == 2) {
            if (ol >= imgR.imgWidth - 100) {
                ol = imgR.imgWidth - 100;
                imgR.itheLeft = -305;
            }
            if (ot >= imgR.imgHeight - 100) {
                ot = imgR.imgHeight - 100;
                imgR.itheTop = -305;
            }
        } else {
            if (ol >= imgR.imgHeight - 100) {
                ol = imgR.imgHeight - 100;
                imgR.itheLeft = -305;
            }
            if (ot >= imgR.imgWidth - 100) {
                ot = imgR.imgWidth - 100;
                imgR.itheTop = -305;
            }
        }
        $(".gv_panel span").css({'left': ol + imgR.imgLeft, 'top': ot + imgR.imgTop});
        $ithe.css({'left': ol + imgR.itheLeft + imgR.imgLeft + 'px', 'top': ot + imgR.itheTop + imgR.imgTop + 'px'});
        var bigImg = {
            width: parseInt($('#bigImg').css('width')),
            height: parseInt($('#bigImg').css('height'))
        };
        var tt = $(".gv_panel span").position().top - imgR.imgTop;
        var tl = $(".gv_panel span").position().left - imgR.imgLeft;
        var ott,oll;
        if(imgR.rotateDegArr[4]){
            if (imgR.rotateDegNum == 0 || imgR.rotateDegNum == 2) {
                ott = tt / imgR.imgHeight * imgR.bigImg.height;
                oll = tl / imgR.imgWidth * imgR.bigImg.width;
                $tthe.css({'transform': 'translateX(' + -oll + 'px)' + 'translateY(' + -ott + 'px)' + imgR.rotateDegArr[imgR.rotateDegNum].transform})
            } else if (imgR.rotateDegNum == 1){
                ott = tt / imgR.imgWidth * imgR.bigImg.width;
                oll = tl / imgR.imgHeight * imgR.bigImg.height;
                $tthe.css({'transformOrigin':'0px 0px','transform': 'translateX(' + -oll + 'px)' +
                'translateY(' + -ott + 'px)' +
                imgR.rotateDegArr[imgR.rotateDegNum].transform + 'translateY(' + -imgR.bigImg.height + 'px)'})
            } else {
                ott = tt / imgR.imgWidth * imgR.bigImg.width;
                oll = tl / imgR.imgHeight * imgR.bigImg.height;
                $tthe.css({'transformOrigin':'0px 0px','transform': 'translateX(' + -oll + 'px)' +
                'translateY(' + -ott + 'px)' +
                imgR.rotateDegArr[imgR.rotateDegNum].transform + 'translateX(' + -imgR.bigImg.width + 'px)'})
            }
        } else {
            ott = tt / imgR.imgHeight * imgR.bigImg.height;
            oll = tl / imgR.imgWidth * imgR.bigImg.width;
            $tthe.css({'left': -oll + 'px' , 'top' : -ott + 'px'});
        }
    });

    $(document).on('mouseout', '.gv_panel', function () {
        $('.gv_panel .the').hide();
    })
});
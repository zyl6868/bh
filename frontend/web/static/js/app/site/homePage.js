$(function () {
    // 存储DOM节点
    window.dom = {
        header: $('#header'),
        content: $('#content'),
        footer: $('#footer')
    };

    dom.imgList = dom.content.find('.image img');
    // 更改浏览器布局
    function resetWin() {
        window.basicHeight = $('body').height();
        dom.header.css({'line-height': basicHeight * 0.1 + 'px'});
        dom.footer.css({'line-height': basicHeight * 0.05 + 'px'});
    }

    function reset() {
        resetWin();
        // 更改图片显示效果
        dom.imgList.each(function () {
            var thisDom = $(this);
            var thisBox = thisDom.parent();
            var DomArg = {
                thisDomWidth: thisDom.width(),
                thisDomHeight: thisDom.height(),
                thisBoxWidth: thisBox.width(),
                thisBoxHeight: thisBox.height()
            };
            var thisDomScale = DomArg.thisDomWidth / DomArg.thisDomHeight;
            var thisBoxScale = DomArg.thisBoxWidth / DomArg.thisBoxHeight;
            if (thisDomScale > thisBoxScale) {
                thisDom.width('auto');
                thisDom.height('100%');
                thisBox.scrollLeft((thisDom.width() - DomArg.thisBoxWidth) / 2);
            } else if (thisDomScale < thisBoxScale) {
                thisDom.width('100%');
                thisDom.height('auto');
                thisBox.scrollTop((thisDom.height() - DomArg.thisBoxHeight) / 2);
            } else {
                thisDom.height('100%');
                thisDom.width('100%');
            }
        });

        // 页面宽度重置
        carousel.page_width = $('body').width();
        // 横向轮播图片重置
        $('#content ul').css({'margin-left': - carousel.page_width * carousel.item + 'px'})
    }

    window.onload = reset;
    // setTimeout(reset, 25);
    // 窗口变化重置布局
    $(window).resize(function () {
        reset();
    });

    // 第一图轮播 (横向轮播)

    var carousel = (function () {
        function Carousel() {
            var that = this;
            // 页面宽度初始化
            this.page_width = $('body').width();
            this.item = 0;
            this.setItem = function (newValue) {
                if (newValue > 2) {
                    newValue = 0;
                } else if (newValue < 0) {
                    newValue = 3;
                }
                this.item = newValue;
            };

            this.item = 0;
            this._start();

            $('#dots').on('click', 'li', function () {
                that.setItem($('#dots li').index($(this)));
                clearInterval(that.isInterval);
                that._mv();
                that._start();
            });
        }

        Carousel.prototype._start = function () {
            var that = this;
            that.isInterval = setInterval(function () {
                // that.item++;
                that.setItem(that.item + 1);
                that._mv();
            }, 15000)
        };
        Carousel.prototype._mv = function () {
            $('#dots li').eq(this.item).addClass('active').siblings('.active').removeClass('active');
            $('#content ul').animate({'margin-left': - this.page_width * this.item + 'px'}, 1000);
        };
        return new Carousel();
    })();

    // 纵向切换图片功能
    $('#section-btn').on('click', 'li', function () {
        var dot = $('#section-btn li');
        var item = dot.index($(this));
        dot.eq(item).addClass('on').siblings().removeClass('on');
        // 页头移动 拉动整体页面
        dom.header.animate({'margin-top': - $('body').height() * item + 'px'}, 1000)

    });

    // 二维码点击显示 / 隐藏
    $(document).on('click', '#footer i', function () {
        $('#barcode').show();
    }).on('click', function (event) {
        if (event.target.id !== 'barcodeL') {
            $('#barcode').hide();
        }
    });
});
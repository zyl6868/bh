$(function () {
    $('#status').on('click', '#status0', function () {
        $('#status i').removeClass().addClass('status0');
        $('.status_0').show();
        $('.status_1').hide();
        clearInterval(carousel.motion);
        carousel.carouselInit($('.status_0'),15000,500).roll(true);
        $('#Android').attr('href','http://a.app.qq.com/o/simple.jsp?pkgname=com.sanhai.psdapp');
        $('#ios').attr('href','https://itunes.apple.com/app/id1039730547');
    }).on('click', '#status1', function () {
        $('#status i').removeClass().addClass('status1');
        $('.status_0').hide();
        $('.status_1').show();
        clearInterval(carousel.motion);
        carousel.carouselInit($('.status_1'),15000,500).roll(true);
        $('#Android').attr('href','http://a.app.qq.com/o/simple.jsp?pkgname=com.sanhai.psdhmapp');
        $('#ios').attr('href','https://itunes.apple.com/app/id1080171116');
    });
    $('#app').on('click','#carouselL',function(){
        if(carousel.mouseType){
            carousel.roll(false,-1);
            carousel.mouseType = false;
        }
    }).on('click','#carouselR',function(){
        if(carousel.mouseType) {
            carousel.roll(false, 1);
            carousel.mouseType = false;
        }
    });
    $('#carouselNum').on('click','li',function(){
        carousel.carouselAc = $('#carouselNum li').index($(this));
        carousel.roll(false,0);
    })
    function action (){
        carousel.status.find('ul').animate({'left':-(235 * carousel.carouselAc) + 'px'},carousel.remain,function(){
            carousel.$carouselNum.find('li').eq(carousel.carouselAc).addClass('ac').siblings().removeClass('ac');
            carousel.mouseType = true;
        });
    };
    function carousel(){
        window.carousel = this;
        this.carouselNum;//轮播总数量
        this.carouselAc;//当前轮播数
        this.speed;//轮播速度
        this.remain;//停留时间
        this.mouseType = true;
    };
    carousel.prototype.carouselInit = function(ele,time,aTime) {
        this.carouselAc = 0;//当前轮播数
        this.speed = time;//轮播速度
        this.remain = aTime;//移动时间
        this.status = ele;//修改身份
        this.$carouselNum = $('#carouselNum');
        this.carouselNum = this.status.find('li').length;
        //根据手机页面产生轮播条
        var html = '<ul>';
        for (var i = 0; i < this.carouselNum; i++) {
            html += '<li></li>';
        }
        html += '</ul>';
        this.$carouselNum.html(html);
        this.$carouselNum.find('li').eq(0).addClass('ac');
        //轮播条居中
        var _carouselWidth = this.carouselNum * 55 - 49;
        this.$carouselNum.css({
            'width': function () {
                return _carouselWidth + 'px';
            },
            'left': function () {
                return (980 - _carouselWidth) / 2 + 'px';
            }
        });
        return this;
    };
    carousel.prototype.roll = function(type,num){
        if(!type){//不是通过点击进入
            clearInterval(carousel.motion);
            carousel.carouselAc += num;
            if(carousel.carouselAc >= carousel.carouselNum){
                carousel.carouselAc = 0;
            } else if(carousel.carouselAc < 0){
                carousel.carouselAc = carousel.carouselNum - 1;
            }
            action();
            type = true;
        }
        carousel.motion = setInterval(function(){
            if (type) {
                carousel.carouselAc += 1;
                if(carousel.carouselAc >= carousel.carouselNum){
                    carousel.carouselAc = 0;
                } else if(carousel.carouselAc < 0){
                    carousel.carouselAc = carousel.carouselNum;
                }
            }
            action();
        },carousel.speed);
    };
    var carousel = new carousel();
    carousel.carouselInit($('.status_0'),15000,500).roll(true);
    $(document).on('click','#footer i',function(){
        $('#barcode').show();
    }).on('click',function(event){
        if(event.target.id != 'barcodeL'){
            $('#barcode').hide();
        }
    })
});
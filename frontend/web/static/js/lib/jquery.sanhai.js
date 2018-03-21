define(['popBox','base'],function (popBox){
    (function($){
        $.fn.extend({

            //下拉菜单
            sUI_select:function(fn){
                var open=false;
                return this.each(function() {

                    var _this=$(this);
                    var title=_this.children('em');
                    var sel_list=_this.find('.sUI_selectList');
                    var sel_item=_this.find('a');
                    _this.children('em,i').click(function(){
                        $(document).click(function(){
                            open=false;
                        });
                        if(open==false){
                            sel_list.show();
                            open=true;
                            _this.find('i').css('background-position','-19px -54px ');
                            return false;
                        }
                        else{
                            sel_list.hide();
                            open=false;
                            _this.find('i').css('background-position','0 -54px ');
                            return false;
                        };
                    });
                    sel_item.click(function(){
                        if(typeof(_this.attr("data-noChange"))=="undefined"){//选择下拉项,文字不变化
                            title.text($(this).text());
                        }
                        sel_list.hide();
                        open=false;
                        fn && fn();
                    })
                })
            },

            //选择列表
            sel_list:function(model,fn){//model:单选/多选  single : multi
                return this.each(function() {
                    var _this=$(this);
                    var items=_this.find('[data-sel-item]');
                    items.each(function(){
                        $(this).click(function(){
                            var item_this=$(this);
                            if(model=="single") {
                                items.removeClass('sel_ac');
                                item_this.addClass('sel_ac');
                            };
                            if(model=="multi") item_this.toggleClass('sel_ac');
                            fn && fn(item_this);
                        })
                    })
                })
            },

            //选项卡
            tab:function(fn,opts) {
                var defaults = {};
                var opts = $.extend(defaults, opts);
                return this.each(function() {
                    var _this=$(this);
                    var tabList=_this.children('.tabList');
                    var tabCont=_this.children('.tabCont')
                    tabList.children('li').click(function () {
                        _this.find('a').removeClass('ac');
                        var index=$(this).index();
                        $(this).children('a').addClass('ac');
                        tabCont.children('.tabItem:eq('+index+')').show().siblings().hide();
                        fn && fn(index);
                    });
                })
            },

            //插入表情(face)
            insertAtCaret: function(myValue){
                var $t=$(this)[0];
                if(document.selection) {
                    this.focus();
                    sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                }
                else
                if ($t.selectionStart || $t.selectionStart == '0') {
                    var startPos = $t.selectionStart;
                    var endPos = $t.selectionEnd;
                    var scrollTop = $t.scrollTop;
                    $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                    this.focus();
                    $t.selectionStart = startPos + myValue.length;
                    $t.selectionEnd = startPos + myValue.length;
                    $t.scrollTop = scrollTop;
                }
                else {
                    this.value += myValue;
                    this.focus();
                }
            },

            //disableBtn
            disableBtn:function() {
                return this.each(function() {
                    $(this).addClass('disableBtn').attr('disable',true)
                });
            },
            //文本溢出展开收起
            openOverCont:function(opts) {
                var defaults = {
                    contName:".txtOverCont",
                    width:500,//容器宽度
                    btn_openTxt:"展开",
                    btn_closeTxt:"收起",
                    btn:".openContBtn"
                };
                var opts = $.extend(defaults, opts);
                return this.each(function() {
                    var _this=$(this);
                    _this.css('width',opts.width);
                    var button=$(this).find(opts.btn);
                    button.text(opts.btn_openTxt);
                    button.click(function(){
                        _this.toggleClass('openTxtOverCont');
                        button.text()==opts.btn_openTxt ?button.text(opts.btn_closeTxt) :button.text(opts.btn_openTxt)	;
                    });
                });
            },


            //tree
            tree:function(opts){
                var defaults = {
                    expandAll:true,//暂时无用
                    operate:true//暂时无用
                };
                var opts = $.extend(defaults, opts);
                return this.each(function() {
                    var _this=$(this);
                    var ico=_this.find('i');
                    var a=_this.find('a');
                    var leve1_li=_this.children('li');
                    leve1_li.children('a').css({'color':'#10ade5','fontSize':14})
                    leve1_li.last().addClass('last');
                    var ul=_this.find('ul');
                    ul.each(function(){$(this).children('li:last').addClass('last')});

                    ico.each(function() {
                        var pa=$(this).parent('li');
                        if(pa.children('ul').size()>0){//如果有子菜单,ico为open
                            $(this).addClass('openSubMenu');
                        }
                    });
                    a.each(function() {
                        var _this = $(this);
                        _this.click(function () {
                            a.removeClass('ac');
                            _this.addClass('ac');
                        });
                    });

                    var level1_menu=$('.pointTree').children('li');
                    if(level1_menu.size()==1){//只有一个一级目录,显示"其下"第一级子目录
                        $(level1_menu[0]).find('.subMenu .openSubMenu').addClass('closeSubMenu');
                        $(level1_menu[0]).find('.subMenu').hide();
                        $(level1_menu[0]).children('.subMenu').show();
                        $(level1_menu[0]).children('.subMenu i').removeClass('closeSubMenu');
                    }

                    else{//否则,全部收起,只显示一级目录
                        $(level1_menu).find('.subMenu').hide();
                        $(level1_menu).find('.openSubMenu').addClass('closeSubMenu');
                    };

                    var ac=$(this).find('.ac');
                    ac.each(function(index, element) {
                        $(this).parents('.subMenu').show().siblings('i').removeClass('closeSubMenu');
                    });

                    $(document).off('click').on('click','.openSubMenu',function(){
                        $(this).toggleClass('closeSubMenu');
                        var subMenu=$(this).nextAll('.subMenu')
                        if(subMenu.is(":hidden"))subMenu.show();
                        else subMenu.hide();
                    });
                });
            },

            //发言-
            speak:function(txt,num,face_imgs) {
                return this.each(function() {
                    var _this=$(this);
                    var placeholder=_this.children('.placeholder');
                    var textarea=_this.children('textarea');
                    var addFaceBtn=_this.find('.addFaceBtn');
                    var m= num || 140;
                    var imgs=face_imgs||popBox.face_imgs;
                    //textarea字数统计
                    textarea.charCount({'num':m}).focus(function(){placeholder.hide()});
                    textarea.blur(function(){
                        if(textarea.val()!="") placeholder.hide();
                        else placeholder.show();
                    });
                    //发表情
                    addFaceBtn.click(function(){popBox.face(imgs,$(this),textarea)});
                    placeholder.text(txt).click(function(){
                        $(this).hide();
                        textarea.focus();
                    });
                });
            },


            //数字统计-
            charCount:function(opts){
                var defaults = {
                    divName:"textareaBox", //外层容器的class
                    textareaName:"textarea", //textarea的class
                    numName:"num", //数字的class
                    num:140 //数字的最大数目
                };
                var opts = $.extend(defaults, opts);
                return this.each(function() {
                    //定义变量
                    var $onthis;//指向当前
                    var $divname=opts.divName; //外层容器的class
                    var $textareaName=opts.textareaName; //textarea的class
                    var $numName=opts.numName; //数字的class
                    var $num=opts.num; //数字的最大数目

                    function isChinese(str){  //判断是不是中文
                        var reCh=/[u00-uff]/;
                        return !reCh.test(str);
                    }
                    function numChange(){
                        var strlen=0; //初始定义长度为0
                        var txtval = $.trim($onthis.val());
                        for(var i=0;i<txtval.length;i++){
                            if(isChinese(txtval.charAt(i))==true) strlen=strlen+2;//中文为2个字符
                            else strlen=strlen+1;//英文一个字符
                        }
                        strlen=Math.ceil(strlen/2);//中英文相加除2取整数
                        if($num-strlen<0){
                            $par.html('超出 <b id="text_excess" data-text-excess="true" style="color:red;font-weight:bold" class='+$numName+'>'+Math.abs($num-strlen)+'</b> 字'); //超出的样式
                        }
                        else{
                            $par.html("可以输入 <b class="+$numName+">"+($num-strlen)+"</b> 字"); //正常时候
                        }

                        $b.html($num-strlen);
                    }
                    $("."+$textareaName).live("focus",function(){
                        $b=$(this).parents("."+$divname).find("."+$numName); //获取当前的数字
                        $par=$b.parent();
                        $onthis=$(this); //获取当前的textarea
                        var setNum=setInterval(numChange,500);
                    });
                })
            },

            //select发生变化时,弹出变更提示
            selectAlert:function(opts) {
                var def={
                    txt:"确定变更?",
                    trueFn:function(){},  //确定 回调函数
                    falseFn:function(){}  //取消 回调函数
                }
                var opts=$.extend(def,opts);
                return this.each(function() {
                    var oldElemt=$(this).children('[selected="selected"]');
                    $(this).change(function(){
                        var newElemt=$(this).children('[selected="selected"]');
                        popBox.confirmBox(opts.txt,
                            function(){
                                $(this).children().removeAttr('selected');
                                newElemt.attr('selected',true);
                                oldElemt=newElemt;
                                opts.trueFn();
                            },
                            function(){
                                $(this).children().removeAttr('selected');
                                oldElemt.attr('selected',true);
                                opts.falseFn();
                            })
                    })
                });
            },
            //checkbox多选  checkAll  demo:$('.checkAll').checkAll(checkboxs)
            checkAll:function(checkboxs) {
                return this.each(function() {
                    var _this=$(this);
                    var num=checkboxs.length;
                    var checkNum=0;
                    $(this).live('click',function(){
                        if(!_this.attr('checked')){
                            checkboxs.removeAttr('checked');
                            checkNum=0;
                        }
                        else{
                            checkboxs.attr('checked',true);
                            checkNum=num;
                        }
                    })
                    checkboxs.each(function(){
                        $(this).live('click',function(){
                            if(!$(this).attr('checked')){
                                _this.removeAttr('checked');
                                checkNum--;
                            }
                            else{checkNum++}
                            if(checkNum==num) _this.attr('checked',true);
                        })
                    })
                });
            },


            //placeholder-
            placeholder: function(opts) {
                var def={
                    value:"",//提示信息文本
                    top:0,//自定义top显示位置
                    ie6Top:"",
                    left:0, //自定义left显示位置
                    color:"#ccc"//文字颜色
                }
                var opts=$.extend(def,opts);
                return this.each(function() {
                    var _this=$(this);
                    var placeholder="";
                    var inputH=_this.outerHeight();
                    var lineH=parseInt(_this.css("line-height"));
                    var inputTop=_this.position().top+opts.top;
                    var inputLeft=_this.position().left+opts.left;
                    var spanLeft=inputLeft+5;
                    if(opts.top!=0)var spanTop=parseInt(opts.top+inputTop);
                    else spanTop=parseInt(inputTop+(inputH-lineH)/2+1);
                    function add_placeholder(){
                        _this.next('.placeholder').size()>0 && _this.next('.placeholder').remove();
                        _this.after('<span class="placeholder" style="position:absolute;top:'+spanTop+'px;*top:'+(opts.ie6Top+inputTop)+'px;left:'+spanLeft+'px;color:'+opts.color+'; height:20px !important;line-height:20px !important; font-size:12px">'+opts.value+'</span>');
                        placeholder=_this.nextAll('.placeholder');
                        placeholder.click(function(){
                            $(this).remove();
                            _this.focus();//弹出框聚焦
                        });
                    };
                    //_this.unbind('blur').blur();
                    if(_this.val()=="") add_placeholder();
                    else $(placeholder).remove();
                    _this.unbind('focus').focus(function(){$(placeholder).remove()});
                    _this.unbind('blur').blur(function(){if(_this.val()=="") add_placeholder()});
                });
            },


            //-弹出框居中

            popBoxShow: function(opts) {
                var def={
                    blackBg:true,//黑色半透明遮罩
                    remove:false,//关闭后是否移除弹出框
                    cancelBtn:"cancel",//"取消"按钮class
                    closeBtn:"close",//"取消"按钮class
                    okBtn:"ok",//"确定"按钮class
                    fn:function(){return true}//回调函数
                }
                var opts=$.extend(def,opts);
                return this.each(function() {
                    var _this=$(this);//removeParent内部要用到
                    var topRange= $(window).scrollTop();
                    var boxWidth=_this.outerWidth();
                    var boxHeight=_this.outerHeight();
                    var windowWidth =$(window).width();
                    var windowHeight=$(window).height();
                    if(boxHeight<windowHeight){//判断弹框高度是否大于浏览器窗口
                        var positionTop=parseInt((windowHeight+boxHeight)/2+topRange-boxHeight);
                    }
                    else{positionTop=30};

                    //移除mask
                    function removeMask(){$(".mask").fadeOut(500,function(){$(this).remove()});	};

                    //移除或者隐藏popBox
                    function removeParent(){
                        if(opts.remove==true){
                            _this.fadeOut(500,function(){
                                _this.remove();
                                removeMask()
                            });
                        }
                        else{
                            _this.fadeOut();
                            removeMask()
                        }
                    };

                    //是否显示黑色遮罩mask
                    if(opts.blackBg==true){
                        var maskH = $(document).height();
                        $(".mask").css({"background":"#000","opacity":"0.5","height":maskH, "width":"100%", "position":"absolute","top":0,"left":0, "z-index":100 });
                    };
                    //显示弹出框
                    _this.fadeIn(500).css({"top":positionTop, "left":parseInt((windowWidth-boxWidth)/2)});
                    _this.find('.'+opts.closeBtn+', .'+opts.cancelBtn).click(function(){
                        removeParent();
                    });
                    //点击ok键,是否关闭窗口
                    _this.find('.'+opts.okBtn).click(function(){
                        if(opts.fn()){removeParent()}
                    });
                });
            },

            //返回顶部
            backTop: function(opts) {
                var def={
                    top:600,//滚动条高度
                    backSpeed:800//滚动回顶部的速度
                };
                var opts=$.extend(def,opts);
                return this.each(function() {
                    if($(window).scrollTop() >= opts.top){
                        $('.backTop').fadeIn();
                        $('.backTop').click(function(){
                            $("html, body").stop().animate({"scrollTop":0}, opts.backSpeed);
                        })
                    }
                    else{$('.backTop').fadeOut()}
                });
            },

            //展开更多
            openMore:function(height,btn){
                var btn=btn || '.showMoreBtn';
                return this.each(function() {
                    var open=false;
                    var _this=$(this);
                    var h=_this.height();
                    var openBtn=_this.find(btn);
                    if(h>height){
                        _this.css({height:height,overflow:'hidden'});
                        openBtn.click(function(){
                            if(!open){
                                _this.height("auto");
                                openBtn.html('收起<i></i>').addClass('showMoreBtn_open');
                                open=true;
                            }else{
                                _this.height(height);
                                openBtn.html('更多<i></i>').removeClass('showMoreBtn_open');
                                open=false;
                            }
                        })
                    }else{
                        openBtn.hide();
                    }
                })
            },


            //试卷预览slid--
            slide:function(opts){
                var defaults = {
                    img_id:"",//缩略图id,跳转到指定id图片
                    width:790,
                    speed:500,
                    Clip_width:189,
                    next:"#nextBtn",
                    prev:"#prevBtn",
                    pageCount:".pageCount",
                    slidClip:'.slidClip',//缩略图div
                    sliderBtnBar:'.sliderBtnBar'//按钮div

                };
                var opts = $.extend(defaults, opts);
                var testPaperSize=0;
                var page=0;//当前页面

                return this.each(function() {
                    var _this=$(this);
                    var imgSize=_this.find('.slidePaperWrap li').size();//翻页
                    _this.find('.slidePaperList').css("width",imgSize*opts.width+imgSize*2);
                    for(var i=0; i<imgSize; i++){
                        $(opts.sliderBtnBar).append('<a>'+(i+1)+'</a>');
                    };
                    //缩略图
                    var slidClipArea=$(opts.slidClip).find('.slidClipArea');
                    var Clip_width=opts.Clip_width;//缩略图宽度
                    var Clip_num=slidClipArea.children('a').size();
                    var slidClipArea_width=Clip_width*Clip_num+100;
                    var slidClipWrap_width=$(opts.slidClip).find('.slidClipWrap').width();
                    var ClipNextBtn=$(opts.slidClip).find('.ClipNextBtn');
                    var ClipPrevBtn=$(opts.slidClip).find('.ClipPrevBtn');
                    var veiw_img_size=Math.round(slidClipWrap_width/Clip_width);//可视区可显示图片数量;


                    //图片垂直居中
                    var imgs=_this.find('.slidePaperList img');
                    var lis=_this.find('.slidePaperList li');
                    imgs.each(function(index, element) {
                        var li_h=0;
                        li_h=$(this).parents('.slidePaperWrap').height();
                        lis.eq(index).height(li_h);
                    });
                    slidClipArea.width(slidClipArea_width);

                    //如果传入id,显示指定图片
                    if(opts.img_id!=""){
                        page=_this.find('[name='+opts.img_id+']').index();
                        if(page>=0){
                            $(opts.sliderBtnBar+' a:eq('+page+'),'+opts.slidClip+' a:eq('+page+')').addClass('ac');
                            $(_this.find('ul')).css({"left":-opts.width*page});//大图
                            location_clip();
                        }
                        else page=0;
                    };

                    function current(){//确定当前页
                        _this.find('li').eq(page).addClass('current').siblings().removeClass('current');
                        $(opts.sliderBtnBar+' a').eq(page).addClass('ac').siblings().removeClass('ac');
                        $(opts.slidClip+' a').eq(page).addClass('ac').siblings().removeClass('ac');
                        $(opts.pageCount).text('共'+imgSize+'页,第'+(page+1)+'页');
                    };

                    function location_clip(){
                        var location=page;
                        if(location>veiw_img_size && location>(imgSize-veiw_img_size) ){
                            location=(imgSize-veiw_img_size);//控制显示边界
                        }
                        else if(location<veiw_img_size) location=0;
                        //else location=page;
                        slidClipArea.stop().animate({"left":-Clip_width*location},300);
                    };
                    function next(){//下一页
                        if(page<imgSize-1){
                            page++;
                            $(_this.find('ul')).stop().animate({"left":-opts.width*page},opts.speed);//大图
                            var local=page;
                            if(local<imgSize-veiw_img_size){
                                slidClipArea.stop().animate({"left":-Clip_width*local},opts.speed);
                            }
                            if(local>imgSize-veiw_img_size){
                                local=imgSize-veiw_img_size;
                                slidClipArea.stop().animate({"left":-Clip_width*local},opts.speed);
                            }
                            if(page<veiw_img_size){
                                local=0;
                                slidClipArea.stop().animate({"left":-Clip_width*local},opts.speed);
                            }
                            current();
                        }
                        //else popBox.errorBox('没有啦!');
                        else popBox.errorBox('没有更多图片了!');
                    };
                    function prev(){//上一页
                        if(page>0){
                            page--;
                            $(_this.find('ul')).animate({"left":-opts.width*page},opts.speed);//大图
                            if(page<imgSize-veiw_img_size+1)
                                slidClipArea.stop().animate({"left":-Clip_width*page},opts.speed);
                            current();
                        }
                        //else popBox.errorBox('已到首页!')
                        else popBox.errorBox('没有更多图片了!');
                    }

                    $(opts.sliderBtnBar+' a:first,'+opts.slidClip+' a:first').addClass('ac');
                    current();
                    $(opts.next).click(function(){next()});//幻灯 下一页
                    $(opts.prev).click(function(){prev()});//幻灯 上一页
                    ClipPrevBtn.click(function(){prev()});//clip 上一页
                    ClipNextBtn.click(function(){next()});//clip 上一页

                    $(opts.slidClip+' a,'+opts.sliderBtnBar+' a').click(function(){//选择页
                        page=$(this).index();
                        $(opts.sliderBtnBar+' a:eq('+page+'),'+opts.slidClip+' a:eq('+page+')').addClass('ac').siblings().removeClass('ac');
                        $(_this.find('ul')).css({"left":-opts.width*page});//大图
                        $(opts.pageCount).text('共'+imgSize+'页,第'+(page+1)+'页');
                        location_clip();
                        current();
                    });
                })
            },

            slide_min: function(options) {
                $.extend(options, {
                    autoplay: options.autoplay || 1,
                    defaultNum: options.defaultNum || 1,
                    time: options.time || 800
                });
                return this.each(function(options) {
                    var ul = $(this).find(".bd").find("ul");
                    var items = ul.find("li");
                    var fistChildWidth = items.eq(0).width();
                    var marginR = items.eq(0).css("margin-right");
                    var maxsize = items.size();

                    var itemWidth = fistChildWidth + parseInt(marginR, 10);
                    var trimer;
                    var index = 0;
                    var defaultNum = options.defaultNum || 1;
                    ul.width(maxsize * itemWidth);

                    function scroll(index) {
                        var tar = ul.children("li").eq(index);
                        ul.stop(true, true).animate({
                            "left": index * itemWidth * -1
                        }, 300);
                    }

                    function autoPlay() {
                        trimer = setInterval(function() {
                            scroll(index);
                            index++;
                            if (index >= maxsize) {
                                index = 0;
                            }
                        }, options.time);
                    }
                    if (options.autoplay) {
                        autoPlay();
                    }
                    $(this).find("a.prev").click(function() {
                        if (index > 0) {
                            index--;
                            scroll(index);
                        }
                    });
                    $(this).find("a.next").click(function() {
                        if ((index + 1) * defaultNum < maxsize-4) {
                            index++;
                            scroll(index);
                        }
                    });
                });
            }
        });
    })(jQuery);

    $(window).scroll(function(){$('body').backTop()});

})
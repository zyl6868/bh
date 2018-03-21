define(['sanhai_tools'],function (sanhai_tools){
	//数组新增方法---删除指定元素
	Array.prototype.remove=function(val){
		var index = this.indexOf(val.toString());
		if (index > -1) {this.splice(index, 1)}
	};
	//数组新增方法---排序
	Array.prototype.arrq=function(a,b){
		var temp=this[a];
		this[a]=this[b];
		this[b]=temp;
		return this;
	};
		
		
	//点击空白 关闭弹出窗口
	$(document).bind("mouseup",function(e){var target=$(e.target);if(target.closest(".pop").length==0)$(".pop").hide()});

	//页面侧边
	var fixedHtml='<div class="backTop hide"></div>';//返回顶部
	fixedHtml+='<a href="/common/about/suggestion" class="feedback"></a>';//意见反馈
	fixedHtml+='<div class="signIn"></div>';//每日签到
	//fixedHtml+='<a id="game_subject_link" href="http://info.banhai.com/vote/vote/index/" class="game_subject_link"><span>课件大赛开始投票啦!</span></a>';//专题
	fixedHtml+='<div class="QQonlineServ">';//qq在线客服
	fixedHtml+='<a title="3022300389" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3022300389&amp;site=qq&amp;menu=yes">在线客服一</a>';
	fixedHtml+='<a title="3024007911" target="_blank" href=" http://wpa.qq.com/msgrd?v=3&amp;uin=3024007911&amp;site=qq&amp;menu=yes">在线客服二</a>';
	fixedHtml+='<a title="3338450295"  target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3338450295&amp;site=qq&amp;menu=yes">在线客服三</a>';
	fixedHtml+='<a title="3307600568"  target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3307600568&amp;site=qq&amp;menu=yes">在线客服四</a>';
	fixedHtml+='<a class="QQhand" href="javascript:;"></a>';
	fixedHtml+='</div>';
	$("body").append(fixedHtml);

	//河北3022300389  安徽3024007911     湖北3338450295  山东省3307600568


	//QQ在线客服
	$('.QQonlineServ').hover(
		function(){
			$(this).addClass('QQonlineServShow').stop().animate({'left':0})
		},
		function(){
			$(this).stop().animate({'left':-150},function(){
				$(this).removeClass('QQonlineServShow')
			})
		}
	);

	//input回车自动跳转
	$('input').focus(function(){
		var tabIndex=$(this).attr('tabindex');
		$(this).keyup(function(event){
			if(event.keyCode==13){
				$(this).blur();
				tabIndex++;
				$('input[tabindex='+tabIndex+']').focus();
			}
		})
	});


	//头部
	
	$(document).on('mouseover','.head .msgAlert',function(){
		$(this).children('a').addClass('msgAlert_hover');
		$('.head .msgList').show();
	});
	$(document).on('mouseout','.head .msgAlert',function(){
		$(this).children('a').removeClass('msgAlert_hover');
		$('.head .msgList').hide();
	});

	$(document).on('mouseover','.head_nav li',function(){
		$(this).children('.subMenu').show();
	});
	$(document).on('mouseout','.head_nav li',function(){
		$(this).children('.subMenu').hide();
	});


	 $(".centerBox").hover(
        function() {
            $(this).addClass('centerBox_hover');
        },
        function() {
            $(this).removeClass('centerBox_hover');
        }
    );
	
	//二维码
	$('.foot i').click(function(){
		$(this).children('.QRCord').show();
		return false;
	})




	//表格隔行变色
	$(document).on('mouseover','table tbody tr',function(){
		$(this).addClass('trOver');
	});
	$(document).on('mouseout','table tbody tr',function(){
		$(this).removeClass('trOver');
	});


//课件大赛弹框
//	(function(){
//		var overTime,outTime;
//		$('#game_subject_link').on({
//			mouseover:function(){
//				clearTimeout(overTime);
//				var _this=$(this);
//				overTime=setTimeout(function(){
//					$('body').append('<div id="game_subject_cont" class="game_subject_cont"><p>一周时间见分晓，速来投票！<p>2307件作品，150件入围!</P><p> 投票决定盛典席位，一锤定音！</p> <p>投票时间：4月26日0时-5月3日24时 </p><p>投票规则：每个账号1天可投1票</p><p> 投票人：学生和老师</p></div>');
//				},100);
//			},
//			mouseout:function(){
//				clearTimeout(overTime);
//				var card=$('#game_subject_cont');
//				function removeCard(){
//					outTime=setTimeout(function(){
//						card.remove();
//					},100);
//				};
//				removeCard();
//				overTime=setTimeout(function(){removeCard()},200);
//				card.mouseover(function(){
//					clearTimeout(overTime);
//					clearTimeout(outTime);
//				});
//				card.mouseout(function(){
//					removeCard();
//				});
//			}
//		});
//	})();


	/*选择"评论可见"
	$('.widget_select').live({
		mouseover:function(){$(this).addClass('widget_select_hover')},
		mouseout:function(){$(this).removeClass('widget_select_hover')}
	});

	$('.widget_select a').live('click',function(){
		var pa=$(this).parents('.widget_select');
		pa.find('h6 span').text($(this).text());
		pa.removeClass('widget_select_hover');
	});
*/


	//发言textarea 添加表情
	$(document).on('click','.textareaBox .addFaceBtn',function(){
		var textarea=$(this).parents('.textareaBox').children('textarea');
		popBox.face($(this),textarea);
	})

	//每日签到
	sanhai_tools.signIn('/ajax/check-sign');
	$(".signIn").click(function(){
		if(!$(this).hasClass('signIn_on')){
			sanhai_tools.signIn('/ajax/sign');
		}
	})

	//单选条目
	window.onload=function(){
	$('.resultList').delegate('li','click',function(){
		$(this).addClass('ac').siblings().removeClass('ac');
	});
	}
        //tree-----------------------------------------------------------------
    ;(function($){
        $.fn.extend({
            tree:function(opts){
                var defaults = {
                    expandAll:true,//暂时无用
                    operate:true//暂时无用
                };
                var opts = $.extend(defaults, opts);
                return this.each(function() {
                    var ico=$(this).find('i');
                    var a=$(this).find('a');

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


                    $('.openSubMenu').die('click').live('click',function(){
                        $(this).toggleClass('closeSubMenu');
                        $(this).nextAll('.subMenu').toggle();
                    });

                });
            }
        });
    })(jQuery);
		
})




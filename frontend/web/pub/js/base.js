$(function(){
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
$('.head .msgAlert').live({
	mouseover:function(){
		$(this).children('a').addClass('msgAlert_hover');
		$('.head .msgList').show();
	},
	mouseout:function(){
		$(this).children('a').removeClass('msgAlert_hover');
		$('.head .msgList').hide();
	}
});

/*$('.head .userChannel').hover(
	function(){
		$(this).addClass('userChannelHover');
		$('.head .userChannelList').show();
	},
	function(){
		$(this).removeClass('userChannelHover');
		$('.head .userChannelList').hide();
	}
);
*/


$('.head_nav li').live({
	mouseover:function(){
		$(this).children('.subMenu').show();
	},
	mouseout:function(){
		$(this).children('.subMenu').hide();
	}
});



//修改班级宣言 修改指定文本 简单版
//编辑文字
$('#revise i').click(function(){
	$('#revise').addClass('revise');
	$('#revise').children('.reviseStatus').remove();
	var txt=$(this).siblings('.class_title').text();
	var _this = $(this);	
	sanhai_tools.setIntro(txt,_this);
});



//表格隔行变色
$('table tbody tr').live({
	mouseover:function(){$(this).addClass('trOver')},
	mouseout:function(){$(this).removeClass('trOver')}
});


	//课件大赛弹框
	//(function(){
	//	var overTime,outTime;
	//	$('#game_subject_link').on({
	//		mouseover:function(){
	//			clearTimeout(overTime);
	//			var _this=$(this);
	//			overTime=setTimeout(function(){
	//				$('body').append('<div id="game_subject_cont" class="game_subject_cont"><p>一周时间见分晓，速来投票！<p>2307件作品，150件入围!</P><p> 投票决定盛典席位，一锤定音！</p> <p>投票时间：4月26日0时-5月3日24时 </p><p>投票规则：每个账号1天可投1票</p><p> 投票人：学生和老师</p></div>');
	//			},100);
	//		},
	//		mouseout:function(){
	//			clearTimeout(overTime);
	//			var card=$('#game_subject_cont');
	//			function removeCard(){
	//				outTime=setTimeout(function(){
	//					card.remove();
	//				},100);
	//			};
	//			removeCard();
	//			overTime=setTimeout(function(){removeCard()},200);
	//			card.mouseover(function(){
	//				clearTimeout(overTime);
	//				clearTimeout(outTime);
	//			});
	//			card.mouseout(function(){
	//				removeCard();
	//			});
	//		}
	//	});
	//})();


//checkbox
$('input:checkbox').live('click',function(){
	var target=$(this).next('label');
	if($(this).attr('disabled')!=true) target.toggleClass('chkLabel_ac');
	else return false;
});

//radio
var radio=$('input:radio');
radio.each(function(index, element) {
    if($(this).attr('disabled')){
		$(this).next('label').addClass('radioLabel_disabled');
	}
});
$('input:radio').live('click',function(){
	var target=$(this).next('label');
	var name=$(this).attr('name');
	target.addClass('radioLabel_ac');
	if($(this).attr('disabled')!=true){
		$('input:radio[name='+name+']').not(this).each(function(index, element) {
			$(this).next('label').removeClass('radioLabel_ac');
		});
	}
});



//select
/*$('.selectWrap select').live('change',function(){
	var em=$(this).prev('em');
	var txt=$(this).children('option:selected').text();
	em.text(txt);
});
*/

/*选择"评论可见"*/
$('.widget_select').live({
	mouseover:function(){$(this).addClass('widget_select_hover')},
	mouseout:function(){$(this).removeClass('widget_select_hover')}
});

$('.widget_select a').live('click',function(){
	var pa=$(this).parents('.widget_select');
	pa.find('h6 span').text($(this).text());
	pa.removeClass('widget_select_hover');
});



//表单验证
if($('.form_id,#form_id').size()>0) $('.form_id,#form_id').validationEngine({'maxErrorsPerField':1}); 

//展开内容
$('.overCont').each(function(index, element) {
   if($(this).height()<72){
		$(this).find('.openOverContBtn').hide();
	}
});
$('.openOverContBtn').click(function(){
	$(this).parent('.overCont').toggleClass('openOverCont');
	var txt=$(this).text();
	$(this).text(txt=="查看全部" ? txt="收起":txt="查看全部")
});	
	
//左侧动画菜单
$('.setupMenu .subMenu .ac').parents('ul').show().prev('a').addClass('close');
$(".setupMenu li:has('.subMenu')").children('a').click(function(){
	$(this).toggleClass('close').next('ul').stop().slideToggle();
	$(this).parent('li').siblings().children('a').removeClass('close');
	$(this).parent('li').siblings().children('.subMenu').slideUp();
});
$('.setupMenu .subMenu a').click(function(){
	$('.setupMenu .subMenu a').removeClass('ac');
	$(this).addClass('ac')
});

//选项卡
$('.tab .tabList li').click(function(){
	var index=$(this).index();
	$(this).children('a').addClass('ac').parent('li').siblings('li').children('a').removeClass('ac');
	$('.tabCont .tabItem:eq('+index+')').show().siblings().hide();
});


//关闭弹窗
$('.popBox .cancelBtn').click(function(){
	$(this).parents('.popBox').dialog("close");
});

//增加题目
$('.hot').addClass('pop');
$('.problem_r_list').live('click',function(){
	$(this).children('.hot').show();	
});
$('.hot li').hover(function(){
	$(this).addClass('this');
},function(){
	$(this).removeClass('this');	
});
$('.hot li').click(function(){
	$(this).parents('.hot').hide();
});
	

//单选条目
$('.resultList li').live('click',function(){
	$(this).addClass('ac').siblings().removeClass('ac');
});

//多选条目
$('.multi_resultList li').live('click',function(){
	$(this).toggleClass('ac');
});

//关闭按钮
$('.closeBtn').live('click',function(){
	$(this).parent().hide();
});

//删除按钮
$('.delBtn').live('click',function(){
	$(this).parent().remove();
});

// 发言textareabox
//$('.textareaBox').speak('走两步吧');


//发言textarea 添加表情
$('.textareaBox .addFaceBtn').live('click',function(){
	var textarea=$(this).parents('.textareaBox').children('textarea');
	popBox.face($(this),textarea);
});

//每日签到
    sanhai_tools.signIn('/ajax/check-sign');

    $(".signIn").click(function(){
        if(!$(this).hasClass('signIn_on')){
            sanhai_tools.signIn('/ajax/sign');
        }
    });
//jquery end
});

//------------------------------------------------------------------------------
var sanhai_tools={};
sanhai_tools.signIn=function(chk_url){
	$.ajax({
		url:chk_url,
		type:'get',
		dataType:'json',
		success:function(msg){
			if(msg.success){
				$(".signIn").addClass('signIn_on');
				if (msg.code == 1) {
					popBox.successBox('签到成功,积分+1');
				}
			}else{
				if(msg.code == 2){
                    popBox.errorBox('您已经签到！');
                }
			}
		}
	})
};



//滚动条
sanhai_tools.progress=function(speed){
	var speed = speed || 2000;
	$('.big_progress .bg').animate({'width':"100%"},speed,"linear");
	var num=1;
	var time=setInterval(function(){
		$('.big_progress span').text(num+'%');
		num++;
		if(num>100) clearInterval(time)
	},parseInt(speed/100));
};

//修改班级宣言
sanhai_tools.setIntro=function(txt,elm){
	var txt = txt || '';
	var html='';
		html+='<p class="reviseStatus"><input type="text" class="text reviseText" value="' + txt + '"><a href="javascript:;" class="a_button w40 bg_blue ok_btn">确定</a><a href="javascript:;" class="a_button w40 bg_gray cancel_btn">取消</a></p>';
		$('#revise').append(html);
		$('#revise').addClass('reviseHide');
		$('#revise .ok_btn').live('click',function(){
				var _this=$(this).siblings('.reviseText').val();
				$('#revise').removeClass('reviseHide');	
				$.ajax({
					url:elm.attr('data-action'),
					type:'POST',
					data:{classId:elm.attr('data-id'),txt:_this},
					dataType:'json',
					success:function(msg){
						if(msg.success){
							$('#revise .class_title').text(_this);
							$('#revise .class_title').attr('title',_this);
							$('#revise').removeClass('reviseHide');	
						}
						else{popBox.errorBox(msg.message)}
					},
					error:function(){popBox.errorBox(msg.message)}
				})
		});
		$('#revise .cancel_btn').live('click',function(){
			$('#revise').removeClass('reviseHide');
		})
};

//判断元素在屏幕的中线上下位置
sanhai_tools.vertical_position=function(elm){//元素的jquery对象
	var scrollTop=$(window).scrollTop();
	var elm_pos=elm.offset().top;
	var screen_h=$(window).height();
	if((scrollTop+screen_h/2)<elm_pos) return false;
	else return true;
};
//判断元素在屏幕的中线水平位置
sanhai_tools.horizontal_position=function(elm){//元素的jquery对象
	var elm_pos=elm.offset().left;
	var screen_w=$(window).width();
	if((screen_w/2)<elm_pos) return false;
	else return true;
};


//秒倒计时
function countdown(sec,elm,fn){//秒 元素 回调函数
	sec-=1;
	var time=setInterval(function(){
    if(sec>0) sec=Math.floor(sec);
	if(sec==0){
		clearTimeout(time);
		if(fn) fn();
		else alert('时间到');
	}
		$(elm).text(sec);
    sec--;
    }, 1000);
} 

sanhai_tools.isIE=function(ver){
	var b = document.createElement('b');
	b.innerHTML = '<!--[if IE ' + ver + ']><i></i><![endif]-->';
	return b.getElementsByTagName('i').length === 1
};
/*if(isIE()){alert('ie6:' + isIE(6) + '\n' + 'ie7:' + isIE(7) + '\n' + 'ie8:' + isIE(8) + '\n' + 'ie9:' + isIE(9) + '\n' + 'ie:' + isIE())}*/


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

//获取光标位置
function getCursortPosition (ctrl) {
	var CaretPos=0;   // IE Support
	if (document.selection) {
		ctrl.focus();
		var Sel=document.selection.createRange();
		Sel.moveStart ('character', -ctrl.value.length);
		CaretPos =Sel.text.length;
	}
	// Firefox support
	else if (ctrl.selectionStart || ctrl.selectionStart=='0'){
		CaretPos = ctrl.selectionStart;
	}
	return CaretPos;
}
//设置光标位置
function setCaretPosition(ctrl, pos){
	if(ctrl.setSelectionRange) {
		ctrl.focus();
		ctrl.setSelectionRange(pos,pos);
	}
	else if (ctrl.createTextRange) {
		var range = ctrl.createTextRange(); range.collapse(true); range.moveEnd('character', pos); range.moveStart('character', pos); range.select();
		}
}
//  插入表情(face)-------------------------------------------------------------
(function ($) {
	$.fn.extend({
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
		}
	}) 
})(jQuery);

//disableBtn-----------------------------------------------------------------
(function ($) {
	$.fn.extend({
		disableBtn:function() {
			return this.each(function() {
				$(this).addClass('disableBtn').attr('disable',true)
			});
		}
	});
})(jQuery);


//文本溢出展开收起
(function ($) {
	$.fn.extend({
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
/*				var contW= _this.children('.cont').width();
				if(contW<opts.width-40) button.hide();
				
*/				
				button.text(opts.btn_openTxt);
				button.click(function(){
					_this.toggleClass('openTxtOverCont');
					button.text()==opts.btn_openTxt ?button.text(opts.btn_closeTxt) :button.text(opts.btn_openTxt)	;
				});
				
				
				
			});
		}
	});
})(jQuery);

//fixed -----------------------------------------------------------------
(function ($) {
	$.fn.extend({
		itemFixed:function(opts){
			var defaults = {
				fixAdaptive:false,//自适应高度
				scroll_top:0,//距离顶部触发fixed的值
				fixTop:0,//绝对定位用到的top值
				fixWidth:'auto',//fix后的新宽度
				fixHeight:'auto',//fix后的新高度
				fix_zIndex:"auto",//定义z-index
				margin_left:"inherit"//定义margin-left偏移
			}; 
			
			var opts = $.extend(defaults, opts); 
			return this.each(function() {
				var _this=$(this);
				var position=_this.css('position');
				var _this_top=_this.offset().top;
				
				
				var left=_this.css('left');
				var fixLeft=_this.offset().left;
				var originalHeight=_this.height();
				var top=_this.css('top');
				var clone=_this.clone();
				clone.empty().hide().addClass('fixedClone').css({'opacity':0,'height':100,'padding':0});//高度不能太高,否则会影响滚动条
				_this.after(clone);	
				
				$(window).scroll(function(){
					var documentH=$(document).height();
					var windowH=$(window).height();
					var scrollTop=$(window).scrollTop();
					
					
					if(opts.fixAdaptive==true){//自适应高度
						opts.fixHeight=$(window).height()-200;
						$('.knowledge').height(opts.fixHeight);
						$(window).resize(function(){
							opts.fixHeight=$(window).height()-200;
							$('.knowledge').height(opts.fixHeight);
						})
					}
					if(scrollTop+opts.scroll_top>=_this_top){
						_this.addClass('fixed').css({'top':opts.fixTop,'width':opts.fixWidth,'height':opts.fixHeight,'z-index':opts.fix_zIndex,'margin-left':opts.margin_left,'overflow':'auto'});
							
							if(documentH-scrollTop<windowH*1.1 && opts.fixAdaptive==true){
								_this.css({'height':(opts.fixHeight-100)});
							}
						if(position=="absolute"){
								_this.css({'left':fixLeft,'top':fixTop});
							}
						_this.next('.fixedClone').show();
					}
					if(scrollTop+opts.scroll_top<=_this_top){
							_this.removeClass('fixed');
							if(position=="absolute"){
								_this.css({'left':left,'top':top});
							}
							_this.css({'top':top,'z-index':'auto','margin-left':'inherit'});
							_this.next('.fixedClone').hide();
						}
				});
			});
		}
	});
})(jQuery);
	



//tree-----------------------------------------------------------------
(function ($) {
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
				}
				//如果有选中项目,默认展开
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

//发言-------------------------------
(function ($) {
	$.fn.extend({
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
		}
	});
})(jQuery);



//上传试卷----------------------------------------------------
(function ($) {
	$.fn.extend({
		imgFileUpload:function(picName) {//名称:"考试"
			var name=picName || ""; 
			return this.each(function() {
				var _this=$(this);
				var modify_Btn=_this.find('.modifyBtn');
				function count(){//统计数字
					var num=_this.find('li:not([class="more"])').size();
					return num;
				}
				if(count()<1){
					_this.find('.more').show();
					_this.find('button').hide();
				}
				else{
					_this.find('.finishBtn,.delBtn,.more').hide();
					modify_Btn.show();
				}
				_this.find('.delBtn').live('click',function(){
					$(this).parent().remove();
					if(count()<1){
					_this.find('.more').show();
					_this.find('.finishBtn').hide();
					}
					var elements=_this.find('li:not([class="more"]) b');
					if(elements.size()>0){//上传图片名称排序
						elements.each(function(index){
							$(this).text(name+'第'+(index+1)+'页')
						});
					}
				});
				
				_this.find('.finishBtn').click(function(){
					if(count()<1){
						_this.find('.more').show();
						$(this).hide();
					}
					else{
						$(this).hide();
						modify_Btn.show();
						_this.find('.delBtn,.more').hide();
					}
				});
				
				modify_Btn.click(function(){
					_this.find('.delBtn,.more').show();
					$(this).hide();
					_this.find('.finishBtn').show();
				});
				
				_this.find('.more').click(function(){
					_this.find('.finishBtn').show();
				});
			});
			
		}
	});
})(jQuery);


//数字统计-----------------------------------------------------------------------
(function ($) {
	$.fn.extend({
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
			 $par.html("超出 <b style='color:red;font-weight:bold' class="+$numName+">"+Math.abs($num-strlen)+"</b> 字"); //超出的样式
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
	}
	})
})(jQuery);


//select发生变化时,弹出变更提示-------------------------------------------------------------
(function ($) {
	$.fn.extend({
		selectAlert:function(opts) {
			var def={
			txt:"确定变更?",
			trueFn:function(){},  //确定 回调函数
			falseFn:function(){}  //取消 回调函数
			};
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
		}
	});
})(jQuery);


//checkbox多选  checkAll-------------------------------------------------------------
(function ($) {
	$.fn.extend({
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
				});
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
		}
	});
})(jQuery);	
/*demo:$('.checkAll').checkAll(checkboxs)*/	

//checkbox多选  新版checkAll-------------------------------------------------------------
(function ($) {
	$.fn.extend({
		newCheckAll:function(checkboxs) {
			return this.each(function() {
				var _this=$(this);
				var num=checkboxs.length;
				var checkNum=0;
				$(this).live('click',function(){
					if(!$(this).attr('checked')){
						checkboxs.each(function(index, element) {
							if(!$(this).attr('disabled')){
								$(this).removeAttr('checked');
								$(this).next('label').removeClass('chkLabel_ac');
							}
						});
						checkNum=num;
					}
					else{
						checkboxs.each(function(index, element) {
							$(this).attr('checked',true);
							$(this).next('label').addClass('chkLabel_ac');
						});
						checkNum=0;
					}
				});
				
				function ck(){
					var i="";
					checkboxs.each(function(index, element) {
						if($(this).attr('checked')) i++;
					});
					return i;
				}
				checkboxs.each(function(){
					$(this).live('click',function(){
						if($(this).attr('checked')){
							checkNum=ck();
							if(checkNum==num){
								_this.attr('checked',true);
								_this.next('label').addClass('chkLabel_ac');
							}
						}
						else{
							_this.removeAttr('checked');
							_this.next('label').removeClass('chkLabel_ac');
						}
					})
				})
			});
		}
	});
})(jQuery);


//-自定义下拉框select----------------------------------------------------------------------
(function ($) {
	$.fn.extend({
	mySelect: function(opts) {
		var def={
			title:"title",  //显示选中的文本的class
			openBtn:"openBtn",  //打开下拉列表按钮的class
			selectList:"selectList",  //下拉列表的class
			fn:function(){}//回调函数
			};
		var opts=$.extend(def,opts);
		return this.each(function() {
			$(this).children("."+opts.openBtn).click(function(){
				$(this).siblings("."+opts.selectList).css("z-index",200).show();
				return false;
			});
			$(this).find("."+opts.selectList+" a").click(function(){
				$(this).parents('.mySelect').children("."+opts.title).text($(this).text());
				$(this).parents("."+opts.selectList).hide();
				opts.fn();
			})
		})	
     }
 });
})(jQuery);


//修改指定文本 ajax----------------------------------------------------
(function ($) {
	$.fn.extend({
		editPlus:function(opts) {
			var def={
				type:"input",//选择输入框的类型 txt:input  menu:select
				list:[],//输入框为select,此为select的选项
				target:'',//要修改文字的目标元素
				top:0, //定位top值
				url:'',//ajax地址
				data:[],//ajax自定义属性
				tag:null,//ajax 属性元素
				customData:[]//后台自定义属性(后台操作)
			};
			var opts=$.extend({},def,opts);
			
			function ajax(val,btn,clsName,value){
				var attrsTarget = opts.tag || opts.target;
				var data = {};
				var len=opts.data.length;
				if(len>0){
					for(var i=0 ; i<len; i++){
						data[opts.data[i]] = attrsTarget.attr(opts.data[i]);
					}
				}
				$.ajax({
					url:opts.url,
					data:$.extend({},data,{'data':val}),
					dataType:"json",
					success: function(msg){
						if(msg.success){
							opts.target.text(value||val);
							if(value){opts.target.attr('value',val);}
							$('.'+clsName).remove();
							opts.target.css({'visibility':'visible'});
							btn.css({'visibility':'visible'});
						}else{
							popBox.errorBox('修改失败,请重试!');	
						}
					}
				})
			}
			return this.each(function() {
				$(this).click(function(){
					
					var _this=$(this);
					opts.target=_this.prev();
					var _target=opts.target;
					var inputTop=_target.offset().top-3 ;
					var inputLeft=_target.offset().left;
					var inputW=_target.width()+20;
					var oldTxt=_target.text();
					var oldVal="";
					var clsName="editPlus";//+parseInt(Math.random()*100);
					$(document).keyup(function(event){
					  if(event.keyCode ==13){
						$('.'+clsName+' .ok').trigger("click");
					  }
					});
					$(document).keyup(function(event){
					  if(event.keyCode ==27){
						$('.'+clsName+' .cancel').trigger("click");
					  }
					});
					$('.'+clsName).remove();
					
					if(opts.type=="input"){//input输入框
						var html='<div class="'+clsName+'" style="position:absolute; z-index:100;top:'+(inputTop+opts.top)+'px; left:'+inputLeft+'px"><input type="text" class="text" style="width:'+inputW+'px;" value="'+oldTxt+'"> <button type="button" class="bg_gray ok" style="height:24px !important; line-height:24px !important; font-size:12px !important">确定</button><button type="button" class="bg_gray cancel" style="height:24px !important; line-height:24px !important; font-size:12px !important">取消</button></div>';
						opts.top=0;
						$("body").append(html);
						
						$('.'+clsName+' .ok').click(function(){
							var val = $('.'+clsName+' .text').val();
							if (val == "") {
								popBox.errorBox('不能为空!');
							}
							if(val>900 || val<0){popBox.errorBox('超长范围!0--900');	}
							else if(val == oldTxt){
								$('.'+clsName).remove();
							}
							else{ ajax(val,_this,clsName) }
						});
						
						$('.'+clsName+' .cancel').click(function(){
							opts.target=oldTxt;
							$('.'+clsName).remove();
						});
						
					}
					else{//select下拉列表
						oldVal=_target.attr('value');
						var opation_html="";
						for(var i=0; i<opts.list.length;i++){
							if(opts.list[i].key==oldVal){
								opation_html+='<option selected value="'+opts.list[i].key +'">'+opts.list[i].value+'</option>';
							}
							opation_html+='<option value="'+opts.list[i].key +'">'+opts.list[i].value+'</option>';
						}
						var html='<div class="'+clsName+'" style="position:absolute; z-index:100;top:'+(inputTop+opts.top)+'px; left:'+(inputLeft-6)+'px"><select style="font-size:12px">'+opation_html+'</select> <button type="button" class="bg_gray ok" style="height:24px !important; line-height:24px !important; font-size:12px !important">确定</button><button type="button" class="bg_gray cancel" style="height:24px !important; line-height:24px !important; font-size:12px !important">取消</button></div>';
						opts.top=0;
						$("body").append(html);
						var sel_opts=$('.'+clsName).find('option');
						sel_opts.each(function(){//选定旧值
							if($(this).val()==oldVal) $(this).attr('selected',true);
						});
						
						
						$('.'+clsName+' .ok').click(function(){
							if($('.'+clsName+' select').val()=="undefined"){
								$('.'+clsName).remove();
							}
							else{
								var key=$('.'+clsName+' select').val();
								var value=$('.'+clsName+' select').children(":selected").text();
								ajax(key,_this,clsName,value);
							}
						});
						$('.'+clsName+' .cancel').click(function(){
							opts.target=oldTxt;
							$('.'+clsName).remove();
						});
					}
				})
		   });
     	}
	});
/*demo
$('#ss').editPlus({type:"select",list:[{'key':001,'value':"张三"},{'key':002,'value':"李四"},{'key':003,'value':"王五"}]})
$('#ss').editPlus({url:'http://www.baidu.com',tag:$('h1'),data:['tid','tname']})
*/
})(jQuery);

//修改指定文本 ajax 简化版:没有数字长度验证,没有select,----------------------------------------------------
(function ($) {
	$.fn.extend({
		editPlus2:function(opts) {
			var def={
				target:'',//要修改文字的目标元素
				top:0, //定位top值
				url:'',//ajax地址
				data:[],//ajax自定义属性
				tag:null,//ajax 属性元素
				customData:[]//后台自定义属性(后台操作)
			};
			var opts=$.extend({},def,opts);
			
			function ajax(val,btn,clsName,value){
				var attrsTarget = opts.tag || opts.target;
				var data = {};
				var len=opts.data.length;
				if(len>0){
					for(var i=0 ; i<len; i++){
						data[opts.data[i]] = attrsTarget.attr(opts.data[i]);
					}
				}
				$.ajax({
					url:opts.url,
					data:$.extend({},data,{'data':val}),
					dataType:"json",
					success: function(msg){
						if(msg.success){
							opts.target.text(value||val);
							if(value){opts.target.attr('value',val);}
							$('.'+clsName).remove();
							opts.target.css({'visibility':'visible'});
							btn.css({'visibility':'visible'});
						}else{
							popBox.errorBox('修改失败,请重试!');	
						}
					}
				})
			}
			return this.each(function() {
				$(this).click(function(){
					
					var _this=$(this);
					opts.target=_this.prev();
					var _target=opts.target;
					var inputTop=_target.offset().top-3 ;
					var inputLeft=_target.offset().left;
					var inputW=_target.width()+40;
					var oldTxt=_target.text();
					var oldVal="";
					var clsName="editPlus";//+parseInt(Math.random()*100);
					$(document).keyup(function(event){
					  if(event.keyCode ==13){
						$('.'+clsName+' .ok').trigger("click");
					  }
					});
					$(document).keyup(function(event){
					  if(event.keyCode ==27){
						$('.'+clsName+' .cancel').trigger("click");
					  }
					});
					$('.'+clsName).remove();
					
					var html='<div class="'+clsName+'" style="position:absolute; z-index:100;top:'+(inputTop+opts.top)+'px; left:'+inputLeft+'px"><input type="text" class="text" style="width:'+inputW+'px;" value="'+oldTxt+'"> <button type="button" class="bg_gray ok" style="height:24px !important; line-height:24px !important; font-size:12px !important">确定</button><button type="button" class="bg_gray cancel" style="height:24px !important; line-height:24px !important; font-size:12px !important">取消</button></div>';
						opts.top=0;
						$("body").append(html);
						
						$('.'+clsName+' .ok').click(function(){
							var val = $('.'+clsName+' .text').val();
							if(val == ""){popBox.errorBox('不能为空!')}
							else if(val == oldTxt){
								$('.'+clsName).remove();
							}
							else{ ajax(val,_this,clsName) }
						});
						
						$('.'+clsName+' .cancel').click(function(){
							opts.target=oldTxt;
							$('.'+clsName).remove();
						});
				})
		   });
     	}
	});
/*demo
$('#ss').editPlus({url:'http://www.baidu.com',tag:$('h1'),data:['tid','tname']})
*/
})(jQuery);


//拖拽-----------------------------------------------------------
(function ($) {
	$.fn.extend({
		drag:function(fn) {//移动后回调函数
			return this.each(function() {
				var _this=$(this);
				var _move=true;//移动标记  
				var _x,_y;//鼠标离控件左上角的相对位置  
				_this.mousedown(function(event){  
					_move=true;  
					_x=event.pageX-parseInt($(this).position().left);  
					_y=event.pageY-parseInt($(this).position().top);  
					_this.fadeTo(20, 0.5);//点击后开始拖动并透明显示
					$(document).mousemove(function(event){ 
						if(_move){  
							var x=event.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置  
							var y=event.pageY-_y; 
							_this.css({top:y,left:x});//控件新位置  
						}  
					}).mouseup(function(event){  
						_move=false;  
						_this.fadeTo("fast", 0.9);//松开鼠标后停止移动并恢复成不透明
					});
				});
				//return false;
				//event.stopPropagation();
		   });
     	}
	});
	
})(jQuery);



//placeholder----------------------------
(function ($) {
	$.fn.extend({
	placeholder: function(opts) {
		var def={
			value:"",//提示信息文本
			top:0,//自定义top显示位置
			ie6Top:"",
			left:0, //自定义left显示位置
			color:"#ccc"//文字颜色
		};
		var opts=$.extend(def,opts);
		return this.each(function() {
			var _this=$(this);
			var placeholder="";
			var inputH=$(this).outerHeight();
			var lineH=parseInt(_this.css("line-height"));
			var inputTop=_this.position().top;
			var inputLeft=_this.position().left;
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
					//$(this).prev().click();//添加点击事件(JqueryUI弹框)
				});
			}
			//_this.unbind('blur').blur();
			if(_this.val()=="") add_placeholder();
			else $(placeholder).remove();
			_this.unbind('focus').focus(function(){$(placeholder).remove()});
			_this.unbind('blur').blur(function(){if(_this.val()=="") add_placeholder()});
			
       });
     }
 });
	
})(jQuery);



//-弹出框居中---------------------------------------------------------------------------------
(function ($) {
	$.fn.extend({
	popBoxShow: function(opts) {
		var def={
			blackBg:true,//黑色半透明遮罩
			remove:false,//关闭后是否移除弹出框
			cancelBtn:"cancel",//"取消"按钮class
			closeBtn:"close",//"取消"按钮class
			okBtn:"ok",//"确定"按钮class
			fn:function(){return true}//回调函数
		};
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
			else{positionTop=30}
			
			//移除mask
			function removeMask() {
				$(".mask").fadeOut(500, function () {
					$(this).remove()
				});
			}
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
			}
			//是否显示黑色遮罩mask
			if(opts.blackBg==true){
				 var maskH = $(document).height();
				$(".mask").css({"background":"#000","opacity":"0.5","height":maskH, "width":"100%", "position":"absolute","top":0,"left":0, "z-index":100 });
			}
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
     }
 });
})(jQuery);



//返回顶部-----------------------------------------------------------------------------------------
(function ($) {
	$.fn.extend({
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
     }
 });
})(jQuery);
$(window).scroll(function(){$('body').backTop()});

//试卷预览slid-----------------------------------------------------------------------------------------
(function ($) {
	$.fn.extend({
	testpaperSlider:function(opts){
		var defaults = {
			img_id:"",//缩略图id,跳转到指定id图片
			width:846,
			speed:500,
			next:"#nextBtn",
			prev:"#prevBtn",
			pageCount:".pageCount",
			slidClip:'.slidClip',//缩略图div
			sliderBtnBar:'.sliderBtnBar',//按钮div
			ClipArr:[]//缩略图数组
		}; 
		var opts = $.extend(defaults, opts); 
		var testPaperSize=0;
		var page=0;//当前页面

		return this.each(function() {
			var _this=$(this);
			var imgSize=_this.find('.testPaperWrap li').size();//翻页
			_this.find('.testPaperSlideList').css("width",imgSize*opts.width);
			for(var i=0; i<imgSize; i++){
			  $(opts.sliderBtnBar).append('<a>'+(i+1)+'</a>');
			}
			//插入缩略图
			if(opts.ClipArr.length>0){
				var html='<div class="slidClipWrap"><div class="slidClipArea"></div></div>';
				if(opts.ClipArr.length>6){
					html='<span onselectstart="return false" class="ClipPrevBtn">prev</span>'+html+'<span onselectstart="return false" class="ClipNextBtn">next</span>';
				}
				$(opts.slidClip).append(html);
			  	for(var i=0; i<imgSize; i++){
					$(opts.slidClip).find('.slidClipArea').append('<a><img src="'+opts.ClipArr[i]+'"/></a>');
				}
			}
			var slidClipArea=$(opts.slidClip).find('.slidClipArea');
			var Clip_width=slidClipArea.children('a').width()+13;
			var slidClipArea_width=Clip_width*opts.ClipArr.length;
			var slidClipWrap_width=$(opts.slidClip).find('.slidClipWrap').width();
			var ClipNextBtn=$(opts.slidClip).find('.ClipNextBtn');
			var ClipPrevBtn=$(opts.slidClip).find('.ClipPrevBtn');
			var veiw_img_size=Math.round(slidClipWrap_width/Clip_width);//可视区可显示图片数量;
			
			
			//图片垂直居中
			var imgs=_this.find('img');
				imgs.each(function(index, element) {
					var li_h,img_h;
					/*$(this).load(function(){
						li_h=$(this).parents('.testPaperWrap').height();
						img_h=$(this).height();
						if(img_h<li_h)$(this).css('margin-top',(li_h-img_h)/2);//图片增加偏移
					})*/
					$(this).load(function(){
						li_h=$(this).parents('.testPaperWrap').height();
						img_h=$(this).height();
						if(img_h<li_h)$(this).parent('li').css('top',(li_h-img_h)/2);//li增加偏移
					})
					
                });
			slidClipArea.css('width',slidClipArea_width);
			
			//如果传入id,显示指定图片
			if(opts.img_id!=""){
				page=_this.find('[name='+opts.img_id+']').index();
				if(page>=0){
					$(opts.sliderBtnBar+' a:eq('+page+'),'+opts.slidClip+' a:eq('+page+')').addClass('ac');
					$(_this.find('ul')).css({"left":-opts.width*page});//大图
					location_clip();
				}
				else page=0;
			}
			function current(){//确定当前页
				_this.find('li').eq(page).addClass('current').siblings().removeClass('current');
				$(opts.sliderBtnBar+' a').eq(page).addClass('ac').siblings().removeClass('ac');
				$(opts.slidClip+' a').eq(page).addClass('ac').siblings().removeClass('ac');
				$(opts.pageCount).text('共'+imgSize+'页,第'+(page+1)+'页');
			}
			function location_clip(){
				var location=page;
				if(location>veiw_img_size && location>(imgSize-veiw_img_size) ){
					location=(imgSize-veiw_img_size);//控制显示边界
				} 
				else if(location<veiw_img_size) location=0;
				//else location=page;
				
				slidClipArea.stop().animate({"left":-Clip_width*location},300);
			}
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
			}
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
	}
});
})(jQuery);


//弹出窗口----------------------------------------------------------------------------
var popBox={};

//操作错误提示（自动关闭）
popBox.errorBox=function(txt){
	$('.errorBox').remove();
	var text=txt || "出错啦!";
	var top=$(document).scrollTop();
	var sW=$(document).width()/2;
	$('body').append('<div id="errorBox" class="popBox errorBox hide">'+text+'</div>');
	var boxW=-($('.errorBox').width()/2);
	var boxH=$('.errorBox').height();
	$('.errorBox').css({'top':top,'margin-left':boxW,'left':sW});
	/*$('.errorBox').show().animate({'top':top+boxH,opacity:.9}).delay(1500).fadeOut(300, function(){
		$(this).remove();
	});*/
	$('.errorBox').show().animate({'top':top+boxH,opacity:.9});
	var time;
	function autoClear(){
		time=setTimeout(function(){
			$('.errorBox').fadeOut(300, function(){
				$(this).remove();
			});
		},1500);
	}
	autoClear();
	$('.errorBox').hover(
		function(){
			clearTimeout(time);
		},
		function(){
			autoClear()
		}
	)
};


popBox.validation_top=function(form_id){
	var time;
	var top=$(document).scrollTop();
	var sW=$(document).width()/2;
	$('body').append('<div id="validation_errorBox" class="validation_errorBox hide"></div>');
	var boxW=-($('.validation_errorBox').width()/2);
	$('.validation_errorBox').css({'top':top,'margin-left':boxW,'left':sW});
	function errorBox_show(){
		clearTimeout(time);
		time=setTimeout(function(){
			$('.validation_errorBox').fadeOut(100, function(){
				$(this).css({'top':top});
			})
		},1500);
		$('.validation_errorBox').show().animate({'top':top+40,opacity:.9});
	}
	$(form_id).validationEngine({'maxErrorsPerField':1,'onFieldFailure':errorBox_show}); 
};





//成功提示框（自动关闭）
popBox.successBox=function(txt){
	$('.successBox').remove();
	var text=txt || "操作成功!";
	$('body').append('<div class="popBox successBox hide">'+text+'</div>');
	$('.successBox').popBoxShow({"blackBg":false});
	$('.successBox').fadeIn(300).delay(1000).fadeOut(300, function(){
		$(this).remove();
	});
};



//确认提示框
popBox.alertBox=popBox.confirmBox=function(html,trueFn,falseFn){
	var html=html||"你确定吗?";
	var popHtml='<div class="popBox confirmBox" title="确认" style="padding-top:25px">'+html+'</div>';
	$("body").append(popHtml);
	$('.confirmBox').dialog(
		{modal:true,width:300, close:function(){$(this).remove()},
			buttons: [
			{text: "确定",click:function(){$(this).remove();if(trueFn)trueFn()}},
			{text: "取消",click:function(){$(this).remove();if(falseFn)falseFn()}}
			]
		});
};



//添加表情弹窗
popBox.face_imgs=[
		{src:"/pub/images/face/88_thumb.gif",alt:"拜拜"},
		{src:"/pub/images/face/angrya_thumb.gif",alt:"发怒"},
		{src:"/pub/images/face/shamea_thumb.gif",alt:"害羞"},
		{src:"/pub/images/face/bs_thumb.gif",alt:"快哭了"},
		{src:"/pub/images/face/bs2_thumb.gif",alt:"鄙视"},
		{src:"/pub/images/face/bz_thumb.gif",alt:"闭嘴"},
		{src:"/pub/images/face/cj_thumb.gif",alt:"惊恐"},
		{src:"/pub/images/face/cool_thumb.gif",alt:"得意"},
		{src:"/pub/images/face/crazya_thumb.gif",alt:"抓狂"},
		{src:"/pub/images/face/cry.gif",alt:"衰"},
		{src:"/pub/images/face/cza_thumb.gif",alt:"馋"},
		{src:"/pub/images/face/dizzya_thumb.gif",alt:"晕"},
		{src:"/pub/images/face/gza_thumb.gif",alt:"鼓掌"},
		{src:"/pub/images/face/h_thumb.gif",alt:"糗大了"},
		{src:"/pub/images/face/hatea_thumb.gif",alt:"尴尬"},
		{src:"/pub/images/face/hearta_thumb.gif",alt:"爱心"},
		{src:"/pub/images/face/heia_thumb.gif",alt:"偷笑"},
		{src:"/pub/images/face/hsa_thumb.gif",alt:"色"},
		{src:"/pub/images/face/kl_thumb.gif",alt:"可怜"},
		{src:"/pub/images/face/kbsa_thumb.gif",alt:"抠鼻子"},
		{src:"/pub/images/face/laugh.gif",alt:"憨笑"},
		{src:"/pub/images/face/ldln_thumb.gif",alt:"惊讶"},
		{src:"/pub/images/face/lovea_thumb.gif",alt:"飞吻"},
		{src:"/pub/images/face/mb_thumb.gif",alt:"可爱"},
		{src:"/pub/images/face/nm_thumb.gif",alt:"咒骂"},
		{src:"/pub/images/face/ok_thumb.gif",alt:"ok"},
		{src:"/pub/images/face/qq_thumb.gif",alt:"亲亲"},
		{src:"/pub/images/face/sada_thumb.gif",alt:"大哭"},
		{src:"/pub/images/face/sb_thumb.gif",alt:"撇嘴"},
		{src:"/pub/images/face/sleepa_thumb.gif",alt:"睡觉"},
		{src:"/pub/images/face/sleepya_thumb.gif",alt:"困"},
		{src:"/pub/images/face/smilea_thumb.gif",alt:"微笑"},
		{src:"/pub/images/face/yw_thumb.gif",alt:"疑问"},
		{src:"/pub/images/face/yhh_thumb.gif",alt:"右哼哼"},
		{src:"/pub/images/face/zhh_thumb.gif",alt:"左哼哼"},
		{src:"/pub/images/face/t_thumb.gif",alt:"呕吐"},
		{src:"/pub/images/face/yx_thumb.gif",alt:"阴险"},
		{src:"/pub/images/face/unheart.gif",alt:"心碎"},
		{src:"/pub/images/face/wq_thumb.gif",alt:"委屈"},
		{src:"/pub/images/face/x_thumb.gif",alt:"嘘"},
		{src:"/pub/images/face/zy_thumb.gif",alt:"调皮"}
	];
	
popBox.face=function(btn,insertTarget){//添加表情按钮/插入目标
	var html='<div class="faceBox pop"><i class="arrow" style="left:28px"></i>';
			for(var i=0; i<this.face_imgs.length; i++){
				html+='<img src="'+this.face_imgs[i].src+'" alt="['+this.face_imgs[i].alt+']" title="'+this.face_imgs[i].alt+'">'
			}
	html+='</div>';
	$('body').append(html);
	var btnTop=$(btn).offset().top+27;//获取添加表情按钮的坐标
	var btnLeft=$(btn).offset().left-8;
	$('.faceBox').show().css({'position':'absolute','top':btnTop+'px','left':btnLeft+'px','z-index':500});
	$('.faceBox img').click(function(){
		var pos=getCursortPosition($(insertTarget).get(0));
		setCaretPosition($(insertTarget).get(0),pos);
		var alt=$(this).attr('alt');
		$(insertTarget).insertAtCaret(alt);
		$('.faceBox').remove();
		return false;
	})
};

//发私信
popBox.private_new_msg=function(sendName_arr,fun,single){//[{'id':1,'name':'zhangsan'},{'id':3,'name':'李四'}]
    popBox.className ="private_msg";
    var nameList=[];
	var nameItem;
	var userId;
	
	for(var i=0; i<sendName_arr.length;i++ ){
		var obj={};
		obj.label=" "+sendName_arr[i].name;
		obj.value=sendName_arr[i].id;
		nameList.push(obj);
	}
	if(single){
		nameItem='<div style="line-height:40px"><input id="prv_sendName" type="hidden" class="sel" value="'+sendName_arr[0].id+'">'+sendName_arr[0].name+'</div>';
	}else{
		nameItem='<input id="sendName" type="text" class="text ui-autocomplete-input" autocomplete="off" style="width:150px"><input id="prv_sendName" type="hidden" class="sel">';
	}
	
    var html='<div class="popBox private_msg_Box hide" title="发私信">';
    html+='<div class="popCont" style="padding-bottom:10px">';
    html+='<div class="form_list clearfix">';
    html+='<div class="row">';
    html+='<div class="formL"><label>收信人：</label></div><div class="formR">'+nameItem+'</div></div>';
    html+='<div class="row"><div class="formL"><label>内　容：</label></div>';
    html+='<div class="formR">';
    html+='<div class="textareaBox">';
    html+='<textarea class="textarea"></textarea>';
    html+='<div class="btnArea">';
    html+='<span class="addFace"><i class="addFaceBtn"></i>表情</span>';
    html+='<em class="txtCount">可以输入 <b class="num">300</b> 字</em>';
    html+='<button type="button" style="right:-3px" class="sendBtn">发送</button>';
    html+='</div>';
    html+='</div>';
    html+='</div></div></div>';
    html+='</div></div>';
    $('body').append(html);
	
    $('.textareaBox textarea').charCount({'num':300});
    $('.private_msg_Box').dialog({
        autoOpen: false,
        width:550,
        modal: true,
        resizable:false,
        close:function(){$('.private_msg_Box').remove()}
    });
    $( ".private_msg_Box" ).dialog("open");
	
	//自动完成
	$('#sendName').autocomplete({
		"source":nameList,
		"minChars":0,
		select:function(event, ui){
			userId=ui.item.value;
			ui.item.value=ui.item.label;
			$('#prv_sendName').val(userId);
		}
	});
	$('#sendName').blur().placeholder({value:"按 <空格键> 显示全部名单",ie6Top:10});
	
	
    $('.private_msg_Box .sendBtn').unbind('click').click(function(){
        if(fun){fun($('.private_msg_Box'));}
    });
};
	
	

//上传头像
var Jcrop_api;
popBox.uploadPic=function(){
    if (typeof Jcrop_api != 'undefined') {
        Jcrop_api.destroy();
        Jcrop_api=null;
    }

     Jcrop_api = $.Jcrop('#xuwanting',{
        setSelect: [0,0,100,100],
        onChange:showPreview,
        onSelect:showPreview,
        aspectRatio:1
    });
    var picSrc = $('#xuwanting').attr('src');

    $("#crop_preview230").attr("src", picSrc);
    $("#crop_preview70").attr("src", picSrc);
    $("#crop_preview50").attr("src", picSrc);

	function showPreview(coords){
		if(parseInt(coords.w)>0){
			var rx230 = $("#preview_box230").width() / coords.w; 
			var ry230 = $("#preview_box230").height() / coords.h;
			var rx70 = $("#preview_box70").width() / coords.w; 
			var ry70 = $("#preview_box70").height() / coords.h;
			var rx50 = $("#preview_box50").width() / coords.w; 
			var ry50 = $("#preview_box50").height() / coords.h;



			$("#jcrop_x1").val(coords.x);
			$("#jcrop_y1").val(coords.y);
			$("#jcrop_x2").val(coords.x2);
			$("#jcrop_y2").val(coords.y2);
			$("#jcrop_w").val(coords.w);
			$("#jcrop_h").val(coords.h);

			//通过比例值控制图片的样式与显示
			$("#crop_preview230").css({
				width:Math.round(rx230 * $("#xuwanting").width()) + "px",height:Math.round(rx230 * $("#xuwanting").height()) + "px",	marginLeft:"-" + Math.round(rx230 * coords.x) + "px",marginTop:"-" + Math.round(ry230 * coords.y) + "px"});

			$("#crop_preview70").css({width:Math.round(rx70 * $("#xuwanting").width()) + "px",height:Math.round(ry70 * $("#xuwanting").height()) + "px",marginLeft:"-" + Math.round(rx70 * coords.x) + "px",marginTop:"-" + Math.round(ry70 * coords.y) + "px"});

			$("#crop_preview50").css({width:Math.round(rx50 * $("#xuwanting").width()) + "px",height:Math.round(ry50 * $("#xuwanting").height()) + "px",marginLeft:"-" + Math.round(rx50 * coords.x) + "px",marginTop:"-" + Math.round(ry50 * coords.y) + "px"});
		}
	}
};



//知识树
popBox.pointTree=function(zNodes,clickBtn,title,treeCls,fn){
	//zNodes:树(数组)  clickBtn:调用按钮  title:弹框标题 treeCls:树类型(知识树/章节 fn:回调函数)
	var boxTitle=title || "知识树";
	var pa;
	treeCls? pa=clickBtn.parent('.'+treeCls+'TreeWrap') : pa=clickBtn.parent('.treeParent');
	var pointList;//已选中li集合
	var id_arr=[];
	id_arr.length=0;
	var hidVal=pa.find('.hidVal');
	if($(hidVal).val()!=""){
		id_arr=(hidVal.val()).split(',');//读取隐藏域的id
	}
	
	for(var i=0; i<zNodes.length; i++){//清除zNodes所有checked
		zNodes[i].checked=false;
	}
	if(id_arr.length>0){
		for(var i=0; i<id_arr.length; i++){//重新为zNodes添加checked
			for(var j=0; j<zNodes.length; j++){
				if(zNodes[j].id==id_arr[i]){
					zNodes[j].checked=true;
				}
			}
		}
		pointList=pa.find('.labelList').children('li').clone();	
	}
	
	//生成树
	var html='<div id="treeBox" class="popBox treeBox hide" title="'+boxTitle+'">';
	html+='<ul id="treeList" class="clearfix ztree"></ul>';
	html+='<hr><div class="chooseLabel hide"><h6>已选中:</h6>';
	html+='<ul class="labelList clearfix"></ul>';
	html+='</div></div>';
	$("#treeBox").remove();
	$('body').append(html);	
	
	var setting = {
		check:{enable:true,chkboxType:{"Y" : "", "N" : ""} },
		data:{simpleData: {	enable: true} },
		callback: {onCheck:zTreeOnCheck},
		view:{showIcon:false,showLine:false}
	};
	var treeObj=$.fn.zTree.init($("#treeList"), setting, zNodes);
	
	//自动展开一级
	var nodes = treeObj.getNodes();
	if (nodes.length>0) {
		treeObj.expandNode(nodes[0], true,false, false);
	}
	
	
	
	
	
	$('#treeBox').dialog({
		autoOpen:false,
		width:500,
		modal: true,
		close:function(){ $(this).remove()},
		resizable:false,
		buttons: [
			{
				text: "确定",
				click: function() {
					clickOKBtn();//点击ok的函数
					 $(this).remove(); 
				}
			},
			{
				text: "取消",
				click: function() {
					 $(this).remove(); 
				} 
			}
		]
	});	
	if(id_arr.length>0){
		$('#treeBox .chooseLabel').show();
		$('#treeBox .labelList').empty().append(pointList);
	}
	$( "#treeBox" ).dialog( "open" );



//点击树上的checkbox
	function zTreeOnCheck(event, treeId, treeNode){
		if(treeNode.checked==true){
			$('#treeBox .chooseLabel').show();
			$('#treeBox .labelList').append('<li val="'+treeNode.id+'"  index="'+treeNode.tId+'">'+treeNode.name+'</li>');
			return false;
		}
		else{
			$('#treeBox .labelList li[val='+treeNode.id+']').remove();
			if($('#treeBox .labelList li').size()<1){
				$('#treeBox .chooseLabel').hide();
			}
			return false;
			}
	}
	
	//点击ok按钮
	function clickOKBtn(){
		id_arr.length=0;
		var newLi=$('.treeBox .labelList li');
		if(newLi.length>0){
			for(var i=0; i<newLi.length; i++){
				id_arr.push($(newLi).eq(i).attr('val'));
			}
			hidVal.val(id_arr);
			pa.find('.pointArea').show();
			pa.find('.labelList').empty().append(newLi);
		}
		else{
			pa.find('.pointArea').hide();
			pa.find('.labelList').empty();
			hidVal.val('');
		}
	}
};



//知识树2
popBox.pointTree2=function(zNodes,clickBtn,title){
	$(clickBtn).each(function(index, element) {
		var boxTitle=title || "知识树";
		var checkArr=[];//存放被选中的zNodes对
		var pointList;//知识点li集合
		var pa=$(this).parent('.treeParent');//按钮的父级
		var old_pointArea=$(this).next('.pointArea');
		var id_arr=[];
		id_arr.length=0;
		if(old_pointArea.children('.hidVal').val()!=""){
			id_arr=(old_pointArea.children('.hidVal').val()).split(',');//读取隐藏域的id
		}
		
		function reset_zNodes(){//将zNodes全部取消checked
			for(var i=0; i<zNodes.length; i++){
				if(zNodes[i].checked){
					zNodes[i].checked=false;
				}
			}
		}
		
		function check(){//初始化已选中节点
			reset_zNodes();
			
			//将id_arr里面的id,匹配到zNodes上面
			if(id_arr.length>0){
				for(var i=0; i<id_arr.length; i++){
					for(var j=0; j<zNodes.length; j++){
						if(zNodes[j].id==id_arr[i]){
							zNodes[j].checked=true;
							checkArr.push(zNodes[j]);
						}
					}
				}	
			}
			
			if(checkArr.length>0){
				old_pointArea.show();
				old_pointArea.children('ul').empty();
				for(var i=0;i<checkArr.length;i++){
					old_pointArea.children('ul').append('<li val="'+checkArr[i].id+'" >'+checkArr[i].name+'</li>');
				}
				old_pointArea.children('.hidVal').val(id_arr);//保存id
				pointList=$(old_pointArea).children('ul').children('li').clone();
			}
			else{
				old_pointArea.hide();
				old_pointArea.children('ul').empty();
				old_pointArea.children('.hidVal').val('');
			}
		}
		check();
	
		//点击按钮,弹出ztree窗口
		$(this).click(function(){
			//重置zNodes
			var old_pointArea=$(this).nextAll('.pointArea');
			var id_arr=[];
			id_arr.length=0;
			if(old_pointArea.children('.hidVal').val()!=""){
				id_arr=(old_pointArea.children('.hidVal').val()).split(',');//读取隐藏域的id
			}
			reset_zNodes();
			if(id_arr.length>0){//将id_arr里面的id,匹配到zNodes上面
				for(var i=0; i<id_arr.length; i++){
					for(var j=0; j<zNodes.length; j++){
						if(zNodes[j].id==id_arr[i]){
							zNodes[j].checked=true;
						}
					}
				}

			}
			//生成树
			var html='<div id="treeBox" class="popBox treeBox hide" title="'+boxTitle+'">';
			html+='<ul id="treeList" class="clearfix ztree"></ul>';
			html+='<hr><div class="chooseLabel hide"><h6>已选中:</h6>';
			html+='<ul class="labelList clearfix"></ul>';
			html+='</div></div>';
			$("#treeBox").remove();
			$('body').append(html);	
			
			var setting = {
				check:{enable:true,chkboxType:{"Y" : "", "N" : ""} },
				data:{simpleData: {	enable: true} },
				callback: {onCheck:zTreeOnCheck},
				view:{showIcon:false,showLine:false}
			};
			$.fn.zTree.init($("#treeList"), setting, zNodes);
			$('#treeBox').dialog({
				autoOpen:false,
				width:500,
				close:function(){ $(this).remove()},
				modal: true,
				resizable:false,
				buttons: [
					{
						text: "确定",
						click: function() {
							clickOKBtn();//点击ok的函数
							 $(this).remove(); 
						}
					},
					{
						text: "取消",
						click: function() {
							 $(this).remove(); 
						} 
					}
				]
			});	
			if(id_arr.length>0){
				$('#treeBox .chooseLabel').show();
				$('#treeBox .labelList').empty().append(pointList);
			}
			$( "#treeBox" ).dialog( "open" );
		});
	
	
	//点击树上的checkbox
		function zTreeOnCheck(event, treeId, treeNode){
			if(treeNode.checked==true){
				$('#treeBox .chooseLabel').show();
				$('#treeBox .labelList').append('<li val="'+treeNode.id+'"  index="'+treeNode.tId+'">'+treeNode.name+'</li>');
				return false;
			}
			else{
				$('#treeBox .labelList li[val='+treeNode.id+']').remove();
				if($('#treeBox .labelList li').size()<1){
					$('#treeBox .chooseLabel').hide();
				}
				return false;
				}
		}
		
		//点击ok按钮
		function clickOKBtn(){
			checkArr.length=0;
			id_arr.length=0;
			var newLi=$('.treeBox .labelList li');
			if(newLi.size()>0){
				for(var j=0;j<zNodes.length; j++){//清除zNodes上的所有checked
					zNodes[j].checked=false;
				}
				for(var i=0; i<newLi.length;i++){
					for(var j=0;j<zNodes.length; j++){
						if(zNodes[j].id==$(newLi[i]).attr('val')){
							zNodes[j].checked=true;
							id_arr.push(zNodes[j].id);
						}
					}
				}
			}
			check();
		}		
	});
};

//题目纠错
popBox.errorCorrect_topic=function(id){
		var inputItems='<input type="checkbox" class="chked hide" id="ch4" name="act_type" value="题目类型">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch4">题目类型</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch5" name="act_type" value="题目答案">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch5">题目答案</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch6" name="act_type" value="题目解析">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch6">题目解析</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch7" name="act_type" value="题目知识点">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch7">题目知识点</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch8" name="act_type" value="其他">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch8">其他</label>';
		inputItems+='<input type="hidden" name="errorType" id="errorType" value=""/>';
		inputItems+='<input type="hidden" name="questionId" id="questionId" value=""/>';
	
	var html='<div id="errorCorrectBox" class="popBox errorCorrectBox hide" title="题目纠错">';
        html+='<div class="popCont  work_form_list">';
            html+='<div class="new_tch_group">';
                html+='<form id="errorCorrect_form">';
                    html+='<div class="form_list">';
                        html+='<div class="row">';
                            html+='<div class="formL">';
                                html+='<label>错误类型:</label>';
                            html+='</div>';
                            html+='<div class="formR personal topic_opt">'+inputItems+'</div>';
                        html+='</div>';
                        html+='<div class="row">';
                            html+='<div class="formL">';
                                html+='<label>错误描述:</label>';
                            html+='</div>';
                            html+='<div class="formR">';
                            html+='<div class="textareaBox text_correction">';
                                html+='<textarea id="errorCorrect_textarea" class="textarea" name="brief"></textarea>';
                                html+='<div class="btnArea" style="margin:0">';
                                html+='<em class="txtCount" style="right:10px; font-size:12px">可以输入 <b class="num">300</b> 字</em>';
                                html+='</div>';
                            html+='</div>';
                            html+='</div>';
                        html+='</div>';
                    html+='</div>';
                html+='</form>';
            html+='</div>';
			html+='</div>';
			html+='<div class="popBtnArea">';
        	html+='<button id="errorCorrectSendBtn" type="button" class="okBtn">确定</button>';
        	html+='<button type="button" class="cancelBtn">取消</button>';
    		
        html+='</div>';
    html+='</div>';
	$('body').append(html);
	
    $('.errorCorrectBox').dialog({
        autoOpen: false,
        width:700,
        modal: true,
        resizable:false,
        close:function(){$(this).remove()}
    });
    $( ".errorCorrectBox" ).dialog("open");
	$('.textareaBox textarea').charCount({'num':500}).blur().placeholder({'value':"请输入错误描述！",top:10,left:10});
	//取消
	$('.popBox .cancelBtn').click(function(){
		$('.errorCorrectBox').remove()
	});
	
	//确定
	$("#questionId").attr("value",id);
	$('#errorCorrectSendBtn').unbind('click').click(function(){
		 var len = $('.topic_opt input:checkbox:checked');
		if (len.length == 0 ) {
			popBox.errorBox('请选择错误类型');
			return false;
		}
		else{
			var value = '';
			len.each(function(){
				value+=$(this).val() + ',';
			});
			$('#errorType').val(value);
		}
		 $.post('/teacher/searchquestions/question-error', $("#errorCorrect_form").serialize(),
		 function (data) {
			if(data.success){
				$('.errorCorrectBox').remove();
				popBox.successBox("非常感谢您的纠错，我们会持续改进的。");
			}else{
				popBox.errorBox(data.message);
			}
		});
	})
};

//资源纠错
popBox.errorCorrect_resources=function(id){
		var inputItems='<input type="checkbox" class="chked hide" id="ch3" value="资源类型">';
		inputItems+='<label class="chkLabel stuZ" for="ch3">资源类型</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch4" value="资源内容">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch4">资源内容</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch5" value="资源知识点">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch5">资源知识点</label>';
		inputItems+='<input type="checkbox" class="chked hide" id="ch7" value="其它">';
		inputItems+='<label class="chkLabel patriarchZ" for="ch7">其它</label>';
		inputItems+='<input type="hidden" name="errorType" id="errorType" value=""/>';
		inputItems+='<input type="hidden" name="materialId" id="materialId" value=""/>';

	var html='<div id="errorCorrectBox" class="popBox errorCorrectBox hide" title="资源纠错">';
        html+='<div class="popCont  work_form_list">';
            html+='<div class="new_tch_group">';
                html+='<form id="errorCorrect_form">';
                    html+='<div class="form_list">';
                        html+='<div class="row">';
                            html+='<div class="formL">';
                                html+='<label>错误类型:</label>';
                            html+='</div>';
                            html+='<div class="formR personal topic_opt">'+inputItems+'</div>';
                        html+='</div>';
                        html+='<div class="row">';
                            html+='<div class="formL">';
                                html+='<label>错误描述:</label>';
                            html+='</div>';
                            html+='<div class="formR">';
                            html+='<div class="textareaBox text_correction">';
                                html+='<textarea id="errorCorrect_textarea" class="textarea" name="brief"></textarea>';
                                html+='<div class="btnArea" style="margin:0">';
                                html+='<em class="txtCount" style="right:10px; font-size:12px">可以输入 <b class="num">300</b> 字</em>';
                                html+='</div>';
                            html+='</div>';
                            html+='</div>';
                        html+='</div>';
                    html+='</div>';
                html+='</form>';
            html+='</div>';
			html+='</div>';
			html+='<div class="popBtnArea">';
        	html+='<button id="errorCorrectSendBtn" type="button" class="okBtn">确定</button>';
        	html+='<button type="button" class="cancelBtn">取消</button>';
    		
        html+='</div>';
    html+='</div>';
	$('body').append(html);
	
    $('.errorCorrectBox').dialog({
        autoOpen: false,
        width:700,
        modal: true,
        resizable:false,
        close:function(){$(this).remove()}
    });
    $( ".errorCorrectBox" ).dialog("open");
	$('.textareaBox textarea').charCount({'num':500}).blur().placeholder({'value':"请输入错误描述！",top:10,left:10});
	//取消
	$('.popBox .cancelBtn').click(function(){
		$('.errorCorrectBox').remove()
	});
	
	//确定
	$("#materialId").attr("value",id);

};



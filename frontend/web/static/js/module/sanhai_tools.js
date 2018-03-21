define(['jquery',"popBox"],function ($,popBox){
	var sanhai_tools={};

	/*radio checkbox*/
	sanhai_tools.input=function(){
		//checkbox
		$('input:checkbox').live('click',function(){
			var _this=$(this);
			var target=_this.parent('label');
			if(_this.attr('disabled')!=true) target.toggleClass('chkLabel_ac');
			else return false;
		});

		//radio
		var radio=$('input:radio');
		radio.each(function(index, element) {
			var _this=$(this);
			if(_this.attr('disabled')){
				_this.parent('label').addClass('chkLabel_disabled');
			}
		});
		$('input:radio').live('click',function(){
			var _this=$(this);
			var target=_this.parent('label');
			var name=_this.attr('name');
			target.addClass('chkLabel_ac');
			if(_this.attr('disabled')!=true){
				$('input:radio[name="'+name+'"]').not(this).each(function() {
					$(this).parent('label').removeClass('chkLabel_ac');
				});
			}
		});
	};

	//每日签到
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
                        $(".signIn").addClass('signIn_on');
                        popBox.errorBox('您已经签到！');
                    }
                }
			}
		})
	};

	//进度条
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


	//答疑添加图片不可挪动
	$('#addimage').mousedown(function(){
		return false;
	});

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
	sanhai_tools.countdown=function(sec,elm,fn){//秒 元素 回调函数
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
	};
	//判断浏览器版本
	sanhai_tools.isIE=function(ver){
		var b = document.createElement('b');
		b.innerHTML = '<!--[if IE ' + ver + ']><i></i><![endif]-->';
		return b.getElementsByTagName('i').length === 1
	};
	/*if(isIE()){alert('ie6:' + isIE(6) + '\n' + 'ie7:' + isIE(7) + '\n' + 'ie8:' + isIE(8) + '\n' + 'ie9:' + isIE(9) + '\n' + 'ie:' + isIE())}*/

	return sanhai_tools;

});





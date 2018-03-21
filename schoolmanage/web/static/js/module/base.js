define(['sanhai_tools'],function (sanhai_tools){
	$(document).bind("mouseup",function(e){var target=$(e.target);if(target.closest(".pop").length==0)$(".pop").hide()});//点击空白 关闭弹出窗口
	$("body").append('<div class="backTop hide"></div>');//返回顶部
	$('.foot i').click(function(){//二维码
		$(this).children('.QRCord').show();
		return false;
	});
	$(document).on('mouseover','table tbody tr',function(){//表格隔行变色
		$(this).addClass('trOver');
	}).on('mouseout','table tbody tr',function(){
		$(this).removeClass('trOver');
	})
});




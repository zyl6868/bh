/**
 * Created by gaoling on 2016/3/25.
 */

define([],function() {
//回答答疑可以继续添加的剩余图片的计算
	function leftImg(e) {
		var _this = $(e);
		var liSize = _this.parents(".form_r").find('.picList li').length;
		$('.uploadFileBtn').find('span').html(2 - liSize);
		if (liSize > 1) {
			$(".disabled").hide();
		} else {
			$('.disabled').show();
		}
	}

	$(document).on('click', '.delBtn', function () {
		$(this).parent().remove();
		leftImg();
	});

	return {leftImg: leftImg};

})
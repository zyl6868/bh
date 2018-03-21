define(['jquery', 'popBox', 'ZeroClipboard', 'jquery_sanhai', 'validationEngine', 'validationEngine_zh_CN'],
	function ($, popBox, ZeroClipboard) {
		window['ZeroClipboard'] = ZeroClipboard;
		$('#answer_form').validationEngine();
		$('.UPloadFil ul').sortable({items: "li:not(.disabled)"});
		//添加和编辑答疑可以继续添加的剩余图片的计算
		function leftPicCal() {
			var liSize = $('.UPloadFil').find('li').size();
			//alert(liSize);
			$('.upload_FileBtn').find('span').html(7 - liSize);

			if (liSize == 7) {
				$('.upload_FileBtn').hide();
			} else {
				$('.upload_FileBtn').show();
			}
		}

		leftPicCal();
		$('.remove_images').live('click', function () {
			$(this).parent('li').remove();
			window.img_num++;
			$(".addPicUl li").css('display', 'block');
			leftPicCal();
		});
		return {leftPicCal: leftPicCal}
	});

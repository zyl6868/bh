// JavaScript Document
$(function(){
	var knowledge=$('.knowledge');
	if(knowledge.size()>0){
		knowledge.prepend('<div class="fixedClone" style="width:230px; margin-right:10px; height:100px;float:left; display:none"></div>');
		var fixTop=knowledge.position().top-60;
		function change_tree_height(){
			var windowH=$(window).height();
			var right_h=$('.problem_r').height();
			var problem_tree_cont=$('.problem_tree_cont');
			var problem_tree=$('#problem_tree').css('overflow','auto');
			if(right_h<windowH){
			problem_tree_cont.css({"height":400});
			problem_tree.css('height',360);
		}
		else{
			problem_tree_cont.css({"height":windowH-190});
			problem_tree.css('height',windowH-230);
		}
			var scrollTop=$(window).scrollTop();
			if(scrollTop>fixTop){
				$('.problem_tree_cont').css({"position":"fixed","top":55, "width":228}).addClass('ie7fixed');
				$('.problem_box .fixedClone').show();
			}else{
				$('.problem_tree_cont').css({"position":"relative","top":"auto","width":"auto"}).removeClass('ie7fixed');
				$('.problem_box .fixedClone').hide();
			}
		}
		$(window).resize(function(){
			change_tree_height()
		});
		
		$(window).scroll(function(){
			change_tree_height()	
		});
	}
});
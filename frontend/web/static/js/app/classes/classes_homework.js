/**
 * Created by gaoling on 2016/1/7.
 */
define(["popBox",'jquery_sanhai','jqueryUI'],function(popBox){
	$('#reply_tab').tab();
	$(".classes_sel_list").sel_list('single');
//单选
	$('.classes_file_list .row').openMore(36);
	$('#classes_sel_list ul a').click(function(){
		var txt=$(this).text();
		$('#classes_file_crumbs').append('<span>学科:<em>'+txt+'</em><i>×</i></span>');

	});
//班级 教师作业 页面 科目筛选
	$('.subject_list').live('click',function(){
		var subjectId = $(this).attr('subject');
		var classId = $("#classes_sel_list").attr('cl');
		var url = '/class/homework';
		$.get(url,{ subjectId: subjectId ,classId:classId},function(data){
			$(".classbox").html(data);
		})
	})

});

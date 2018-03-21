define(function(){

//弹出窗口----------------------------------------------------------------------------

//关闭弹窗
	$(document).on('click','.popBox .cancelBtn',function(){
		$(this).parents('.popBox').dialog("close");
	});

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
	$('.errorBox').show().animate({'top':top+boxH,opacity:.9});
	var time;
	function autoClear(){
		time=setTimeout(function(){
			$('.errorBox').fadeOut(300, function(){
				$(this).remove();
			});
		},1500);
	};
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
	};
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

//警告框
	popBox.alertBox=function(txt){
		var html=html||"你确定吗?";
		var popHtml='<div class="popBox confirmBox" title="提示" style="padding-top:20px">'+txt+'</div>';
		$("body").append(popHtml);
		$('.confirmBox').dialog(
			{modal:true,width:300, close:function(){$(this).remove()},
				buttons: [
					{text: "确定",click:function(){$(this).remove()}}
				]
			});
	};


//确认提示框
popBox.confirmBox=function(html,trueFn,falseFn){
	var html=html||"你确定吗?";
	var popHtml='<div class="popBox confirmBox" title="确认" style="padding-top:20px">'+html+'</div>';
	$("body").append(popHtml);
	$('.confirmBox').dialog(
		{modal:true,width:300, close:function(){$(this).remove()},
			buttons: [
			{text: "确定",click:function(){$(this).remove();trueFn && trueFn()}},
			{text: "取消",click:function(){$(this).remove();falseFn && falseFn()}}
			]
		});
};



//添加表情弹窗
popBox.face_imgs=[
		{src:"/dev/images/face/88_thumb.gif",alt:"拜拜"},
		{src:"/dev/images/face/angrya_thumb.gif",alt:"发怒"},
		{src:"/dev/images/face/shamea_thumb.gif",alt:"害羞"},
		{src:"/dev/images/face/bs_thumb.gif",alt:"快哭了"},
		{src:"/dev/images/face/bs2_thumb.gif",alt:"鄙视"},
		{src:"/dev/images/face/bz_thumb.gif",alt:"闭嘴"},
		{src:"/dev/images/face/cj_thumb.gif",alt:"惊恐"},
		{src:"/dev/images/face/cool_thumb.gif",alt:"得意"},
		{src:"/dev/images/face/crazya_thumb.gif",alt:"抓狂"},
		{src:"/dev/images/face/cry.gif",alt:"衰"},
		{src:"/dev/images/face/cza_thumb.gif",alt:"馋"},
		{src:"/dev/images/face/dizzya_thumb.gif",alt:"晕"},
		{src:"/dev/images/face/gza_thumb.gif",alt:"鼓掌"},
		{src:"/dev/images/face/h_thumb.gif",alt:"糗大了"},
		{src:"/dev/images/face/hatea_thumb.gif",alt:"尴尬"},
		{src:"/dev/images/face/hearta_thumb.gif",alt:"爱心"},
		{src:"/dev/images/face/heia_thumb.gif",alt:"偷笑"},
		{src:"/dev/images/face/hsa_thumb.gif",alt:"色"},
		{src:"/dev/images/face/kl_thumb.gif",alt:"可怜"},
		{src:"/dev/images/face/kbsa_thumb.gif",alt:"抠鼻子"},
		{src:"/dev/images/face/laugh.gif",alt:"憨笑"},
		{src:"/dev/images/face/ldln_thumb.gif",alt:"惊讶"},
		{src:"/dev/images/face/lovea_thumb.gif",alt:"飞吻"},
		{src:"/dev/images/face/mb_thumb.gif",alt:"可爱"},
		{src:"/dev/images/face/nm_thumb.gif",alt:"咒骂"},
		{src:"/dev/images/face/ok_thumb.gif",alt:"ok"},
		{src:"/dev/images/face/qq_thumb.gif",alt:"亲亲"},
		{src:"/dev/images/face/sada_thumb.gif",alt:"大哭"},
		{src:"/dev/images/face/sb_thumb.gif",alt:"撇嘴"},
		{src:"/dev/images/face/sleepa_thumb.gif",alt:"睡觉"},
		{src:"/dev/images/face/sleepya_thumb.gif",alt:"困"},
		{src:"/dev/images/face/smilea_thumb.gif",alt:"微笑"},
		{src:"/dev/images/face/yw_thumb.gif",alt:"疑问"},
		{src:"/dev/images/face/yhh_thumb.gif",alt:"右哼哼"},
		{src:"/dev/images/face/zhh_thumb.gif",alt:"左哼哼"},
		{src:"/dev/images/face/t_thumb.gif",alt:"呕吐"},
		{src:"/dev/images/face/yx_thumb.gif",alt:"阴险"},
		{src:"/dev/images/face/unheart.gif",alt:"心碎"},
		{src:"/dev/images/face/wq_thumb.gif",alt:"委屈"},
		{src:"/dev/images/face/x_thumb.gif",alt:"嘘"},
		{src:"/dev/images/face/zy_thumb.gif",alt:"调皮"}
	];
	
popBox.face=function(btn,insertTarget){//添加表情按钮/插入目标
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
	};

	//设置光标位置
	function setCaretPosition(ctrl, pos){
		if(ctrl.setSelectionRange) {
			ctrl.focus();
			ctrl.setSelectionRange(pos,pos);
		}
		else if (ctrl.createTextRange) {
			var range = ctrl.createTextRange(); range.collapse(true); range.moveEnd('character', pos); range.moveStart('character', pos); range.select();
		}
	};

	var html='<div class="faceBox pop"><i class="arrow" style="left:28px"></i>';
			for(var i=0; i<this.face_imgs.length; i++){
				html+='<img src="'+this.face_imgs[i].src+'" alt="['+this.face_imgs[i].alt+']" title="'+this.face_imgs[i].alt+'">'
			};
		html+='</div>';
	$('body').append(html);
	var btnTop=$(btn).offset().top+27;//获取添加表情按钮的坐标
	var btnLeft=$(btn).offset().left-8;
	//var insertTarget=$('.sendspop textarea')
	$('.faceBox').show().css({'position':'absolute','top':btnTop+'px','left':btnLeft+'px','z-index':500});
	$('.faceBox img').click(function(){
		var _this=$(this)
		var pos=getCursortPosition($(insertTarget).get(0));
		setCaretPosition($(insertTarget).get(0),pos);
		var alt=$(this).attr('alt');
		insertTarget.insertAtCaret(alt);
		$('.faceBox').remove();
		return false;
	})
};

popBox.private_msg=function(sendName_arr,fn,single){//[{'id':1,'name':'zhangsan'},{'id':3,'name':'李四'}]
		var nameList=[];
		var nameItem;
		var userId;

		for(var i=0; i<sendName_arr.length;i++ ){
			var obj={};
			obj.label=" "+sendName_arr[i].name;
			obj.value=sendName_arr[i].id;
			nameList.push(obj);
		};
		if(single){
			nameItem='<div style="line-height:40px"><input id="prv_sendName" type="hidden" class="sel" value="'+sendName_arr[0].id+'">'+sendName_arr[0].name+'</div>';
		}else{
			nameItem='<input id="sendName" type="text" class="text ui-autocomplete-input" autocomplete="off" style="width:150px"><input id="prv_sendName" type="hidden" class="sel">';
		}

		var html='<div id="private_msg_Box" class="popBox private_msg_Box hide" title="发私信">';
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
		$('#sendName').blur().placeholder({value:"按 <空格键> 显示全部名单",ie6Top:10})

		$('.addFaceBtn').live('click',function(){//添加表情
			popBox.face($(this),$('#private_msg_Box textarea'));
			return false;
		});

		$('#private_msg_Box .sendBtn').unbind('click').click(function(){
			fn && fn();
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
	};
	
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
		$('#treeBox .chooseLabel').show()
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
	};
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
			};
		}
		
		function check(){//初始化已选中节点
			reset_zNodes()
			
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
		check()
	
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
			};
		
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
				$('#treeBox .chooseLabel').show()
				$('#treeBox .labelList').empty().append(pointList);
			}
			$( "#treeBox" ).dialog( "open" );
		})
	
	
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
return popBox;
});
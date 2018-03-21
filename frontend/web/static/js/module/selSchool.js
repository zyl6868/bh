// JavaScript Document
if(!window.BH){
	BH = {
		tools:{},
		mod: {},
		dialogs:{},
		index:0
	};		
}
(function(X,$){
	var _index = X.index = 0;
	var tools = X.tools = {
		
	};
	var dialogs = X.dialogs = {
		
		selSchool:function(){
			
		},
		createSchool:function(){
			
		}
		
	}
})(BH,jQuery);

//选择学校弹框
$(function(){
	
});
var urlHttp = '';//'http://192.168.1.105:8383';
var zIndex = 0;
//返回按钮的事件返回区
function backArea(){
	$('.schoolList,.newSchool').hide();
	$('.selectArea dl').hide();
	$('.selectArea dl').eq(2).show().css('display','block');
}
//返回按钮的事件返回城市
function backCity(){
	$('.schoolList,.newSchool').hide();
	$('.selectArea dl').hide();
	$('.selectArea dl').eq(1).show();
	$('.crumbList span').eq(2).removeClass('ac').hide();
	$('.crumbList span').eq(1).addClass('ac').css('display','block');
}
//返回按钮的事件返回省
function backState(){
	$('.schoolList,.newSchool').hide();
	$('.selectArea dl').hide();
	$('.selectArea dl').eq(0).show();
	$('.crumbList span').removeClass('ac').hide();
	$('.crumbList span').eq(0).addClass('ac').css('display','block');
}

//获取省
function getStateHtml(fn){
	var html = '';
	$.ajax({
		url:urlHttp+'/ajax/GetJsonProvinceList',
		type:'GET',
		dataType:"json",
		data:{},
		success: function(msg){
			var msg = msg;
			for(var i=0,_len=msg.length;i<_len;i++){
				html += '<dd id="' + msg[i].AreaID + '">' + msg[i].AreaName + '</dd>';
			}
			$('.selectArea dl').hide();
			$('.stateList').html(html).show();
			var fn = fn || function(){};
			fn();
		}
	});
}
//点击省的列表项，选择省
function selState(id,stateName){
	var _curEl = $('.mySchoolBox .crumbList span').eq(0);
	var _curId = _curEl.attr('data_id');
	$(_curEl).addClass('ac').show();
	$('.mySchoolBox .crumbList a').eq(0).show();
	$('.back_selectArea').removeClass('hide');
	$(_curEl).attr('data_id',id).html(stateName);
	if(_curId == id && $.trim($('.cityList').html())!=''){
		$('.cityList').show();
		$('.stateList,.areaList').hide();
		$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
	}else{
		getCityHtml(id);
	}
}

//获取市
function getCityHtml(id){
	var html = '';
	$.ajax({
		url:urlHttp+'/ajax/GetJsonArea',
		type:'GET',
		dataType:"json",
		data:{'id':id},
		success: function(msg){
			for(var i=0,_len=msg.length;i<_len;i++){
				html += '<dd id=' + msg[i].AreaID + '>' + msg[i].AreaName + '</dd>';
			}
			$('.selectArea dl').hide();
			$('.cityList').html(html).show();
			$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
		},
		error:function(){
			$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
		}
	});
}
//点击市的列表项，选择市
function selCity(id,cityName){
	var _curEl = $('.mySchoolBox .crumbList span').eq(1);
	var _curId = _curEl.attr('data_id');
	$(_curEl).prevAll().removeClass('ac').show();
	$(_curEl).addClass('ac').show();
	$('.mySchoolBox .crumbList a').eq(0).show();
	if(_curId == id && $.trim($('.areaList').html())!=''){
		$('.areaList').show();
		$('.stateList,.cityList').hide();
		$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
	}else{
		$(_curEl).attr('data_id',id).html(cityName);
		getAreaHtml(id);
	}
}
//获取地区列表
function getAreaHtml(id){
	var html = '';
	$.ajax({
		url:urlHttp+'/ajax/GetJsonArea',
		type:'GET',
		dataType:"json",
		data:{'id':id},
		success: function(msg){
			for(var i=0,_len=msg.length;i<_len;i++){
				html += '<dd id=' + msg[i].AreaID + '>' + msg[i].AreaName + '</dd>';
			}
			$('.selectArea dl').hide();
			$('.areaList').html(html).show();
			$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
		},
		error:function(){
			$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');	
		}
	});
}
//点击地区的列表项，选择地区
function selArea(id,areaName,departmentEl){
	var _curEl = $('.mySchoolBox .crumbList span').eq(2);
	var _curId = _curEl.attr('data_id');
	$(_curEl).prevAll().removeClass('ac').show();
	$(_curEl).addClass('ac').show();
	$('.mySchoolBox .crumbList a').eq(0).show();
	$(_curEl).attr('data_id',id).html(areaName);
	getSchool(id,departmentEl);
}
//按地区搜索学校
function getSchool(county,departmentEl){
	var html = '';
	$.ajax({
		url:urlHttp+'/register/newSearchSchoolInfo',
		type:'GET',
		dataType:'html',
		data:{'county':county,'department':$(departmentEl).val()},
		success: function(msg){
			var msg = msg || '<div class="tc" style="padding:10px 0 40px;">没有检索到相应的学校，点击<a class="listCreateNew" href="javas' + 'cript:;">创建新学校</a></div>';
				html += msg;
			$('.creatNewSchool').show();
			$('.schoolList').html(html).show();
			$('.selectArea dl').hide();
			$('.newSchool').hide();
			$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
		},
		error:function(){
			$('.stateList dd,.cityList dd,.areaList dd,.back_selectArea').removeClass('noClick');
		}
	});

}
//按搜索项搜索学校
function searchSchool(searchWord,departmentEl){
	var html = '';
	$.ajax({
		url:urlHttp+'/register/newSearchSchoolInfo',
		type:'GET',
		dataType:'html',
		data:{'name':searchWord,'department':$(departmentEl).val()},
		success: function(msg){
			var msg = msg || '<div class="tc" style="padding:10px 0 40px;">没有检索到相应的学校，点击<a class="createNewBtn" href="javas' + 'cript:;">创建新学校</a></div>';
			html += msg;
			$('.schoolList').html(html).show();
			$('.selectArea dl,.newSchool,.creatNewSchool').hide();
			$('.crumbList span,.crumbList a').hide();
			$('.crumbList .back_top').show();
			$('.searchBtn').removeClass('noClick');
		},
		error:function(){
			$('.searchBtn').removeClass('noClick');
		}
	});
}
//选择学校
function selSchool(el){
	$(el).siblings().removeClass('ac');
	$(el).addClass('ac');
}
//新建学校
function createSchool(departmentEl){
	var html = '';
		html+= '';
		html+= '<div id="addSchool" action="/register/addSchool">';
            html+= '<div class="form_list">';
                html+= '<div class="row">';
                    html+= '<div class="formL">';
                        html+= '<label>学校名称</label>';
                    html+= '</div>';
                    html+= '<div class="formR">';
                        html+= '<input type="text" data-prompt-position="inline" data-prompt-target="schoolName_prompts" data-errormessage-value-missing="学校名称不能为空" data-validation-engine="validate[required,maxSize[30]]" name="name" class="text">';
                        html+= '<span class="errorTxt" id="schoolName_prompts"></span>';
                    html+= '</div>';
                html+= '</div>';
                html+= '<div class="row">';
                    html+= '<div class="formL">';
                        html+= '<label>学部设置</label>';
                    html+= '</div>';
                    html+= '<div class="formR checkboxArea">';
                        html+= '<span id="department">';
						html+= '<input type="checkbox" name="department[]" id="department_0" value="20201" data-prompt-position="inline" data-prompt-target="departments_prompt" data-errormessage-value-missing="学部不能为空" data-validation-engine="validate[required]" class="checkbox hide"><label class="chkLabel" for="department_0">小学</label>';
						html+= '<input type="checkbox" name="department[]" id="department_1" value="20202" data-prompt-position="inline" data-prompt-target="departments_prompt" data-errormessage-value-missing="学部不能为空" data-validation-engine="validate[required]" class="checkbox hide"><label class="chkLabel" for="department_1">初中</label>';
						html+= '<input type="checkbox" name="department[]" id="department_2" value="20203" data-prompt-position="inline" data-prompt-target="departments_prompt" data-errormessage-value-missing="学部不能为空" data-validation-engine="validate[required]" class="checkbox hide"> <label class="chkLabel" for="department_2">高中</label>';
						html+= '</span>';
						html+= '<span class="errorTxt" id="departments_prompt"></span>';
                    html+= '</div>';
                html+= '</div>';
                html+= '<div class="row sel_stu_system">';
                    html+= '<div class="formL">';
                        html+= '<label>学校学制</label>';
                    html+= '</div>';
                    html+= '<div class="formR"> <span class="selectWrap big_sel">';
                            html+= '<i></i><em>请选择</em><select id="lengthOfSchooling" name="lengthOfSchooling"><option value="20501">六三学制</option><option value="20502">五四学制</option><option value="20503">五三学制</option></select>';
							html+= '</span> <span class="errorTxt" id=""></span>';
					html+= '</div>';
                html+= '</div>';
            html+= '</div>';
        html+= '</form>	';
		
		$('.newSchool').html(html).show();
		$('.creatNewSchool').hide();
		$('.selectArea dl').hide();
		$('.schoolList').hide();
		setDepart($(departmentEl).val());
		toggleSystem();
}

//设置学部与学制的隐藏显示
function setDepart(val){
	var el = $('.newSchool input[value=' + val + ']');
	el.attr('checked','checked').attr('disabled','disabled');
	el.next().addClass('chkedDisable');
}

//学制显示与否的控制
function toggleSystem(){
	var a = $('[name="department[]"]');
	var c=[];
	for(var i=0,_len=a.length; i<_len; i++){
	  if(a.eq(i).is(':checked')){
		var _val = a.eq(i).val();
		c.push(_val);
	  }
	}
	if(c.join(',')=='20203' || c.join(',')=='' ){
		$('.sel_stu_system').hide();	
	}else{
		$('.sel_stu_system').show();	
	}
}

//业务串联：
//显示学校弹框
function schoolDialogs(index,targetName,targetInput,departEl){
	$('.mySchoolBox').dialog( 'destroy' );
	$('.mySchoolBox').remove();
	if($(departEl).val()==''){
		popBox.errorBox('请先选择学段！');
		return false;	
	}
	var index = index || 0; 
	var id = 'schoolDialogs_'+(zIndex++);
	var html = '';
		html+= '<div class="popBox mySchoolBox" id="' + id + '">';
			html+= '<div id="updateSchool">';
				//第一行开始
				html+= '<div class="subTitleBar">';
					html+= '<h5>选择省</h5>';
						html+= '<div class="subTitle_r">';
							html+= '<input type="text" name="name" class="text" id="searchText">';
							html+= '<button class="hideText searchBtn" type="button">搜索</button>';
						html+= '</div>';
				html+= '</div>';
				//第一行结束
				//主体内容开始
				html+= '<div class="popCont">';
					html+= '<a department="20202" class="txtBtn gray_d creatNewSchool hide" href="javasc' + 'ript:;">创建新学校</a>';
					//省市区开始
					html+= '<div class="selectArea">';
						html+= '<div class="crumbListWrap">';
							html+= '<div class="crumbList clearfix">';
								html+= '<span class="hide"></span>';
								html+= '<span class="hide"></span>';
								html+= '<span class="hide"></span>';
								html+= '<a href="#" class="back_selectArea hide">返回上级</a>';
								html+= '<a href="#" class="back_top hide">返回顶级</a>';
							html+= '</div>';
						html+= '</div>';
						html+= '<dl class="clearfix stateList" style="display: none;"></dl>';
						html+= '<dl class="clearfix cityList" style="display: none;"></dl>';
						html+= '<dl class="clearfix areaList" style="display: none;"></dl>';
					html+= '</div>';
					//省市区结束
					//学校列表部分开始
					html+= '<ul id="schoolListInfo" class="resultList schoolList clearfix" style="max-height:176px; overflow-y:auto"></ul>';
					//学校列表部分结束
					//新建学校部分开始
					html+= '<div class="newSchool"></div>';
					//新建学校部分结束
				html+= '</div>';
				//主体内容结束
				//底部按钮开始
				html+= '<div class="popBtnArea">';
					html+= '<button class="okBtn" type="button">确定</button>';
					html+= '<button class="cancelBtn" type="button">取消</button>';
				html+= '</div>';
				//底部按钮结束
			html+= '</div>';
		html+= '</div>';
		
		$('body').append(html);
		getStateHtml(fn(targetName,targetInput,id,departEl));//
}

//为元素绑定事件
function fn(targetName,targetInput,id,departEl){
	var targetName = targetName|| '#selectSchoolText';
	var targetInput = targetInput || '#TeacherUserForm_schoolId';
	var id = id || 'schoolDialogs_0';
	var dialog = $('#'+id).dialog({
		title:'我所在的学校',
		width:670,
		resizable: false,
		draggable: true,
		modal: true,
		close: function(event,ui){$('#'+id).dialog( 'destroy' );$('#'+id).remove();}
	});
	
	//确定按钮的事件
	$('#'+id+' .okBtn').click(function(){
		if($(this).hasClass('createNewBtn')){
			if($('#addSchool').validationEngine('validate')) {
				var department = [], inputEls = $('#' + id + ' #department input:checked');
				var schoolName = $.trim($('#' + id + ' #addSchool input[name="name"]').val());
				for(var i=0,_len=inputEls.length;i<_len;i++){
					department.push(inputEls.eq(i).val());
				}
				if(schoolName==''){
					popBox.errorBox('学校名称不能为空');
					return false;	
				}
				var pro = {
					'provience': $('.crumbList span').eq(0).attr('data_id'),
					'city': $('.crumbList span').eq(1).attr('data_id'),
					'county': $('.crumbList span').eq(2).attr('data_id'),
					'department[]':department.join(','),
					'name':schoolName,
					'lengthOfSchooling':$('#' + id + ' #lengthOfSchooling').val()
				};
				$.ajax({
					url:urlHttp+'/register/addSchool',
					type:'POST',
					data:pro,
					dataType:'json',
					success: function(data){
						if(data.success){
							var schoolId = data.data.split('|')[0], schoolName = data.data.split('|')[1];
							$(targetName).val(schoolName);
							$(targetInput).val(schoolId);
							$('.work_cls_list input').val('');
							$(targetName).blur();
							$("#"+id).dialog('close');
						}else{
							 popBox.errorBox('学校添加失败！');
						}
					}
				});
			}
		}else{
			var schoolId = $('.schoolList .ac').attr('id'), schoolName=$('.schoolList .ac').attr('title');
			$(targetName).val(schoolName);
			$(targetInput).val(schoolId);
			$('.work_cls_list input').val('');
			$("#"+id).dialog('close');
			$(targetName).blur();
		}
		return false;
	});
	
	//取消按钮的事件
	$('#'+id+' .cancelBtn').click(function(){
		$("#"+id).dialog('close');
		return false;
	});
	
	//搜索按钮的事件			
	$('#'+id+' .searchBtn').click(function(){
		if($(this).hasClass('noClick')){
			popBox.errorBox('正在努力加载，请稍后...');
			return false;
		}else{
			$(this).addClass('noClick');
			var name = $.trim($('#'+id+' #searchText').val()) || '';
			if(name.length!='' && name.length>2){
				searchSchool(name,departEl);	
			}else{
				if(name.length==0){
					popBox.errorBox('搜索内容不能为空');
				}else{
					popBox.errorBox('关键字需要大于2个字符');	
				}
				$(this).removeClass('noClick');
				return false;
			}
		}
	});
	
	//搜索结果为空时的创建按钮
	$('#' + id + ' .createNewBtn,#' + id + ' .back_top').die('click').live('click',function(){
		$('.schoolList,.newSchool,.selectArea dl').hide();
		$('.selectArea dl').eq(0).show();
		$('.crumbList a,.crumbList span').hide();
	});
	
	//返回按钮
	$('#' + id + ' .back_selectArea').click(function(){
		if($(this).hasClass('noClick')){
			popBox.errorBox('正在努力加载，请稍后...');
			return false;	
		}else{
			$('.creatNewSchool').hide();
			$('#' + id + ' .okBtn').removeClass('createNewBtn');
			if($('#' + id + ' .crumbList span').eq(2).css('display')=='block' && $('.areaList').css('display')=='none'){
				backArea();
			}else if($('#' + id + ' .crumbList span').eq(1).css('display')=='block' && $('.areaList').css('display')=='block'){
				backCity();	
			}else if($('#' + id + ' .crumbList span').eq(0).css('display')=='block' && $('.cityList').css('display')=='block'){
				backState();	
			}else{
				backState();	
			}
			return false;
		}
		
	});
	
	//选择省
	$('#' + id + ' .stateList dd').die('click').live('click',function(){
		if($(this).hasClass('noClick')){
			popBox.errorBox('正在努力加载，请稍后...');
			return false;	
		}else{
			$('.stateList dd,.back_selectArea').addClass('noClick');
			$(this).siblings().removeClass('ac');
			$(this).addClass('ac');
			selState($(this).attr('id'),$(this).html());
		}
	});
	
	//选择市
	$('#' + id + ' .cityList dd').die('click').live('click',function(){
		if($(this).hasClass('noClick')){
			popBox.errorBox('正在努力加载，请稍后...');
			return false;	
		}else{
			$('.cityList dd,.back_selectArea').addClass('noClick');
			$(this).siblings().removeClass('ac');
			$(this).addClass('ac');
			selCity($(this).attr('id'),$(this).html());
		}
	});
	
	//选择区
	$('#' + id + ' .areaList dd').die('click').live('click',function(){
		if($(this).hasClass('noClick')){
			popBox.errorBox('正在努力加载，请稍后...');
			return false;	
		}else{
			$(this).siblings().addClass('noClick').removeClass('ac');
			$(this).addClass('noClick ac');
			$('.back_selectArea').addClass('noClick');
			selArea($(this).attr('id'),$(this).html(),$(departEl));
		}
	});
	
	//选择学校
	$('#' + id + ' .schoolList li').die('click').live('click',function(){
		selSchool($(this));
		return false;
	});
	
	//创建学校
	$('#' + id + ' .creatNewSchool,#' + id + ' .listCreateNew').die('click').live('click',function(){
		createSchool(departEl);
		$('#' + id + ' .okBtn').addClass('createNewBtn');
		return false;
	});
	
	
	//选择学部
	$('#' + id + ' #department input').die('click').live('click',function(){//#' + id + ' #department [name="department[]"]
		if($(this).attr('disabled')=='disabled'){
			return false;
		}else{
			//$(this).toggleClass('chkLabel_ac');
			toggleSystem();
		}
	});
	
	return dialog;
}

//教师用户
//schoolDialogs使用说明
//第一个参数：弹框的z-index
//第二个参数：回显学校名称的元素
//第三个参数：回显学校id的元素
//第四个参数：表单中的学段元素
//schoolDialogs(1,'#selectSchoolText','#TeacherUserForm_schoolId','TeacherUserForm_department');
//学生用户
//schoolDialogs(1,'#selectSchoolText','#UserForm_schoolId','#UserForm_department');


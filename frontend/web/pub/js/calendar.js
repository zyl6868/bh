$(function() {
	var html='<div class="calendar">';
		html+='<div class="controlBar">';
			html+='<div class="widget_select control_year">';
				html+='<h6> <span>2015</span><i></i></h6>';
				html+='<ul>';
				html+='<li><a href="javascript:;">2014</a></li><li><a href="javascript:;">2015</a></li><li><a href="javascript:;">2016</a></li><li><a href="javascript:;">2017</a></li>';
				html+='</ul>';
			html+='</div>';
			html+='<div class="widget_select control_month">';
				html+='<h6><span>01</span><i></i></h6>';
				html+='<ul><li><a href="javascript:;">01</a></li><li><a href="javascript:;">02</a></li><li><a href="javascript:;">03</a></li><li><a href="javascript:;">04</a></li><li><a href="javascript:;">05</a></li><li><a href="javascript:;">06</a></li><li><a href="javascript:;">07</a></li><li><a href="javascript:;">08</a></li><li><a href="javascript:;">09</a></li><li><a href="javascript:;">10</a></li><li><a href="javascript:;">11</a></li><li><a href="javascript:;">12</a></li></ul>';
			html+='</div>';
			html+='<div class="widget_select control_classes">';
			html+='<h6><span>听课安排</span><i></i></h6>';
			html+='<ul>';
				html+='<li><a href="javascript:;">听课安排</a></li>';
				html+='<li><a href="javascript:;">我参与的</a></li>';
				html+='<li><a href="javascript:;">我主讲的</a></li>';
			html+='</ul>';
		html+='</div>';
		html+='<button type="button" class="transparentBtn noBorder backTodayBtn"> 返回今天</button>';
		html+='</div>';
		html+='<ul class="weekList clearfix">';
			html+='<li>一</li><li>二</li><li>三</li><li>四</li><li>五</li><li>六</li><li>日</li>';
        html+='</ul>';
		html+='<ul class="dateList clearfix"></ul>';       
        html+='</div>';  
		
	$('#classes_calendar').append(html);	                             

	
    /*var classes_arr = [
	{ id:110, year: 2015, month: 6, day: 20, type:'join',teacher:'刘萍',lesson:'数学课',time:'2015-12-1',joiner:['李四','王五']},
	{ id:111,year: 2015, month: 6, day: 30, type: 'join',teacher:'李清',lesson:'语文课',time:'2015-11-24',joiner:['李四','王五']},
	{id:112, year: 2016, month: 1, day: 15, type: 'speech',teacher:'张三',lesson:'数学课',time:'2015-04-18',joiner:['王五','李清']},
	{id:113, year: 2015, month: 7, day: 6, type: 'speech',teacher:'李阳',lesson:'历史课',time:'2015-03-21',joiner:['李四','李清']},
	{id:114, year: 2015, month: 8, day: 8, type: 'speech',teacher:'赵薇',lesson:'地理课',time:'2015-08-04',joiner:['刘萍','李清']},
	{id:115, year: 2015, month: 7, day: 28, type: 'join',teacher:'郭玲',lesson:'生物课',time:'2015-12-11',joiner:['刘萍','李清']}
	];*/



    function dateFn(json, set_year, set_month) {
        var now_date = new Date();
        var oYear = set_year || now_date.getFullYear();
        var oMonth = set_month || now_date.getMonth() + 1;
        var today = now_date.getDate();
        var iNow = 0;

        $('.calendar .control_month h6').html(oMonth + ' <i></i>');
        $('.calendar .control_year h6').html(oYear + ' <i></i>');


        var setDay = new Date();
        setDay.setFullYear(set_year, set_month);
        iNow = (oYear - now_date.getFullYear()) * 12 + oMonth - (now_date.getMonth() + 1);

        //算出本月有多少天，放多少个LI
        function nowDays() {
            var oDate = new Date();
            //将日期先调到下个月，将天数调为0 回到上个月最后一天
			oDate.setFullYear(oYear, oMonth, 0);
            return oDate.getDate();
        }

        // 算出本月第一天是星期几
        function firstDay() {
            var oDate = new Date();
            oDate.setFullYear(oYear, oMonth - 1, today);
            oDate.setDate(1);
            return oDate.getDay(); // 0-6 星期天是0
        }


        //接收本月第一天是星期几
        var firstWeek = firstDay();
        if (firstWeek == 0) firstWeek = 7;
        firstWeek--;

        //每次进来之前都要清空 
        $('.dateList').empty();

        //塞空白日期的LI
        for (var i = 0; i < firstWeek; i++) {
            $('.dateList').append('<li></li>');
        }

        //接收本月有几天
        var days = nowDays();

        //根据本月有多少天创建LI
        for (var i = 0; i < days; i++) {
            $('.dateList').append('<li>' + (parseInt(i) + 1) + '</li>')
        }
        //获取所有日期的LI
        var aLi = $('.dateList li');

        //判断是上个月还是下个月还是本月
        var oDate = new Date();
        oDate.setMonth(oDate.getMonth());
        var d = oDate.getDate();

        if (iNow < 0) {
            //上个月
            for (var i = 0; i < aLi.length; i++) {
                $(aLi[i]).addClass('ccc');
            }
        }
        else if (iNow == 0) {
            for (var i = 0; i < aLi.length; i++) {
                if ($(aLi[i]).text() < d) {
                    //过去的日期变灰
                    $(aLi[i]).addClass('ccc');
                }
                else if ($(aLi[i]).text() == d) {
                    //当天
                    $(aLi[i]).addClass('today');
                }
                else if (i % 7 == 5 || i % 7 == 6) {
                    //星期六星期天
                    $(aLi[i]).addClass('sun');
                }
            }
        }
        else {
            for (var i = 0; i < aLi.length; i++) {
                if (i % 7 == 5 || i % 7 == 6) {
                    //星期六星期天
                    $(aLi[i]).addClass('sun');
                }
            }
        }

        //标记课程
        function markDate(arr) {
            for (var i = 0; i < arr.length; i++) {
				var id=arr[i]['id'];
                var m_year = arr[i]['year'];
                var m_month = arr[i]['month'];
                var m_day = arr[i]['day'];
                var type = arr[i]['type'];

                if (m_year == oYear && m_month == oMonth) {
                    aLi.each(function() {
                        if ($(this).text() == m_day) {
                            if (type == "join") $(this).addClass('join').attr('id',id);
                            if (type == "speech") $(this).addClass('speech').attr('id',id);
                        }
                    });
                }
            }
        }
        markDate(json)
    }

    var now_year = new Date().getFullYear();
    dateFn(classes_arr, now_year);

    //过滤课程json
    function type_filter(type) {
		var newArr = [];
        if (type=="听课安排") newArr = classes_arr;
		
        if (type == "我参与的") {
			newArr = [];
            for (var i = 0; i < classes_arr.length; i++) {
                if (classes_arr[i]['type'] == 'join') {
                    newArr.push(classes_arr[i]);
                }
            }
			
        }
        if (type == "我主讲的") {
            newArr = [];
            for (var i = 0; i < classes_arr.length; i++) {
                if (classes_arr[i]['type'] == 'speech') {
                    newArr.push(classes_arr[i]);
                }
            }
        }
		
        return newArr;
    }

    //选择年
    $('.calendar .control_year li').live("click",function() {
        var year = $(this).text();
        var month = $('.calendar .control_month h6').text();
		year=$.trim(year);
		month=$.trim(month);
        dateFn(classes_arr, year, month);
    });
    //选择月
    $('.calendar .control_month li').click(function() {
        var year = $('.calendar .control_year h6').text();
        var month = $(this).text();
		year=$.trim(year);
		month=$.trim(month);
        dateFn(classes_arr, year, month);
    });

    //返回今天
    $('.calendar .backTodayBtn').click(function() {
        var now_date = new Date();
        var year = now_date.getFullYear();
        var month = now_date.getMonth() + 1;
        var type = $('.calendar .control_classes h6').text();
		type=$.trim(type);
        var newArr = type_filter(type);
        dateFn(newArr, year, month);
    });

    //切换课程
    $('.calendar .control_classes li').click(function() {
        var year = $('.calendar .control_year h6').text();
        var month = $('.calendar .control_month h6').text();
        var type = $(this).text();
		year=$.trim(year);
		month=$.trim(month);
		type=$.trim(type);
        var newArr = type_filter(type);
        dateFn(newArr, year, month);
    });
    
	//显示课程详情
    $('.dateList .speech,.dateList .join').live('mouseover',function(){
			var id=$(this).attr('id');
			var pop_l=$(this).position().left;
			var p_w=$(this).parent().width();
			var pos=pop_l-p_w/2;
			var cls="";
			pos>0 ?  cls='calendar_cls_detail calendar_cls_detail_l': cls='calendar_cls_detail';
			
			for( var i=0; i<classes_arr.length; i++){
				if(classes_arr[i]['id']==id) var json=classes_arr[i];
			}
			var popHtml='<div class="'+cls+'">';
					popHtml+='<span class="arrow"></span>';
					popHtml+='<span class="time">'+json['time']+'</span>';
					popHtml+='<h5>'+json['teacher']+'</h5>';
					popHtml+='<h6>'+json['lesson']+'</h6>';
					popHtml+='<p>听课：'+json['joiner']+'</p>';
				popHtml+='</div>';
			var popNum=$(this).children('.calendar_cls_detail').size();
			if(popNum>=1)$(this).children('.calendar_cls_detail').show();
			else $(this).append(popHtml);
		});
	$('.dateList .speech,.dateList .join').live('mouseout',function(){
		$(this).children('.calendar_cls_detail').hide();
	});                                	
});
	

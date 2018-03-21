define(["popBox",'jquery_sanhai','jqueryUI'],function(popBox,jquery_sanhai){
		//学科自动隐藏
		$('.moreContShow').openMore(40);


//时间线回到顶部
    $('#time_gotoTop').click(function(){
        $('#ulWrap').scrollTop(0);
    });
    //时间线fixed
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        var screenH=$(window).height();
        var timeLine=$('#timeLine');
        var ulWrap=$('#ulWrap');
    });


    //时间线_更多大事记
    function addClip(time_json){
        var time_line=$('#time_line_list');
        var this_year=$('#time_line_list .timeLine_year:last');
       time_line.attr('currPage',time_json.currPage);
        var this_month=0;
        var month_num=0;
        var year_num=0;
        var data=time_json.data;
        for(var i=0; i<data.length; i++){
            var year=data[i].year;
            var month=data[i].month;


                var _this=this_year;
                year_num=parseInt(_this.text());
                if(year==year_num){//如果年相同
                    this_month=_this.parent('li').find('.timeLine_month:last');
                    month_num=parseInt(this_month.text());
                    if(month!=month_num){
                        _this.parents('li').append('<dl><dt class="timeLine_month">'+month+'月</dt></dl>');
                        this_month=_this.parent('li').find('.timeLine_month:last');
                        month_num=parseInt(this_month.text());
                    }
                }
                else{
                    time_line.append('<li><a class="timeLine_year">'+year+'</a><dl><dt class="timeLine_month">'+month+'月</dt></dl></li>')	;
                    this_year=$('#time_line_list .timeLine_year:last');
                    year_num=parseInt(this_year.text());
                    this_month=this_year.parent('li').find('.timeLine_month:last');
                }
                var pa=this_month.parent('dl');
                var html='<dd>';
                html+='<em>'+data[i].day+'日<br></em><i></i>';
                html+='<span class="arrow_l"></span>';
                html+='<div class="eventName" eventID="'+data[i].eventID+'" >'+data[i].cont+'</div>';
                if(data[i].power) {
                    html += '<div class="toolBar hide" style="display: none;"><a class="memorabilia_edit" href="javascript:;"></a><a href="javascript:;" class="memorabilia_del"></a></div>';
                }
                html+='</dd>';
                pa.append(html);

        }
        var this_year=$('#time_line_list .timeLine_year');
        this_year.each(function(){
            if($(this).text()==""){
                $(this).parent('li').remove();
            }
        });
        if(time_json.currPage>time_json.pageCount){
            $('#time_addMore').hide();
        }
        //添加和编辑大事记可以继续添加的剩余图片的计算
        var liSize=$('.upImgFile').find('li').size();
        $('.uploadFileBtn').find('span').html(21-liSize);
        //大事记时间线
        $('#timeLine dd').hover(
            function(){
                var _this=$(this);
                var eventID=_this.find('.eventName').attr('eventID');
                _this.children('.toolBar').show();
                _this.find('.memorabilia_del').unbind('click').click(function(){
                    popBox.confirmBox('真的要删除吗?',function(){
                        $.post('/class/delete-event',{eventID:eventID},function(result){
                            if(result.success){
                                _this.remove();
                                location.reload();
                            }
                        })
                    })
                });
                _this.find('.memorabilia_edit').unbind('click').click(function(){
                     location.href='/class/'+classID+'/modify-memorabilia?eventID='+eventID;
                })
            },
            function(){
                $(this).children('.toolBar').hide();
            }
        );

    }
    $('.eventName').live('click',function(){
        var $this=$(this);
        eventID=$(this).attr('eventID');
        $.post('/class/get-event-details',{eventID:eventID,classID:classID},function(result){
            $('.memorabilia_detail').html(result);
            $('.eventName').parents('dd').removeClass('ac');
            $this.parents('dd').addClass('ac');
        })
    });
    var classID=$('#classID').val();
    $.get('/class/get-event-page',{'classID':classID,page:1},function(result){
        time_json = result.data;
        addClip(time_json);

    });
    $('#time_addMore').click(function(){
        page=$('#time_line_list').attr('currPage');
        $.get('/class/get-event-page',{'classID':classID,page:page},function(result){
                  time_json =result.data;
            addClip(time_json)
        });
    });


		//班级大事记
		$('.popBox').dialog({
		autoOpen: false,
		width:840,
		modal: true,
		resizable:false,
			close:function(){$(this).dialog("close")}
		});

        //添加班级大事记
        $('#addmemor_btn').click(function(){
            $( "#memor_popbox" ).dialog( "open" );
            $( "#memor_popbox" ).find('.okBtn').click(function(){

                var name=$("[name='SeClassEvent[name]']").val();
                var time=$("[name='SeClassEvent[time]']").val();
                var briefOfEvent=$("[name='SeClassEvent[briefOfEvent]']").val();
                var imgList=$('.picList').find('img');
                var imgArray=[];
                imgList.each(function(index,el){
                    imgArray.push($(el).attr('src'));
                });
                var imgStr=imgArray.join(',');
                $.post('/class/add-memorabilia',{classID:classID,name:name,briefEvent:briefOfEvent,img:imgStr},function(result){
                    if(result.success){
                        $( "#memor_popbox").dialog("close");
                    }
                })

            })

        });


        //班级大事记
            function slide_rotating(){
            $('#slide').slide({'width':715,'Clip_width':178});
        }
    slide_rotating();

    function yearHide(){
        var yearOut=null;
        var monthOut=null;
        $('.ulWrap').find('li').each(function(index,el){
            var year=$(el).find('.timeLine_year').html();
            var month=$(el).find('dt').html();
            if(year==yearOut){
                $(el).find('.timeLine_year').hide();
            }else{
                yearOut=year;
            }
            if(month==monthOut){
                $(el).find('dt').hide();
            }else{
                monthOut=month;
            }
        })
    }

    return {yearHide:yearHide,slide_rotating:slide_rotating};


});

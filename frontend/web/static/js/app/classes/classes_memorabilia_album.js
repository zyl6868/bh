define(["popBox",'userCard','jquery_sanhai','jqueryUI','fancybox'],function(popBox,userCard,jquery_sanhai,fancybox){
    $(".fancybox").die().fancybox();
    //时间线_更多大事记


    function addClip(json){
            var time_json=json.list;
        var time_line=$('#time_line_list');
        var this_year=$('#time_line_list .timeLine_year:last');
        time_line.attr('currPage',json.currPage);
        var this_month=0;
        var month_num=0;
        var year_num=0;

        for(var i=0; i<time_json.length; i++){
            var year=time_json[i].year;
            var month=time_json[i].month;
            var pics=time_json[i].picList;
            var html_pic='';
            for(var j=0; j<pics.length; j++){
                html_pic+='<a class="fancybox" href="'+pics[j].href+'" data-fancybox-group="gallery"><img src="'+pics[j].small_href+'"></a>';
            }

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
                html+='<em>'+time_json[i].day+'日</em><i></i>';
                html+='<div class="clearfix">'+html_pic+'</div>';
                html+='</dd>';
                pa.append(html);

        }
        var this_year=$('#time_line_list .timeLine_year');
        this_year.each(function(){
            if($(this).text()==""){
                $(this).parent('li').remove();
            }
        });
        if(json.currPage>json.pageCount){
            $('#time_addMore').hide();
        }

    }
    var classID=$('#classID').val();
    $.get('/class/get-album-list',{classID:classID,page:1},function(result){
        json= result.data;
        if(json.list.length==0){
            $('.album_year').html("<div class='empty'><i></i>此处暂无内容</div>");
            return false;
        }
        addClip(json);
    });



    $('#time_addMore').click(function(){
       page= $('#time_line_list').attr('currPage');
        $.get('/class/get-album-list',{classID:classID,page:page},function(result){
           json= result.data;
            addClip(json);
        })
    })



});
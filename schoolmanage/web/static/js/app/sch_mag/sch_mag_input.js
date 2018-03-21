define(["popBox", 'jquery_sanhai', 'jqueryUI'], function(popBox) {
    //选择班级
    $('#classes_list li a').click(function(){
      var _this=$(this);
      var classId = $(this).attr('classId');
      var schoolExamId = $(".testTitle").attr("schoolExamId");
      var a_arr=$('#classes_list a');
      var editCont=$('#editCont');
      a_arr.removeClass('ac');
      _this.addClass('ac');
      editCont.addClass('show_btnBar');
        $.getJSON("scoreinput/check-class",{classId:classId ,schoolExamId:schoolExamId},function(data){
            //alert(data);
            create_table(data);
        });
        if(_this.hasClass('finish')){
            editCont.removeClass('edit_input').addClass('edit_show');
            $('#input_table input').attr('disabled',true);
        }
        else if(_this.hasClass('half')){
            editCont.removeClass().addClass('edit_input').addClass('editCont');
            $('#input_table input').removeAttr('disabled');
        }
        else{
            editCont.removeClass().addClass('show_btnBar');
        };
        //input回车自动跳转
        var inputAry = $("#input_table").find("input:text");
        inputAry.focus(function(){
            var _this= $(this);
            _this.keyup(function(event){
                if(event.keyCode==13){
                    _this.blur();
                    var nxtIdx = inputAry.index(this) + 1;
                    inputAry.eq(nxtIdx).focus();
                    score_sum(_this);
                }
            })
        });
        //输入验证
        inputAry.blur(function(){
            var _this=$(this);
            var val= parseInt(_this.val());
            var max= parseInt(_this.attr('data-max'));
            if(val>max || val<0 || isNaN(val)){
                popBox.errorBox('输入错误');
                _this.addClass('input_error');
            }
            else{
                _this.removeClass('input_error');
            }
        });

        function score_sum(elm){
            var val=elm.val();
            var pa=elm.parents('tr');
            var p_id=pa.attr('id');
            var val_sum=0;
            pa.find('input').each(function(){//累计分数
                var temp_val=parseInt($(this).val());
                if(isNaN(temp_val) ||temp_val==""){
                    temp_val=0;
                }else{
                    val_sum+=temp_val;
                }
            });
            var id=p_id.split('_')[0];//找到相同id号
            $('#'+id+'_sum').text(val_sum);
        };
    });

    //编辑
    $('#editBtn').click(function(){
        $('#editCont').removeClass().addClass('edit_input').addClass('editCont');
        $('#input_table input').removeAttr('disabled');
    });

    //手动录入成绩
    $('#manualBtn').click(function(){
        $('#editCont').removeClass().addClass('edit_input').addClass('editCont');
        $('#input_table input').removeAttr('disabled');
    });

    //上传excel表
    $('.popBox').dialog({
        autoOpen: false,
        width:600,
        modal: true,
        resizable:false,
        close:function(){$(this).hide()}
    });


      //  $('#importExcelBox').dialog('open');


    $('.sys_name_table input').click(function(){
        var _this=$(this);
        var top=_this.offset().top;
        var left=_this.offset().left;
        $('#sys_userName_box').show().css({'top':top-20,'left':left+100});
        $('#sys_userName_box tr').click(function(){
            $(this).addClass('trAc').siblings().removeClass();
        });
        return false;
    });



   function create_table(data){
       var subject={'10010':'语文','10011':'数学','10012':'英语','10013':'生物','10014':'物理','10015':'化学','10016':'地理','10017':'历史','10018':'政治','10023':'信息技术','10026':'科学','10027':'理综','10028':'文综','10029':'思想品德','10030':'品德与社会','10031':'心理','10032':'健康','10033':'校本课程','10034':'地方课程','10035':'劳动与技术','10037':'学法指导','10038':'写字','10039':'蒙古语文','10040':'汉语','10041':'俄语'}
       var data = data;
       //var data={
       //    'sysName':['张三','李四','王五'],
       //    'subject':[{'name':'10010','max':190},{'name':'10011','max':150},{'name':'10012','max':150},{'name':'10017','max':100},{'name':'10016','max':100},{'name':'10013','max':100},{'name':'10015','max':120},{'name':'10018','max':100},{'name':'10030','max':100},{'name':'10028','max':100},{'name':'10029','max':100},{'name':'10014','max':120}],
       //    'student':[
       //        {'num':'19993','name':'张三','subject':{'10010':0,'10011':0,'10012':0,'10017':0,'10016':0,'10013':0,'10015':0,'10018':0,'10030':0,'10028':0,'10029':0,'10014':0}},
       //        {'num':'19994','name':'李四','subject':{'10010':34,'10011':43,'10012':86,'10017':32,'10016':87,'10013':94,'10015':70,'10018':70,'10030':48,'10028':87,'10029':70,'10014':0}},
       //        {'num':'19995','name':'王五','subject':{'10010':103,'10011':99,'10012':0,'10017':76,'10016':34,'10013':88,'10015':0,'10018':0,'10030':65,'10028':98,'10029':0,'10014':78}}
       //    ]
       //};
       var html='<form id="input_form">';
       html+='<table class="sUI_table name_table fl" style="width: 200px;border-right: 1px solid #dcdcdc;">';
       html+='<thead><tr>';
       html+='<th>学号</th><th>姓名</th></tr></thead>';
       for(var i=0;i<data.student.length;i++){
           html+='<tr>';
           html+='<td>'+data.student[i].num+'</td><td>'+data.student[i].name+'</td>';
           html+='</tr>';
       }
       html+='</table>';

       html+='<div class="tableWrap fl" style="width: 800px; overflow: auto; padding-bottom: 10px; overflow-Y:hidden">';
       html+='<table id="input_table" class="sUI_table input_table ">';
       html+='<thead><tr>';
        for(var i=0; i<data.subject.length;  i++){
            html+='<th>'+subject[data.subject[i].name]+'</th>';
        }
       html+='</tr></thead>';
       html+='<tbody>';
           for(var i=0; i<data.student.length;  i++){
               html+='<tr id="'+data.student[i].num+'_score">';
               var obj_l=0;
               for(var key in data.student[i].subject ){
                   html+='<td><input name="'+key+'" title="最高分为'+data.subject[obj_l].max+'分"  data-max="'+data.subject[obj_l].max+'" type="text" value="'+data.student[i].subject[key]+'"></td>';
                   obj_l++;
               }
               html+='</tr>';
           }
       html+='</tbody>';
       html+='</table>';
       html+='</div>';


       html+='<table class="sUI_table total_table fl" style="width: 100px;border-left: 1px solid #dcdcdc;">';
       html+='<thead><tr><th>总分</th></tr></thead>';
       html+='<tbody>';
       for(var i=0; i<data.student.length;  i++){
           html+='<tr>';
           var sum=0;
           for(var key in data.student[i].subject ){
               sum+=data.student[i].subject[key];
           }
           html+='<td id="'+data.student[i].num+'_sum">'+sum+'</td>';
           html+='</tr>';
       }
       html+=' </tbody>';
       html+='</table>';
       html+='<div class="tc clearBoth submit_Bar" style="height:80px; padding-top:30px; border-bottom: 1px solid #dcdcdc">';
       html+=' 还没有全部录入完，暂时 <button type="button" style="width: 110px" class="bg_blue btn40 input_save_btn">保存成绩</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="height: 24px; border-right: 1px solid #dcdcdc"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       html+='成绩已经录入完成！<button type="button" style="width: 110px" class="bg_white btn40 input_finish_btn">完成录入</button></div>';
       html+='</form>';

       $('#input_table_bar').empty().append(html);
       var ths=$('#scroe_table th');
       $('#submiBtn').click(function(){
           console.log($('#form001').serialize()) ;
       })

   }

});

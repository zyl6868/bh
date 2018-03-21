define(["popBox", 'jquery_sanhai', 'jqueryUI'], function(popBox) {


    function create_table(data){
        var subject={'10010':'语文','10011':'数学','10012':'英语','10013':'生物','10014':'物理','10015':'化学','10016':'地理','10017':'历史','10018':'政治','10023':'信息技术','10026':'科学','10027':'理综','10028':'文综','10029':'思想品德','10030':'品德与社会','10031':'心理','10032':'健康','10033':'校本课程','10034':'地方课程','10035':'劳动与技术','10037':'学法指导','10038':'写字','10039':'蒙古语文','10040':'汉语','10041':'俄语'}

        //var data={
        //    'subject':[{'name':'10010','max':190},{'name':'10011','max':150},{'name':'10012','max':150},{'name':'10017','max':100},{'name':'10016','max':100},{'name':'10013','max':100},{'name':'10015','max':120},{'name':'10018','max':100},{'name':'10030','max':100},{'name':'10028','max':100},{'name':'10029','max':100},{'name':'10014','max':120}],
        //    'student':[
        //        {'autoId':748,'num':'19993','name':'张三','subject':{'10010':0,'10011':0,'10012':0,'10017':0,'10016':0,'10013':0,'10015':0,'10018':0,'10030':0,'10028':0,'10029':0,'10014':0}},
        //        {'autoId':749,'num':'19994','name':'李四','subject':{'10010':34,'10011':43,'10012':86,'10017':32,'10016':87,'10013':94,'10015':70,'10018':70,'10030':48,'10028':87,'10029':70,'10014':0}},
        //        {'autoId':750,'num':'19995','name':'王五','subject':{'10010':103,'10011':99,'10012':0,'10017':76,'10016':34,'10013':88,'10015':0,'10018':0,'10030':65,'10028':98,'10029':0,'10014':78}}
        //    ]
        //};
        var html='<form id="input_form">';
        var html2="";
        html2+='<table class="sUI_table name_table fl" style="width: 200px;border-right: 1px solid #dcdcdc;">';
        html2+='<thead><tr>';
        html2+='<th>学号</th><th>姓名</th></tr></thead>';
        for(var i=0;i<data.student.length;i++){
            html2+='<tr>';
            html2+='<td><em title="'+data.student[i].num+'">'+data.student[i].num+'</em></td><td><em title="'+data.student[i].name+'">'+data.student[i].name+'</em></td>';
            html2+='</tr>';
        }
        html2+='</table>';
        html+=html2;

        html+='<div class="tableWrap fl" style="width: 800px; overflow: auto; padding-bottom: 10px; overflow-Y:hidden">';
        html+='<table id="input_table" class="sUI_table input_table ">';
        html+='<thead><tr>';
        for(var i=0; i<data.subject.length;  i++){
            html+='<th>'+subject[data.subject[i].name]+'</th>';
        }
        html+='</tr></thead>';
        html+='<tbody>';
        for(var i=0; i<data.student.length;  i++){
            html+='<tr id="'+data.student[i].autoId+'_score">';
            //html += '<td class="hide"><input type="hidden" name="'+'scoreInput['+data.student[i].num+']["name"]" value="'+data.student[i].name+'"></td>';
            // html += '<td class="hide"><input type="hidden" name="autoId" value="'+data.student[i].autoId+'"></td>';
            var obj_l=0;
            for(var key in data.student[i].subject ){
                html+='<td><input name="'+'scoreInput['+data.student[i].autoId+']['+ key +']" title="最高分为'+data.subject[obj_l].max+'分"  data-max="'+data.subject[obj_l].max+'" type="text" value="'+data.student[i].subject[key]+'"></td>';
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
                //if(data.other_student[i].subject[key]==undefined){sum+=0}
                sum+=parseFloat(data.student[i].subject[key]);
            }
            sum=parseFloat(sum);
            sum=Number(sum.toFixed(2));
            html+='<td id="'+data.student[i].autoId+'_sum">'+sum+'</td>';
            html+='</tr>';
        }
        html+=' </tbody>';
        html+='</table>';
        html+='<div class="tc clearBoth submit_Bar" style="height:80px; padding-top:30px; border-bottom: 1px solid #dcdcdc">';
        html+=' 还没有全部录入完，暂时 <button type="button" style="width: 110px" class="bg_blue btn40 input_save_btn">保存成绩</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
            '<i style="height: 24px; border-right: 1px solid #dcdcdc"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
            '成绩已经录入完成！<button type="button" style="width: 110px" class="bg_white btn40 input_finish_btn">完成录入</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
            '<i style="height: 24px; border-right: 1px solid #dcdcdc"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;会删除已录的数据 ' +
            '<button type="button" style="width: 110px" class="bg_white btn40 input_delete_btn" data-classId="'+data.classId+'" data-examId="'+data.examId+'">放弃录入</button>';
        html+='</div>';

        html+='</form>';
        $('#input_table_bar').append(html);



        //input回车自动跳转
        var inputAry = $("#input_table").find("input:text");
        inputAry.focus(function(){
            var _this= $(this);
            _this.keyup(function(event){
                if(event.keyCode==13){
                    _this.blur();
                    var nxtIdx = inputAry.index(this) + 1;
                    inputAry.eq(nxtIdx).focus();

                }
            })
        });
        //输入验证
        inputAry.blur(function(){
            var _this=$(this);
            var val= _this.val();
            var max= parseInt(_this.attr('data-max'));
            var rg=/\d*[A-Za-z]|\.{2}|\d*\.\d{3}|\s/g;

            if(rg.test(val)|| val>max || val<0 || isNaN(val)){
                popBox.errorBox('输入错误');
                _this.addClass('input_error');
            }
            else if( val==""){
                popBox.errorBox('不能为空');
                _this.addClass('input_error');
            }
            else{
                _this.removeClass('input_error');
                score_sum(_this);

            }
        });

        //暂时保存
        $('.input_save_btn').click(function(){
            var chk_error=$('#input_table .input_error').size();
            if(chk_error>0){
                popBox.errorBox('录入表单存在错误,请修正后再提交!');
            }
            else{
               var input_form = $('#input_form');
                popBox.confirmBox('确定保存吗',function(){
                    $.post('temp-save-score', input_form.serialize(),function(data){
                        if(data){
                            popBox.successBox("暂时保存成功");
                        }
                    });
                })

            }

        });

        //完成录入
        $('.input_finish_btn').click(function(){
            var chk_error=$('#input_table .input_error').size();
            if(chk_error>0){
                popBox.errorBox('录入表单存在错误,请修正后再提交!');
            }
            else{
              var input_form = $('#input_form');
                popBox.confirmBox('确定完成录入吗',function(){
                    $.post('final-save-score', input_form.serialize(),function(data){
                        if(data.success){
                            setTimeout(function () {
                                location.href='/exam/scoreinput/check-class?examId='+data.examId+'&classId='+data.classId;
                            },0);
                        }else{
                            popBox.successBox("录入失败");
                        }
                    });
                })

            }
        });

        //删除录入
        $('.input_delete_btn').click(function(){
            var _this = $(this);
            var classId = _this.attr('data-classId');
            var examId = _this.attr('data-examId');

            popBox.confirmBox('确定删除吗',function(){
                $.get('delete-score-input', {classId:classId , schoolExamId:examId},function(data){
                    if(data.success){
                        popBox.successBox('删除完成');
                            setTimeout(function () {
                                location.href='/exam/scoreinput?examId='+examId;
                            },300);
                    }else{
                        popBox.successBox('删除失败');
                    }
                });
            })
        });

        function score_sum(elm){
            var val=elm.val();
            var pa=elm.parents('tr');
            var p_id=pa.attr('id');
            var val_sum=0;
            pa.find('input').each(function(){//累计分数
                var temp_val=parseFloat($(this).val());
                if(isNaN(temp_val) ||temp_val==""){
                    temp_val=0;
                }else{
                    val_sum+=temp_val;
                }
            });
            var id=p_id.split('_')[0];//找到相同id号
            $('#'+id+'_sum').text(val_sum);
        };

    }

    create_table(data);

    //录入成绩保存教师关联
    $("#btn_sav").click(function () {
        popBox.successBox("保存成功！");
    });

})
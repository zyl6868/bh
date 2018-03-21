define(['popBox', 'jquery_sanhai', 'jqueryUI'], function(popBox) {
    $('.subList_con').sel_list('multi',function(elm){
        var data=elm.attr('data-sel-value');
        var subject={'10010':'语文','10011':'数学','10012':'英语','10013':'生物','10014':'物理','10015':'化学','10016':'地理','10017':'历史','10018':'政治','10023':'信息技术','10026':'科学','10027':'理综','10028':'文综','10029':'思想品德','10030':'品德与社会','10031':'心理','10032':'健康','10033':'校本课程','10034':'地方课程','10035':'劳动与技术','10037':'学法指导','10038':'写字','10039':'蒙古语文','10040':'汉语','10041':'俄语'};

        var html='<tr id="'+data+'_subject">' +
            '<td>'+subject[data]+'</td>' +
            '<td><input type="hidden" name="man[]" value="'+data+'"> <input type="text" class="fraction score_p" name="'+data+'_full"></td>' +
            '<td><input type="text" class="fraction score_l" name="'+data+'_cutLine"></td>' +
            '<td></td>' +
            '</tr>';

        if(elm.hasClass('sel_ac')){
            $('#table_set_up tbody').append(html)
        }
        else{
            $('#'+data+'_subject').remove();
            score_sum()
        }
    });

    function score_sum(){
        var t_p=0;//卷面总分
        var t_l=0;//分数线
        $('.score_p').each(function(){
            var _this=$(this);
            var temp=parseFloat(_this.val());
            if(isNaN(temp)) temp=0;
            t_p+=temp;
        });
        $('.score_l').each(function(){
            var _this=$(this);
            var temp=parseFloat(_this.val());
            if(isNaN(temp)) temp=0;
            t_l+=temp;
        });
        t_p=Number(t_p.toFixed(2));
        t_l=Number(t_l.toFixed(2));
        $('#total_paper').text(t_p);
        $('#total_line').text(t_l);
    }

    $(document).on('blur','#table_set_up input',function(){
        var _this=$(this);
        var val=_this.val();
        var pa=_this.parents('tr');
        var prev_val=parseFloat(pa.find('.score_p').val());
        var this_val=parseFloat(pa.find('.score_l').val());
        var rg=/\d*[A-Za-z]|\.{2}|\d*\.\d{3}|\s/g;
        if(rg.test(val)|| val<0 || val>999 || isNaN(val)){
            popBox.errorBox('输入错误');
            _this.addClass('input_error');
        }
        else if(val==""){
            popBox.errorBox('不能为空');
            _this.addClass('input_error');
        }
        else if(prev_val<=0){
            popBox.errorBox('卷面满分不能小于、等于0');
            _this.addClass('input_error');
        }
        else if(this_val>prev_val){
            popBox.errorBox('单科成绩不能大于卷面满分');
            _this.addClass('input_error');
        }else{
            _this.removeClass('input_error');
            score_sum();//计算总分
        }
    });

    $('.clas_formLIst .row').openMore(24);
    //取消数据
    $('.bg_white_gray').click(function(){window.location.href="javascript:history.back(-1)"});
    //提交数据
    $('.bg_white').click(function(){
        var checkbox = $("input[name='checkbox[]']:checked").length;
        var man = $("input[name='man[]']").length;
        var error=$('.input_error').val();
        var score=$('#total_paper').text();

        if (checkbox == 0) {
            popBox.errorBox("至少选择一个班级！");
            return;
        }
        if (man == 0) {
            popBox.errorBox("至少选择一个科目！");
            return;
        }
        if(error!=null){
            popBox.errorBox("输入错误！");
            return;
        }
        if(score==0){
            popBox.errorBox("请设定分数！");
            return;
        }

        $.post("/exam/default/receive",$("#post").serialize(), function (result) {
            if(result){
                popBox.alertBox('添加成功');
                location.href="javascript:history.back(-1)";
            }else{
                popBox.errorBox('添加失败');
            }
        });
    })

});
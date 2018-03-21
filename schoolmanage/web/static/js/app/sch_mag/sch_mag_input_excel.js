define(["popBox", 'jquery_sanhai', 'jqueryUI'], function (popBox) {


    create_table(data);

    //复制粘贴成绩
    var scoreArr = [];
    var origin_id = "";

    $(document).on('click', '.copyScoreBtn', function () {
        $('#other_stu_table input').removeClass('input_copy');
        origin_id = $(this).attr('data-student');
        scoreArr.length = 0;
        scoreArr = [];
        $('#' + origin_id + ' input').each(function () {
            $(this).addClass('input_copy');
            scoreArr.push(parseFloat($(this).val()));
        });
        return false;
    });


    $(document).on('click', '.pasteScoreBtn', function () {
        var id = $(this).attr('data-student');
        var sum = 0;
        if (origin_id == "") {
            popBox.errorBox('请先选择要复制的学生成绩!');
        } else {
            $('#' + id + ' .excel_text').each(function (index) {
                $(this).val(scoreArr[index]);
                sum += scoreArr[index];
            });
            var sum_id = $(this).attr('data-sum');
            $('#' + sum_id).text(sum);
            $('#' + origin_id + ' input').removeClass('input_copy');
            origin_id = "";
        }
        return false;
    });


    function create_table(data) {
        var subject = {
            '10010': '语文',
            '10011': '数学',
            '10012': '英语',
            '10013': '生物',
            '10014': '物理',
            '10015': '化学',
            '10016': '地理',
            '10017': '历史',
            '10018': '政治',
            '10023': '信息技术',
            '10026': '科学',
            '10027': '理综',
            '10028': '文综',
            '10029': '思想品德',
            '10030': '品德与社会',
            '10031': '心理',
            '10032': '健康',
            '10033': '校本课程',
            '10034': '地方课程',
            '10035': '劳动与技术',
            '10037': '学法指导',
            '10038': '写字',
            '10039': '蒙古语文',
            '10040': '汉语',
            '10041': '俄语'
        }

        //统计导入人数
        var excel_num = 0;
        for (var i = 0; i < data.student.length; i++) {
            if (data.student[i].excelName == "") {
                excel_num++;
            }
        }
        excel_num = data.student.length - excel_num;

        //已匹配学生表
        var html = '<form id="input_form">';
        html += '<h5 class="subTitle blue">已匹配名单</h5>';
        var html2 = "";
        html2 += '<div class="clearfix">';
        html2 += '<table class="sUI_table sys_name_table fl" style="width: 240px;border-right: 1px solid #dcdcdc;">';
        html2 += '<thead>';
        html2 += '<tr>';
        html2 += '<th>系统中的学生(' + data.student.length + ')</th>';
        html2 += '<th>导入学生(' + excel_num + ')</th>';
        html2 += '</tr>';
        html2 += '</thead>';

        html2 += '<tbody>';
        for (var k = 0; k < data.student.length; k++) {
            html2 += '</tr>';
            html2 += '<td><em data-student-num="' + data.student[k].userId + '">' + data.student[k].sysName + '</em></td><td>' + data.student[k].excelName + '</td>';
            html2 += '</tr>';
        }
        html2 += '</tbody>';
        html2 += '</table>';
        html += html2;

        html += '<div class="tableWrap fl" style="width: 800px; overflow: auto; padding-bottom: 10px; overflow-Y:hidden">';
        html += '<table id="input_table" class="sUI_table input_table ">';
        html += '<thead><tr>';
        for (var i = 0; i < data.subject.length; i++) {
            html += '<th>' + subject[data.subject[i].name] + '</th>';
        }
        html += '</tr></thead>';
        html += '<tbody>';
        for (var i = 0; i < data.student.length; i++) {
            html += '<tr id="' + data.student[i].num + '_score">';
            html += '<td class="hide"><input type="hidden" name="num" value="' + data.classExamId + '"></td>';
            html += '<td class="hide"><input type="hidden" name="' + 'scoreInput[' + data.student[i].num + '][' + key + ']" value="' + data.userId + '"></td>';
            var obj_l = 0;
            for (var key in data.student[i].subject) {
                html += '<td><input name="' + 'scoreInput[' + data.student[i].num + '][' + key + ']" title="最高分为' + data.subject[obj_l].max + '分"  data-max="' + data.subject[obj_l].max + '" type="text" class="excel_text"  value="' + data.student[i].subject[key] + '"></td>';
                obj_l++;
            }
            html += '</tr>';
        }
        html += '</tbody>';
        html += '</table>';
        html += '</div>';

        html += '<table class="sUI_table total_table fl" style="width: 100px;border-left: 1px solid #dcdcdc;">';
        html += '<thead><tr><th>总分</th><th>操作</th></tr></thead>';
        html += '<tbody>';
        for (var i = 0; i < data.student.length; i++) {
            html += '<tr>';
            html += '<td id="' + data.student[i].num + '_sum">' + data.student[i].total + '</td><td><a class="pasteScoreBtn"  href="javascript:;" data-student="' + data.student[i].num + '_score"  data-sum="' + data.student[i].num + '_sum">粘贴</a></td>';
            html += '</tr>';
        }
        html += ' </tbody>';
        html += '</table>';
        html += '</div>';


        html += '<br><br>';


        //未匹配表
        if (data.other_student.length > 0) {
            html += '<h5 class="subTitle red">未匹配名单</h5>';
            html += '<div class="clearfix">';
            html += '<table class="sUI_table fl" style="width: 100px;border-right: 1px solid #dcdcdc;">';
            html += '<thead>';
            html += '<tr><th>学生姓名</th></tr>';
            html += '</thead>';
            html += '<tbody>';
            for (var k = 0; k < data.other_student.length; k++) {
                html += '</tr><td><em data-student-num="' + data.other_student[k].name + '" title="' + data.other_student[k].name + '">' + data.other_student[k].name.slice(0, 6) + '</em></td></tr>';
            }
            html += '</tbody>';
            html += '</table>';

            html += '<div class="tableWrap fl" style="width:940px; overflow: auto; padding-bottom: 10px; overflow-Y:hidden">';
            html += '<table id="other_stu_table" class="sUI_table">';

            html += '<thead><tr>';
            for (var i = 0; i < data.subject.length; i++) {
                html += '<th>' + subject[data.subject[i].name] + '</th>';
            }
            html += '</tr></thead>';
            html += '<tbody>';
            for (var i = 0; i < data.other_student.length; i++) {
                html += '<tr id="otherStudent' + i + '">';
                var obj_l = 0;
                for (var key in data.other_student[i].subject) {
                    html += '<td><input readonly type="text" value="' + data.other_student[i].subject[key] + '"></td>';
                    obj_l++;
                }
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';


            html += '</div>';
            html += '<table class="sUI_table total_table fl" style="width: 100px;border-left: 1px solid #dcdcdc;">';
            html += '<thead><tr><th>操作</th></tr></thead>';
            html += '<tbody>';
            for (var i = 0; i < data.other_student.length; i++) {
                html += '<tr>';
                var sum = 0;
                for (var key in data.other_student[i].subject) {
                    sum += data.other_student[i].subject[key];
                }
                sum = parseFloat(sum);
                sum = Number(sum.toFixed(2));

                html += '<td><a class="copyScoreBtn"  href="javascript:;" data-student="otherStudent' + i + '">复制</a></td>';
                html += '</tr>';
            }
            html += ' </tbody>';
            html += '</table>';
            html += '</div>';

        }
        html += '<div class="tc clearBoth submit_Bar" style="height:80px; padding-top:30px; border-bottom: 1px solid #dcdcdc">';
        html += ' 还没有全部录入完，暂时 <button type="button" style="width: 110px" class="bg_blue btn40 input_save_btn">保存成绩</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
            '<i style="height: 24px; border-right: 1px solid #dcdcdc"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
            '成绩已经录入完成！<button type="button" style="width: 110px" class="bg_white btn40 input_finish_btn">完成录入</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
            '<i style="height: 24px; border-right: 1px solid #dcdcdc"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;会删除已录的数据 ' +
            '<button type="button" style="width: 110px" class="bg_white btn40 input_delete_btn" data-classId="' + data.classId + '" data-examId="' + data.examId + '">放弃录入</button>';
        html += '</div>';
        html += '</form>';


        $('#input_table_bar').append(html);


        //input回车自动跳转
        var inputAry = $("#input_table").find("input:text");
        inputAry.focus(function () {
            var _this = $(this);
            _this.keyup(function (event) {
                if (event.keyCode == 13) {
                    _this.blur();
                    var nxtIdx = inputAry.index(this) + 1;
                    inputAry.eq(nxtIdx).focus().select();

                }
            })
        });
        //输入验证
        inputAry.blur(function () {
            var _this = $(this);
            var val = _this.val();
            var max = parseInt(_this.attr('data-max'));
            var rg = /\d*[A-Za-z]|\.{2}|\d*\.\d{3}/g;
            if (rg.test(val) || val > max || val < 0 || isNaN(val)) {
                popBox.errorBox('输入错误');
                _this.addClass('input_error');
            } else if (val == "") {
                popBox.errorBox('不能为空');
                _this.addClass('input_error');
            }
            else {
                _this.removeClass('input_error');
                score_sum(_this);

            }
        });

        //暂时保存
        $('.input_save_btn').click(function () {
            var chk_error = $('#input_table .input_error').size();
            if (chk_error > 0) {
                popBox.errorBox('录入表单存在错误,请修正后再提交!');
            }
            else {
                $input_form = $('#input_form');
                popBox.confirmBox('确定保存吗',function(){
                    $.post('auto-save-score', $input_form.serialize(), function (data) {
                        if (data.success) {
                            popBox.successBox('保存成功');
                            location.reload();
                        } else {
                            popBox.successBox('保存失败');
                        }
                    });
                })

            }

        });

        //正式保存
        $('.input_finish_btn').click(function () {
            var chk_error = $('#input_table .input_error').size();
            if (chk_error > 0) {
                popBox.errorBox('录入表单存在错误,请修正后再提交!');
            }
            else {
                $input_form = $('#input_form');
                popBox.confirmBox('确定完成录入吗',function(){
                    $.post('auto-save-score-finish', $input_form.serialize(), function (data) {
                        if (data.success) {
                            popBox.successBox('录入完成');
                            window.location.href = '/exam/scoreinput/check-class?classId='+data.classId+'&examId=' + data.examId;
                        } else {
                            popBox.successBox('录入失败');
                        }
                    });
                })

            }
        });

        //删除录入
        $('.input_delete_btn').click(function () {
            var _this = $(this);
            var classId = _this.attr('data-classId');
            var examId = _this.attr('data-examId');

            popBox.confirmBox('确定删除吗', function () {
                $.get('delete-score-input', {classId: classId, schoolExamId: examId}, function (data) {
                    if (data.success) {
                        popBox.successBox('删除完成');
                        window.location.href = '/exam/scoreinput?examId=' + examId;
                    } else {
                        popBox.successBox('删除失败');
                    }
                });
            })
        });

        function score_sum(elm) {
            var val = elm.val();
            var pa = elm.parents('tr');
            var p_id = pa.attr('id');
            var val_sum = 0;
            pa.find('.excel_text').each(function () {//累计分数
                var temp = parseFloat($(this).val());
                if (isNaN(temp) || temp == "") temp = 0;
                val_sum += temp;
            });
            val_sum = Number(val_sum.toFixed(2));
            var id = p_id.split('_')[0];
            $('#' + id + '_sum').text(val_sum);
        }


        (function () {
            var overTime, outTime;
            $('.sys_name_table em').live({
                mouseover: function () {
                    clearTimeout(overTime);
                    var _this = $(this);
                    var top = $(this).offset().top - 30;
                    var left = $(this).offset().left + 50;
                    var student_num = _this.attr('data-student-num');
                    overTime = setTimeout(function () {
                        $.get('get-student-info?userId=' + student_num, function (data) {
                            var html = '<div id="sys_userName_box" class="pa sys_userName_box" style="top:' + top + 'px; left:' + left + 'px">';
                            html += '<span class="arrow_v_l" style="top:30px"></span>';
                            html += '<table><thead>';
                            html += '<tr><th>姓名</th><th>性别</th><th>手机号</th><th>学号</th></tr>';
                            html += '</thead>';
                            html += '<tbody>';
                            html += '<tr><td>' + data.name + '</td><td>' + data.sex + '</td><td>' + data.phone + '</td><td>' + data.num + '</td></tr>';
                            html += '</tbody>';
                            html += '</table></div>';
                            $('body').append(html)

                        })
                    }, 200);
                },
                mouseout: function () {
                    clearTimeout(overTime);
                    var card = $('#sys_userName_box');

                    function removeCard() {
                        outTime = setTimeout(function () {
                            card.remove();
                        }, 100);
                    };
                    removeCard();
                    overTime = setTimeout(function () {
                        removeCard()
                    }, 200);
                    card.mouseover(function () {
                        clearTimeout(overTime);
                        clearTimeout(outTime);
                    });
                    card.mouseout(function () {
                        removeCard();
                    });
                }
            });
        })();


    }



    //录入成绩保存教师关联
    $("#btn_sav").click(function () {
        popBox.successBox("保存成功！");
    });

});

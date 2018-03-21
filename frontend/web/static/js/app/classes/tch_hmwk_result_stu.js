define(['sanhai_tools'],function(sanhai_tools){

    $(".u_list .subject a").click(function() {

        var questionId = $(this).attr('questionId');
        var answerOption = $(this).attr('answerOption');
        var relId = $(this).attr('relId');
        var _this=$(this);
        $.post("/workstatistical/question-info",{questionId:questionId,answerOption:answerOption,'relId':relId,student:'student'},function(data){

           //拼接html
            var layerTopic = $('#layerTopic');
            if (layerTopic.size() > 0) layerTopic.remove();
            var elm_pos = sanhai_tools.horizontal_position(_this);
            var layerHtml = [];
            layerHtml = [
                '<div id="layerTopic" class="original_num">' +
                '   <div class="exhibition">' +
                '       <b class="close_box">×</b>' +
                '       <i class="v_r_arrow"></i>' +
                '       <div class="content">' +data +
                '       </div>' +
                '   </div>' +
                '</div>'
            ];
            $("body").append(layerHtml.join(""));
            var exhibition = $('.exhibition');
            var Height = exhibition.height();
            var arrow = $('i.v_r_arrow');
            var content = $('#layerTopic');
            var offset = _this.offset(),
                left = offset.left - 100,top,
                bottom = $(document).height() - offset.top -332;
            var HH = 0;
            if(Height < bottom){
                top = offset.top + 42;
            }else{
                exhibition.css({
                    "height":345+'px',
                    "min-height":165+'px',
                    "overflow-y":"scroll"
                });
                HH = exhibition.height();
                top = offset.top - HH -45;
                arrow.css({
                    "background":"url(../../static/images/ico.png) no-repeat -560px -860px",
                    "top":HH+33+"px"
                });
            }
            content.css({
                "top":top+"px",
                "left":left+"px"
            });
            if (!elm_pos) {
                $('#layerTopic').addClass("layer_right").css({
                    'left': left - 300
                });
            } else {
                $('#layerTopic').removeClass("layer_right");
            }
            return false;
        });
    });
    // 弹层关闭按钮
    $(".close_box").live('click', function () {
        $("#layerTopic").remove();
    });

//查看解析答案按钮
    $('.show_aswerBtn').live('click',function () {
        var _this = $(this);
        var pa = _this.parents('.quest');
        pa.toggleClass('A_cont_show');
        _this.toggleClass('icoBtn_close');
        if (pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
        else _this.html('查看答案解析 <i></i>');
    });

    //截取字符串
    var old = document.getElementsByClassName('sub_content');
    var len = old.length;
    if(len > 0){
        for(var i = 0;i <= len+1;i++){
            if(old[i]){
                var oldText = old[i].text;
                if(oldText){
                    var l = oldText.length;
                    if (l > 4) {
                        var newText = oldText.substring(0,4)+"...";
                        old[i].innerText = newText;
                    }
                }
            }
        }
    }

});
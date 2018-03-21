define(
    [
        'echarts/echarts',
        'sanhai_tools',
        "popBox",
        "jquery_sanhai",
        'echarts/chart/line',
        'echarts/chart/bar'

    ],
    function (ec,sanhai_tools,popBox) {
        //查看解析答案按钮
        $('.show_aswerBtn').live('click',function () {
            var _this = $(this);
            var pa = _this.parents('.quest');
            pa.toggleClass('A_cont_show');
            _this.toggleClass('icoBtn_close');
            if (pa.hasClass('A_cont_show')) _this.html('收起答案解析 <i></i>');
            else _this.html('查看答案解析 <i></i>');
        });

        function my_charts(option1_xAxis,option1_series,option2_xAxis,option2_series,option3_xAxis,option3_series,relId,objectiveTrueArr,subjectiveTrueArr) {
            // 基于准备好的dom，初始化echarts图表
            var myChart1 = ec.init(document.getElementById('echarts01')); //主观题
            var myChart2 = ec.init(document.getElementById('echarts02')); //客观题
            var myChart3 = ec.init(document.getElementById('echarts03')); //题目难度 柱状图
            //var myChart4 = ec.init(document.getElementById('homework_rate')); //题目难度 柱状图


            var option1 = {

                tooltip:{
                    show:true,
                    formatter: "{c}% <点击显示原题>",
                    position: function () {
                        var newx=arguments[0][0]-25;
                        var newy=arguments[0][1]-30;
                        return [newx,newy];
                    }
                },
                dataZoom: {
                    show: true,
                    start: 0,
                    height: 20
                },
                color: ['#09f'],

                xAxis: [
                    {
                        type: 'category',name:'题号',
                        data: option1_xAxis
                    }
                ],
                yAxis: [
                    {
                        type : 'value', name:'正确率（%）',min:0,max:100
                    }
                ],
                series: [
                    {
                        symbol:'circle',//原点样式
                        symbolSize:6,//原点大小
                        "name": "echarts01",
                        "type": "line",
                        "data": option1_series
                    }
                ]
            };


            var option2 = {//客观题
                id: "myChart2",
                tooltip:{
                    show:true,
                    formatter: "{c}% <点击显示原题>",
                    position: function () {
                        var newx=arguments[0][0]-25;
                        var newy=arguments[0][1]-30;
                        return [newx,newy];
                    }
                },
                dataZoom: {
                    show: true,
                    start: 0,
                    height: 20
                },
                color: ['#09f'],

                xAxis: [
                    {
                        type: 'category',name:'题号',
                        data: option2_xAxis
                    }
                ],
                yAxis: [
                    {
                        type : 'value', name:'正确率（%）',min:0,max:100
                    }
                ],
                series: [
                    {
                        symbol:'circle',//原点样式
                        symbolSize:6,//原点大小
                        "name": "echarts02",
                        "type": "line",
                        "data": option2_series
                    }
                ]
            };

            var option3 = {//题目难度 柱状图
                tooltip: {
                    show: true,
                    formatter: "{b} : {c}"
                },
                color: ['#4EBBFE'],
                legend: {
                    data: ['正确率统计']
                },
                xAxis: [
                    {
                        type: 'category',name:'难易程度',
                        data: option3_xAxis
                    }
                ],
                yAxis: [
                    {
                        type : 'value', name:'正确率（%）',min:0,max:100
                    }
                ],
                series: [
                    {
                        "name": "正确率",
                        "type": "bar",
                        "barWidth": "50",
                        "data": option3_series
                    }
                ]
            };




            // 为echarts对象加载数据
            if(option1_xAxis !== null){
                myChart1.setOption(option1);
            }
            if(option2_xAxis !== null){
                myChart2.setOption(option2);
            }
            if(option3_xAxis !== null){
                myChart3.setOption(option3);
            }
            //myChart4.setOption(option4);


            //添加点击事件
            var ecConfig = require('echarts/config');

            function open_topic_box(param) {

                var dataIndex = param.dataIndex;
                var table_id = param.seriesName;

                function delBox() {
                    var box = document.getElementById('statistics_topic_box');
                    if (box) document.body.removeChild(box);
                }

                delBox();

                if (sanhai_tools.isIE(6) || sanhai_tools.isIE(7) || sanhai_tools.isIE(8)) {
                    popBox.errorBox('您的浏览器版本过低,无法显示原题,请升级浏览器,推荐安装<a href="http://dlsw.baidu.com/sw-search-sp/soft/9d/14744/ChromeStandalone_46.0.2490.86_Setup.1447296650.exe" style="color:#fff; text-decoration:underline"><谷歌浏览器></a>');
                }
                else {
                    var pageX = param.event.clientX;
                    var pageY = param.event.clientY;
                    var screenW = document.body.offsetWidth;
                    var scrollH = document.body.scrollTop || document.documentElement.scrollTop;
                    var cls = "statistics_topic_box";
                    if (pageX < screenW / 2)    pageX = pageX;
                    else {
                        pageX = pageX - 400;
                        cls = "statistics_topic_box statistics_topic_box_l";
                    }
                    pageY = pageY + scrollH;
                    var box = document.createElement('div');
                    var arrow = document.createElement('i');
                    var delBtn = document.createElement('a');
                    var boxCont = document.createElement('div');

                    var dataIndex = param.dataIndex;
                    var tableId = param.seriesName;

                    if(tableId == 'echarts01'){
                       var  questionIdArr = objectiveTrueArr;
                    }else if(tableId == 'echarts02'){
                      var  questionIdArr = subjectiveTrueArr;
                    }
                    var questionId = questionIdArr[dataIndex];

                    $.post('/workstatistical/question-info',{questionId:questionId,'relId':relId},function(data){
                        boxCont.innerHTML=data;
                        });
                    //boxCont.innerHTML = "Ajax内容";

                    delBtn.innerHTML = "×";
                    delBtn.setAttribute('href', 'javascript:;');
                    delBtn.className = "delBoxBtn";
                    arrow.className = "arrow";
                    box.appendChild(arrow);
                    box.appendChild(delBtn);
                    box.appendChild(boxCont);
                    box.id = "statistics_topic_box";
                    box.className = cls;
                    box.style.top = pageY + 20 + "px";
                    box.style.left = pageX - 100 + "px";

                    document.body.appendChild(box);
                    delBtn.onclick = function () {
                        delBox()
                    }
                }
            }

            myChart1.on(ecConfig.EVENT.CLICK, open_topic_box);
            myChart2.on(ecConfig.EVENT.CLICK, open_topic_box);
        }
        return {my_charts:my_charts};


});

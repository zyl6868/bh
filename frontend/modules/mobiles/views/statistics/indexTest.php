<?php
/**
 *
 */

?>

<p></p>


<div id="chart01" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">


    var score = {
        'lev': ['A+级', 'A级', 'B+级', 'B级', 'C+级', 'C级'],
        'classes': ['一班', '二班', '三班', '四班', '五班', '六班', '七班'],
        'A_plus': [6, 4, 4, 8, 5, 4, 7],
        'A': [8, 3, 6, 2, 7, 2, 8],
        'B_plus': [2, 3, 9, 3, 7, 5, 6],
        'B': [3, 2, 8, 2, 15, 2, 7],
        'C_plus': [4, 3, 3, 8, 6, 2, 7],
        'C': [3, 1, 6, 9, 9, 7, 2]
    };

    // 路径配置
    require.config({
        paths: {echarts:  BASE_URL+ '/js/echarts'}
    });

    // 柱状图
    require(
        [
            'echarts',
            'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
        ],
        function (ec) {
// 基于准备好的dom，初始化echarts图表
            var _this = this;
            var myChart = ec.init(document.getElementById('chart01'));

            /*$.get(url,function(data){
             show(data);

             })*/

            show(score);

            function show(data) {
                var option = {
                    title: {
                        text: '学生构成分析',
                        x: 'center',
                        padding: [20, 0, 0, 0]
                    },
                    grid: {
                        y2: 80
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                            type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                        }
                    },
                    legend: {
                        data: score.lev,
                        y: 'bottom'
                    },
                    calculable: true,
                    yAxis: [
                        {
                            type: 'value'
                        }
                    ],
                    xAxis: [
                        {
                            type: 'category',
                            data: score.classes

                        }
                    ],

                    series: [
                        {
                            name: 'A+级',
                            type: 'bar',
                            stack: '总量',
                            itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                            data: score.A_plus
                        },
                        {
                            name: 'A级',
                            type: 'bar',
                            stack: '总量',
                            itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                            data: score.A
                        },
                        {
                            name: 'B+级',
                            type: 'bar',
                            stack: '总量',
                            itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                            data: score.B_plus
                        },
                        {
                            name: 'B级',
                            type: 'bar',
                            stack: '总量',
                            itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                            data: score.B
                        },
                        {
                            name: 'C+级',
                            type: 'bar',
                            stack: '总量',
                            itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                            data: score.C_plus
                        },
                        {
                            name: 'C级',
                            type: 'bar',
                            stack: '总量',
                            itemStyle: {normal: {label: {show: true, position: 'insideRight'}}},
                            data: score.C
                        }
                    ]
                };

// 为echarts对象加载数据
                myChart.setOption(option);
            }


        }
    );

</script>
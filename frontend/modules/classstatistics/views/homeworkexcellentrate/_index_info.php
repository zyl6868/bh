<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2016/4/8
 * Time: 11:19
 */

?>
<div id="chart_01" class="chart"  style="height: 400px">
</div>

<script>

    require.config({
        paths: {echarts:'<?php echo BH_CDN_RES.'/static'?>'+'/js/lib/echarts'}
    });
    require(['echarts/echarts','echarts/chart/bar','echarts/chart/line','echarts/chart/pie'],function(ec){

        var myChart01 = ec.init(document.getElementById('chart_01'));

        var labelRight = {normal: {label : {position: 'right'}}};

        option01 = {
            title: {
                x: 'center',
                padding: 0
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: [ '优', '良', '中','差']
            },
            calculable: true,
            yAxis: [
                {
                    name : '人次',
                    type: 'value',
                    splitNumber: 5,//网格分段
                    splitArea: {//网格变色
                        show: true,
                        areaStyle: {
                            color: [
                                '#f5f5f5',
                                'white'
                            ]
                        }
                    }
                }
            ],
            xAxis: [
                {
                    name : '科目',
                    type: 'category',
                    data: <?= json_encode($subjectArr)?>
                }
            ],
            series: [

                {
                    name: '差',
                    type: 'bar',
                    stack: '总量',
                    itemStyle: {normal: {color: "#f97373", label: {position: 'insideRight'}}},
                    data: <?= json_encode($data[3])?>,
                    barWidth: 35
                },
                {
                    name: '中',
                    type: 'bar',
                    stack: '总量',
                    itemStyle: {normal: {color: "#f3d883", label: {position: 'insideRight'}}},
                    data: <?= json_encode($data[2])?>,
                    barWidth: 35
                },
                {
                    name: '良',
                    type: 'bar',
                    stack: '总量',
                    itemStyle: {normal: {color: "#10ade5", label: {position: 'insideRight'}}},
                    data: <?= json_encode($data[1])?>,
                    barWidth: 35
                },
                {
                    name: '优',
                    type: 'bar',
                    stack: '总量',
                    itemStyle: {normal: {color: "#7edb92", label: {position: 'insideRight'}}},
                    data: <?= json_encode($data[0])?>,
                    barWidth: 35
                }
            ]
        };

        myChart01.setOption(option01);

    })

</script>
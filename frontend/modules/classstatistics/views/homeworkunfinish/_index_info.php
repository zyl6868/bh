<?php
/**
 * Created by PhpStorm.
 * User: Administrator
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
            title : {
                x:'center',
                padding:0
            },
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data:['已完成','未完成']
            },
            calculable : true,
            yAxis : [
                {
                    name : '人次',
                    type : 'value'
                }
            ],
            xAxis : [
                {
                    name : '科目',
                    type : 'category',
                    data : <?= json_encode($subjectArr)?>
                }
            ],

            series : [

                {
                    name:'未完成',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color: "#ff7f50",label : {show: false, position: 'insideRight'}}},
                    data:<?= json_encode($unfinishArr)?>,
                    barWidth: 35
                },
                {
                    name:'已完成',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color: "#87cefa",label : {show: false, position: 'insideRight'}}},
                    data:<?= json_encode($finishArr)?>,
                    barWidth: 35
                }

            ]
        };
        myChart01.setOption(option01);

    })

</script>
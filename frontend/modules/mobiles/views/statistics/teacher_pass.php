<?php
/**
 *
 */

?>

<div id="chart_08" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
        var myChart08 = ec.init(document.getElementById('chart_08'));
        //及格率
        var max=<?=json_encode($teacherPass['max'])?>;
        var min=<?=json_encode($teacherPass['min'])?>;
        var name=<?=json_encode($teacherPass['name'])?>;
        var passNumber=<?=json_encode($teacherPass['passNumber'])?>;

        option8= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['及格率']
            },

            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : name
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    min:min,
                    max:max,
                    axisLabel:{formatter:'{value} %'}
                }
            ],
            series : [
                {
                    name:'及格率',
                    type:'bar',
                    barMaxWidth:50,
                    data:passNumber,
                    itemStyle: {
                        normal: {
                            color:' #408829'
                        },
                        emphasis: {
                            color:' #408829'
                        }
                    },
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    }
                }
            ]
        };
        myChart08.setOption(option8);

    })
</script>

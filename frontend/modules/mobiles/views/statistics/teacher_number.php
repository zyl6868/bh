<?php
/**
 *
 */

?>

<div id="chart_10" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
        var myChart10 = ec.init(document.getElementById('chart_10'));
        //及格率
        var max=<?=json_encode($teacherOverLine['max'])?>;
        var min=<?=json_encode($teacherOverLine['min'])?>;
        var name=<?=json_encode($teacherOverLine['name'])?>;
        var overLineNum=<?=json_encode($teacherOverLine['overLineNum'])?>;

        option10= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['平均分上线人数']
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
                    max:max
                }
            ],
            series : [
                {
                    name:'平均分上线人数',
                    type:'bar',
                    barMaxWidth:50,
                    data:overLineNum,
                    itemStyle: {
                        normal: {
                            color:'#ed9678'
                        },
                        emphasis: {
                            color:'#ed9678'
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

        myChart10.setOption(option10);


    })
</script>
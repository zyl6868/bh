<?php
/**
 *
 */

?>

<div id="chart_09" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
        var myChart09 = ec.init(document.getElementById('chart_09'));
        //及格率
        var max=<?=json_encode($teacherLow['max'])?>;
        var min=<?=json_encode($teacherLow['min'])?>;
        var name=<?=json_encode($teacherLow['name'])?>;
        var lowNumber=<?=json_encode($teacherLow['lowNumber'])?>;

        option9= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['低分率']
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
                    name:'低分率',
                    type:'bar',
                    barMaxWidth:50,
                    data:lowNumber,
                    itemStyle: {
                        normal: {
                            color:' #d8361b'
                        },
                        emphasis: {
                            color:' #d8361b'
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
        myChart09.setOption(option9);

    })
</script>

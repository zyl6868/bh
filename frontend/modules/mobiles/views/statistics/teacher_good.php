<?php
/**
 *
 */

?>

<div id="chart_07" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
        var myChart07 = ec.init(document.getElementById('chart_07'));
        //优良率
        var max=<?=json_encode($teacherGood['max'])?>;
        var min=<?=json_encode($teacherGood['min'])?>;
        var name=<?=json_encode($teacherGood['teacherName'])?>;
        var goodNumber=<?=json_encode($teacherGood['goodNumber'])?>;

        option7= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['优良率']
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
                    name:'优良率',
                    type:'bar',
                    barMaxWidth:50,
                    data:goodNumber,
                    itemStyle: {
                        normal: {
                            color:'#1790cf'
                        },
                        emphasis: {
                            color:'#1790cf'
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
        myChart07.setOption(option7);

    })
</script>

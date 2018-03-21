<?php
/**
 *
 */

?>

<div id="chart_06" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/pie','echarts/chart/line'],function (ec) {
        var myChart06 = ec.init(document.getElementById('chart_06'));
        //低分人数
        var lowName=<?=json_encode($classNoPass['lowScoreName'])?>;
        var lowClassName=<?=json_encode($classNoPass['lowNumber'])?>;
        function lowClass(lowClassName){
            var lowData=[];
            for(var key in lowClassName){
                lowData.push({value:lowClassName[key],name:key});
            }
            return lowData;
        }
        option06 = {
            title : {
                text: '不及格人数对比',
                x:'center',
                padding:[20,0,0,0]
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b}<br/> 人数: {c} <br/>占比:({d}%)"
            },
            legend: {
                x : 'center',
                y : 'bottom',
                data:lowName
            },

            calculable : true,
            series : [
                {
                    name:'不及格人数对比',
                    type:'pie',
                    radius : [30, 110],
                    center : ['50%', 240],
                    roseType : 'radius',
                    x: '50%',
                    max: 40,
                    sort : 'ascending',
                    data:lowClass(lowClassName)
                }

            ]
        };

        myChart06.setOption(option06);

    })

</script>

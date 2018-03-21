<?php
/**
 *
 */

?>

<div id="chart_05" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/pie','echarts/chart/line'],function (ec) {
        var myChart05 = ec.init(document.getElementById('chart_05'));
        //高分人数
        var topName=<?=json_encode($classTop['topScoreName'])?>;
        var topClassName=<?=json_encode($classTop['topNumber'])?>;

        function topClass(topClassName){
            var topData=[];
            for(var key in topClassName){
                topData.push({value:topClassName[key], name:key});
            }
            return topData;
        }
        option05 = {
            title : {
                text: '高分人数对比',
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
                data:topName
            },

            calculable : true,
            series : [
                {
                    name:'高分人数对比',
                    type:'pie',
                    radius : [30, 110],
                    center : ['50%', 240],
                    roseType : 'radius',
                    x: '50%',
                    max: 40,
                    sort : 'ascending',
                    data:topClass(topClassName)
                }

            ]
        };

        myChart05.setOption(option05);

    })

</script>

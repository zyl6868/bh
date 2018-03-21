<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/2/29
 * Time: 14:02
 */
?>


<script type="text/javascript">
require(['echarts/echarts','echarts/chart/bar','echarts/chart/line','echarts/chart/pie'],function(ec){
    var myChart05 = ec.init(document.getElementById('chart_05'));
    var labelRight = {normal: {label : {position: 'right'}}};
    //高分人数
    var topName=<?=json_encode($topList['topScoreName'])?>;
    var topClassName=<?=json_encode($topList['topNumber'])?>;

    function topClass(topClassName){
        var topData=[];
        for(var key in topClassName){
            topData.push({value:topClassName[key], name:key});
        }
        return topData;
    }
    //低分人数
    var lowName=<?=json_encode($lowScoreList['lowScoreName'])?>;
    var lowClassName=<?=json_encode($lowScoreList['lowNumber'])?>;
    function lowClass(lowClassName){
        var lowData=[];
        for(var key in lowClassName){
            lowData.push({value:lowClassName[key],name:key});
        }
        return lowData;
    }

    option05 = {
        title : {
            text: '高分人数对比和不及格人数对比',
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
                center : ['25%', 200],
                roseType : 'radius',
                x: '50%',               // for funnel
                max: 40,                // for funnel
                sort : 'ascending',     // for funnel
                data:topClass(topClassName)
            },
            {
                name:'不及格人数对比',
                type:'pie',
                radius : [30, 110],
                center : ['75%', 200],
                roseType : 'radius',
                x: '50%',               // for funnel
                max: 40,                // for funnel
                sort : 'ascending',     // for funnel
                data:lowClass(lowClassName)
            }
        ]
    };
    myChart05.setOption(option05);

})

</script>

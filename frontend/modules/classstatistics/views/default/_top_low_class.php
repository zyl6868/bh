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
//    var myChart06 = ec.init(document.getElementById('chart_06'));
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
//    option06 = {
//        title : {
//            text: '学生构成分析',
//            x:'center',
//            padding:[20,0,0,0]
//        },
//        tooltip : {
//            trigger: 'axis',
//            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
//                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
//            }
//        },
//        legend: {
//            data:['A+级','A级','B+级','B级','C+级','C级'],
//            y:'bottom'
//        },
//        calculable : true,
//        yAxis : [
//            {
//                type : 'value'
//            }
//        ],
//        xAxis : [
//            {
//                type : 'category',
//                data : ['一班','二班','三班','四班','五班','六班','七班']
//            }
//        ],
//        series : [
//            {
//                name:'A+级',
//                type:'bar',
//                stack: '总量',
//                itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
//                data:[6, 4, 4, 8, 5, 4, 7]
//            },
//            {
//                name:'A级',
//                type:'bar',
//                stack: '总量',
//                itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
//                data:[8, 3, 6, 2, 7, 2, 8]
//            },
//            {
//                name:'B+级',
//                type:'bar',
//                stack: '总量',
//                itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
//                data:[2,3, 9, 3, 7, 5,6]
//            },
//            {
//                name:'B级',
//                type:'bar',
//                stack: '总量',
//                itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
//                data:[3, 2, 8, 2, 15, 2,7]
//            },
//            {
//                name:'C+级',
//                type:'bar',
//                stack: '总量',
//                itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
//                data:[4, 3, 3, 8, 6, 2,7]
//            },
//            {
//                name:'C级',
//                type:'bar',
//                stack: '总量',
//                itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
//                data:[3, 1, 6,9, 9,7,2]
//            }
//        ]
//    };
    myChart05.setOption(option05);
//    myChart06.setOption(option06);

})

</script>

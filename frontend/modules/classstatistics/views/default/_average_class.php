<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/2/29
 * Time: 13:37
 */
?>

<script type="text/javascript">
require(['echarts/echarts','echarts/chart/bar','echarts/chart/line','echarts/chart/pie'],function(ec){

    var myChart01 = ec.init(document.getElementById('chart_01'));
    var labelRight = {normal: {label : {position: 'right'}}};
    // 柱状图
    var average=<?=json_encode($dataList['average'])?>;
    var classScoreList=<?=json_encode($dataList['classScore'])?>;
    var min=<?=json_encode(intval($dataList['min']))?>;
    var max=<?=json_encode(intval($dataList['max']))?>;
    var className=<?=json_encode($dataList['className'])?>;
    //柱状图
    function changeScore( average,classScoreList ){
        var changeData= [];
        for(var x in classScoreList){
            if(classScoreList[x]-average>0){
                changeData.push({value : Math.abs(average-classScoreList[x]), itemStyle:{ normal:{color:'#24a6fd'}}});
            }else{
                changeData.push({value : Math.abs(average-classScoreList[x]), itemStyle:{ normal:{color:'#d01a75'}}});
            }
        }
        return changeData;
    }
    //班级分数
    function classScore( average,classScoreList ){
        var classData= [];
        for(var x in classScoreList){
            classData.push(classScoreList[x]-average>0? average:classScoreList[x]);
        }
        return classData;
    }

    option01 = {
        tooltip : {
            trigger: 'axis',
            formatter: function (params){
                return params[0].name +'<br/>'
                +' 均分 : '
                + (average - params[1].value > 0 ? params[1].value.toFixed(2) : (params[0].value +average))
                + '<br/>'
                + '差异 : ' + params[0].value.toFixed(2) + '<br/>'

            }

        },

        xAxis : [
            {
                type : 'category',
                data :className
            }
        ],
        yAxis : [
            {
                type : 'value',
                min : min,
                max : max
            }
        ],
        series : [
            {
                name:'平均值',
                type:'line',
                stack: '1',
                barWidth: 0,
                itemStyle:{
                    normal:{
                        color:'rgba(0,0,0,0)'
                    },
                    emphasis:{
                        color:'rgba(0,0,0,0)'
                    }
                },
                data:[average],
                markLine : {
                    data : [
                        {type : 'average', name : '年级平均'}
                    ]
                }
            },
            {
                name:'本班分数',
                type:'bar',
                stack: '1',
                barWidth: 20,
                itemStyle:{
                    normal:{
                        color:'rgba(0,0,0,0)'
                    },
                    emphasis:{
                        color:'rgba(0,0,0,0)'
                    }
                },
                data:classScore(average,classScoreList)

            },
            {
                name:'变化',
                type:'bar',
                stack: '1',
                data:changeScore(average,classScoreList)
            }

        ]
    };
    myChart01.setOption(option01);

})

</script>

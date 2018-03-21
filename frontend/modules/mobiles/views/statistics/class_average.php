<?php
/**
 *
 */

?>

<div id="chart01" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
       // 基于准备好的dom，初始化echarts图表
        var myChart = ec.init(document.getElementById('chart01'));
        // 柱状图
        var average=<?=json_encode($classAvgList['average'])?>;
        var classScoreList=<?=json_encode($classAvgList['classScore'])?>;
        var min=<?=json_encode(intval($classAvgList['min']))?>;
        var max=<?=json_encode(intval($classAvgList['max']))?>;
        var className=<?=json_encode($classAvgList['className'])?>;
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
        myChart.setOption(option01);

    })

</script>

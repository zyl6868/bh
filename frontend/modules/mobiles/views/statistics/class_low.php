<?php
/**
 *
 */

?>

<div id="chart_04" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
        var myChart04 = ec.init(document.getElementById('chart_04'));
        //低分率
        var averagegLow=<?=json_encode($classLow['averagegLow'])?>;
        var maxLow=<?=json_encode(intval($classLow['maxLow']))?>;
        var minLow=<?=json_encode(intval($classLow['minLow']))?>;
        var LowName=<?=json_encode($classLow['lowScoreName'])?>;
        var LowNumber=<?=json_encode($classLow['lowNumber'])?>;

        function lowAverage( average,classScoreList ){
            var changeData= [];
            for(var x in classScoreList){
                if(classScoreList[x]-average>0){
                    changeData.push({value : Math.abs(average-classScoreList[x]), itemStyle:{ normal:{color:'#d01a75'}}});
                }else{
                    changeData.push({value : Math.abs(average-classScoreList[x]), itemStyle:{ normal:{color:'#24a6fd'}}});
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

        option04 = {
            title:{
                text:'低分率对比',
                x:'center',
                padding:[20,0,0,0]
            },
            tooltip : {
                trigger: 'axis',
                formatter: function (params){
                    return params[0].name +'<br/>'
                    +' 均值 : '
                    + (averagegLow - params[1].value > 0 ? params[1].value.toFixed(2) : (params[0].value +averagegLow))
                    + '<br/>'
                    + '差异 : ' + params[0].value.toFixed(2) + '<br/>'

                }

            },

            xAxis : [
                {
                    type : 'category',
                    data : LowName
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    min : minLow,
                    max : maxLow,
                    axisLabel:{formatter:'{value} %'}
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
                    data:[averagegLow],
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
                    data:classScore(averagegLow,LowNumber)

                },
                {
                    name:'变化',
                    type:'bar',
                    stack: '1',
                    data:lowAverage(averagegLow,LowNumber)

                }

            ]
        };
        myChart04.setOption(option04);

    })

</script>

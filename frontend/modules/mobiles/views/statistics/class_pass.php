<?php
/**
 *
 */

?>

<div id="chart_03" style="height:28rem; margin:10% auto"></div>

<script type="text/javascript">
    // 路径配置
    require.config({paths: {echarts:  BASE_URL+ '/js/echarts'}});
    // 柱状图
    require(['echarts','echarts/chart/bar','echarts/chart/line'],function (ec) {
        var myChart03 = ec.init(document.getElementById('chart_03'));
        //及格率
        var averagegPass=<?=json_encode($classPass['averagegPass'])?>;
        var maxPass=<?=json_encode(intval($classPass['maxPass']))?>;
        var minPass=<?=json_encode(intval($classPass['minPass']))?>;
        var PassName=<?=json_encode($classPass['passName'])?>;
        var PassNumber=<?=json_encode($classPass['passNumber'])?>;

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

        option03 = {
            title:{
                text:'及格率对比',
                x:'center',
                padding:[20,0,0,0]
            },
            tooltip : {
                trigger: 'axis',
                formatter: function (params){
                    return params[0].name +'<br/>'
                    +' 均值 : '
                    + (averagegPass - params[1].value > 0 ? params[1].value.toFixed(2) : (params[0].value +averagegPass))
                    + '<br/>'
                    + '差异 : ' + params[0].value.toFixed(2) + '<br/>'

                }

            },

            xAxis : [
                {
                    type : 'category',
                    data : PassName
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    min : minPass,
                    max : maxPass,
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
                    data:[averagegPass],
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
                    data:classScore(averagegPass,PassNumber)

                },
                {
                    name:'变化',
                    type:'bar',
                    stack: '1',
                    data:changeScore(averagegPass,PassNumber)

                }

            ]
        };
        myChart03.setOption(option03);

    })

</script>

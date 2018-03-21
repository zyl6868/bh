<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/2/29
 * Time: 13:59
 */
?>


<script type="text/javascript">

require(['echarts/echarts','echarts/chart/bar','echarts/chart/line','echarts/chart/pie'],function(ec){

    var myChart02 = ec.init(document.getElementById('chart_02'));
    var myChart03 = ec.init(document.getElementById('chart_03'));
    var myChart04 = ec.init(document.getElementById('chart_04'));
    var labelRight = {normal: {label : {position: 'right'}}};
    //优良率
    var averagegGood=<?=json_encode($contrastList['averagegGood'])?>;
    var maxGood=<?=json_encode(intval($contrastList['maxGood']))?>;
    var minGood=<?=json_encode(intval($contrastList['minGood']))?>;
    var goodName=<?=json_encode($contrastList['goodName'])?>;
    var goodNumber=<?=json_encode($contrastList['goodNumber'])?>;
    //及格率
    var averagegPass=<?=json_encode($passList['averagegPass'])?>;
    var maxPass=<?=json_encode(intval($passList['maxPass']))?>;
    var minPass=<?=json_encode(intval($passList['minPass']))?>;
    var PassName=<?=json_encode($passList['passName'])?>;
    var PassNumber=<?=json_encode($passList['passNumber'])?>;
    //低分率
    var averagegLow=<?=json_encode($lowList['averagegLow'])?>;
    var maxLow=<?=json_encode(intval($lowList['maxLow']))?>;
    var minLow=<?=json_encode(intval($lowList['minLow']))?>;
    var LowName=<?=json_encode($lowList['lowScoreName'])?>;
    var LowNumber=<?=json_encode($lowList['lowNumber'])?>;
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

    option02 = {
        title:{
            text:'优良率对比',
            x:'center',
            padding:[20,0,0,0]
        },
        tooltip : {
            trigger: 'axis',
            formatter: function (params){
                return params[0].name +'<br/>'
                +' 均值 : '
                + (averagegGood - params[1].value > 0 ? params[1].value.toFixed(2) : (params[0].value +averagegGood))
                + '<br/>'
                + '差异 : ' + params[0].value.toFixed(2) + '<br/>'

            }

        },

        xAxis : [
            {
                type : 'category',
                data : goodName
            }
        ],
        yAxis : [
            {
                type : 'value',
                min : minGood,
                max : maxGood,
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
                data:[averagegGood],
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
                data:classScore(averagegGood,goodNumber)

            },
            {
                name:'变化',
                type:'bar',
                stack: '1',
                data:changeScore(averagegGood,goodNumber)

            }

        ]
    };
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

    myChart02.setOption(option02);
    myChart03.setOption(option03);
    myChart04.setOption(option04);

})

</script>

<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/3/2
 * Time: 20:24
 */
?>
<div class="chart">
    <h6>  优良率对比</h6>
    <div id="chart01" style="height: 260px"></div>
</div>
<div class="chart">
    <h6>及格率对比</h6>
    <div id="chart02" style="height: 260px"></div>
</div>
<div class="chart">
    <h6>低分率对比</h6>
    <div id="chart03" style="height: 260px"></div>
</div>
<div class="chart">
    <h6>班平均上线人数</h6>
    <div id="chart04" style="height: 260px"></div>
</div>

<script>
    require.config({
        paths: {echarts:'<?php echo BH_CDN_RES.'/static' ?>'+'/js/lib/echarts'}
    });
    require(['echarts/echarts','echarts/chart/bar'],function(ec){
        var myChart1 = ec.init(document.getElementById('chart01'));
        var myChart2 = ec.init(document.getElementById('chart02'));
        var myChart3 = ec.init(document.getElementById('chart03'));
        var myChart4 = ec.init(document.getElementById('chart04'));

        //优良率
        var max=<?=json_encode($goodNumList['max'])?>;
        var min=<?=json_encode($goodNumList['min'])?>;
        var name=<?=json_encode($goodNumList['teacherName'])?>;
        var goodNumber=<?=json_encode($goodNumList['goodNumber'])?>;

        //及格率
        var passNumber=<?=json_encode($passList['passNumber'])?>;

        //低分率
        var lowNumber=<?=json_encode($lowList['lowNumber'])?>;
        var overLineNum=<?=json_encode($overLineNum['overLineNum'])?>;
        option1= {

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
        option2= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['及格率']
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
                    name:'及格率',
                    type:'bar',
                    barMaxWidth:50,
                    data:passNumber,
                    itemStyle: {
                        normal: {
                            color:' #408829'
                        },
                        emphasis: {
                            color:' #408829'
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
        option3= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['低分率']
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
                    name:'低分率',
                    type:'bar',
                    barMaxWidth:50,
                    data:lowNumber,
                    itemStyle: {
                        normal: {
                            color:' #d8361b'
                        },
                        emphasis: {
                            color:' #d8361b'
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
        option4= {

            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['平均分上线人数']
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
                    max:max
                }
            ],
            series : [
                {
                    name:'平均分上线人数',
                    type:'bar',
                    barMaxWidth:50,
                    data:overLineNum,
                    itemStyle: {
                        normal: {
                            color:'#ed9678'
                        },
                        emphasis: {
                            color:'#ed9678'
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

        myChart1.setOption(option1);
        myChart2.setOption(option2);
        myChart3.setOption(option3);
        myChart4.setOption(option4);


    })
</script>
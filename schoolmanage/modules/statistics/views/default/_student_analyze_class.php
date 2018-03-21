<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/4/13
 * Time: 10:29
 */
?>
<script type="text/javascript">
    require(['echarts/echarts','echarts/chart/bar','echarts/chart/line','echarts/chart/pie'],function(ec){
        var myChart06 = ec.init(document.getElementById('chart_06'));
        var labelRight = {normal: {label : {position: 'right'}}};
        // 学生构成分析
        var className=<?=json_encode($studentAnalyze['className'])?>;
        var aplusNum=<?=json_encode($studentAnalyze['aplusNum'])?>;
        var aNum=<?=json_encode($studentAnalyze['aNum'])?>;
        var bplusNum=<?=json_encode($studentAnalyze['bplusNum'])?>;
        var bNum=<?=json_encode($studentAnalyze['bNum'])?>;
        var cplusNum=<?=json_encode($studentAnalyze['cplusNum'])?>;
        var cNum=<?=json_encode($studentAnalyze['cNum'])?>;
        var max=<?=json_encode($studentAnalyze['max'])?>;
        var subject = ['A+级','A级','B+级','B级','C+级','C级'];
        var array = ["0%-5%","5%-25%","25%-50%","50%-75%","75%-95%","95%-100%"];

        option06 = {

            tooltip : {
                trigger: 'axis',
                axisPointer : {
                    type : 'shadow'
                }
            },
            legend: {
                data:subject,
                formatter:function(params){
                        for(var i=0;i<subject.length;i++){
                            if(subject[i]==params){
                                return params+array[i];
                            }
                    }
                },
                y:'bottom'
            },
            calculable : true,
            yAxis : [
                {
                    type : 'value',
                    max : max,
                    name : '人数'
                }
            ],
            xAxis : [
                {
                    type : 'category',
                    data : className
                }
            ],
            series : [
                {
                    name:'C级',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color:"#58114b",label : {show: false, position: 'inside'}}},
                    data:cNum
                },
                {
                    name:'C+级',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color:"#b25da1",label : {show: false, position: 'inside'}}},

                    data:cplusNum
                },
                {
                    name:'B级',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color:"#ec1500",label : {show: false, position: 'inside'}}},

                    data:bNum
                },
                {
                    name:'B+级',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color:"#fa9700",label : {show: false, position: 'inside'}}},

                    data:bplusNum
                },
                {
                    name:'A级',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color:"#fef793",label : {show: false, position: 'inside'}}},

                    data:aNum
                },
                {
                    name:'A+级',
                    type:'bar',
                    stack: '总量',
                    itemStyle : { normal: {color:"#78c05f",label : {show: false, position: 'inside'}}},

                    data:aplusNum
                }
            ]
        };
        myChart06.setOption(option06);

    })

</script>

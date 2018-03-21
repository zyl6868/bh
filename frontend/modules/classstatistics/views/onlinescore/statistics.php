<div id="chart_list" class="chart_list clearfix">
</div>

<script>
    var subject={'10010':'语文','10011':'数学','10012':'英语','10013':'生物','10014':'物理','10015':'化学','10016':'地理','10017':'历史','10018':'政治','10023':'信息技术','10026':'科学','10027':'理综','10028':'文综','10029':'思想品德','10030':'品德与社会','10031':'心理','10032':'健康','10033':'校本课程','10034':'地方课程','10035':'劳动与技术','10037':'学法指导','10038':'写字','10039':'蒙古语文','10040':'汉语','10041':'俄语'}

//    var corse=[
//        {name:"10012",shuang_s:23,dan:14,zong:56,shuang_x:23},
//        {name:"10013",shuang_s:43,dan:9,zong:16,shuang_x:25},
//        {name:"10015",shuang_s:8,dan:54,zong:43,shuang_x:5}
//    ];

    var corse = <?php echo json_encode($onlineNum);?>;

    require.config({
        paths: {echarts:'<?php echo BH_CDN_RES.'/static'?>'+'/js/lib/echarts'}
    });

    require(['echarts/echarts','echarts/chart/pie'],function(ec){
        var chart_list=$('#chart_list');
        for(var i=0; i<corse.length;i++){
            chart_list.append('<div  style="height:300px; width:500px; float:left" id="chart0'+i+'"></div>');
            var myChart=ec.init(document.getElementById('chart0'+i));
            option = {
                title:{
//                    text:corse[i].name,
                    text:subject[corse[i].name],
                    x:280
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)",
                    position:function(){
                        var newX=arguments[0][0]-100;
                        var newY=arguments[0][1]-55;
                        return [newX,newY]
                    }
                },
                calculable : true,
                series : [
                    {
                        name:subject[corse[i].name],
                        type:'pie',
                        radius :'50%',
                        center: [300, 150],
                        itemStyle : {
                            normal : {
                                label : {
                                    show : false
                                },
                                labelLine : {
                                    show : false
                                }
                            },
                            emphasis : {
                                label : {
                                    show : true
                                },
                                labelLine : {
                                    show : true
                                }
                            }
                        },

                        data:[
                            {value:corse[i].shuang_s, name:'双上线'},
                            {value:corse[i].dan, name:'总分上线单科未上'},
                            {value:corse[i].zong, name:'单科上线总分未上'},
                            {value:corse[i].shuang_x, name:'双下'}
                        ]
                    }
                ]
            };
            if(i==0){
                option.legend={
                    orient : 'vertical',
                    x : 100,
                    data:['双上线','总分上线单科未上','单科上线总分未上','双下']
                }
            }
            myChart.setOption(option);
        }


    })
</script>
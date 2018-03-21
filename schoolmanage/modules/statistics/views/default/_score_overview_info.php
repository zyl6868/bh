<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/25
 * Time: 11:01
 */

?>
<div class="tableWrap">
    <?php
    if(empty($subjectId)){
       echo  $this->render('_overview_table' , ['seExamReprotBaseInfoList'=>$seExamReprotBaseInfoList]);
    }else{
       echo  $this->render('_overview_table_single' ,
           ['seExamReprotBaseInfoList'=>$seExamReprotBaseInfoList ,
           'rankListDesc'=>$rankListDesc,
           'rankListAsc'=>$rankListAsc,
           'classId' =>$classId
       ]);
    }
    ?>
</div>

<div class="classes_score_level">
    <div class="sUI_pannel  title_pannel" style="padding: 0">
        <div class="pannel_l"><h5>分数段占比</h5></div>
        <div class="pannel_r">

        </div>
    </div>

    <div id="chart01" class="chart">
    </div>
</div>
<script>

    require.config({
        paths: {echarts:'<?php echo BH_CDN_RES.'/static' ?>'+'/js/lib/echarts'}
    });

    // 柱状图
    require(['echarts/echarts','echarts/chart/bar','echarts/chart/line'],function(ec){

        var myChart1 = ec.init(document.getElementById('chart01'));
        option = {
            tooltip : {
                trigger: 'axis',
                position: function () {
                    return [arguments[0][0] + 60, arguments[0][1] - 120]
                },
                formatter: function (params)
                { return params[0].name +'<br/>' +' 占比 : ' + params[1].value +'<br/>' }
            },

            calculable : true,
            legend: {
                data:['占比']
            },
            dataZoom:{
                show:true,
                height:20
            },
            xAxis : [

                {
                    type : 'category',

                    //data : ['[0,50]','[50,100]','[100,150]','[150,200]','[200,250]','[250,300]','[300,350]','[350,400]','[400,450]','[450,500]','[500,600]','[600,650]']
                    data :<?php echo json_encode($section);?>
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    name : '占比'
                }
            ],
            series : [

                {
                    name:'占比',
                    type:'bar',
                    itemStyle : { normal: {
                        color: '#1bb674'
                    }},

                    //data:[4, 3, 1.3, 6, 0.2, 4,3.2, 1.6, 2.6, 0.6,0.27, 1.2]
                    data:<?php echo json_encode($count);?>
                },

                {
                    name:'占比',
                    type:'line',
                    itemStyle : { normal: {
                        color: 'red'
                    }},

                    data:<?php echo json_encode($count);?>
                }
            ]
        };
        myChart1.setOption(option);

    })
</script>
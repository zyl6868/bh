<div class="tabItem clearfix">
    <div class="statistics_item clearfix">
        <h6>作业提交情况</h6>
        <p class="tj">未按时提交</p>
        <?php
        use common\helper\DateTimeHelper;
        use common\components\WebDataCache;

        if(DateTimeHelper::timestampX1000()<$deadlineTime):?>
            <div class="noend">作业还未截止，请截止后查看</div>
        <?php else:?>
            <ul class="noendList">
                <?php foreach($overtimeId as $v):?>
                    <li class=""> <?php echo WebDataCache::getTrueNameByuserId($v); ?></li>
                <?php endforeach;?>
                <?php foreach($noAnswerdId as $v1):?>
                    <li class="notName"><?php echo WebDataCache::getTrueNameByuserId($v1); ?></li>
                <?php endforeach;?>
            </ul>
            <p class="red" style="font-size: 14px">
                注：红色字体表示仍未提交作业的学生。
            </p>
        <?php endif;?>
    </div>
    <div class="statistics_item clearfix">
        <h6>作业优良率分布比例</h6>
        <div id="echarts01" style="height:300px"></div>
    </div>
</div>

<script type="text/javascript">
    var you   = <?php echo !empty($level[4]) ? $level[4]: 0 ;?>;
    var liang = <?php echo !empty($level[3]) ? $level[3]: 0 ;?>;
    var zhong = <?php echo !empty($level[2]) ? $level[2]: 0 ;?>;
    var cha   = <?php echo !empty($level[1]) ? $level[1]: 0 ;?>;
    var zong = you+liang+zhong+cha;
    if(zong == 0){
        zong = 1;
    }


// 路径配置
require.config({
    paths: {echarts: '<?php echo BH_CDN_RES.'/pub' ?>'+'/js/echarts'}
});

    //柱状图
    require(
        [
            'echarts',
            'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart1 = ec.init(document.getElementById('echarts01')); //分布比例

            var zrColor = require('zrender/tool/color');
            var colorList = [ '#1ED348','#E3A55A','#2CB3F2','#FF664E'];
            var itemStyle = {
                normal: {
                    label : {show: true, position: 'top'},
                    color: function(params) {
                        if (params.dataIndex < 0) {
                            // for legend
                            return zrColor.lift(
                                colorList[colorList.length - 1], params.seriesIndex * 0.1
                            );
                        }
                        else {
                            // for bar
                            return zrColor.lift(
                                colorList[params.dataIndex], params.seriesIndex * 0.1
                            );
                        }
                    }
                }
            };
            option = {
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(255,255,255,0.7)',
                    axisPointer: {type: 'shadow'},
                    formatter: function(params) {
                        // for text color
                        var color = colorList[params[0].dataIndex];
                        var res = '<div style="color:' + color + '">';
                        res += '<strong>' + params[0].name + '</strong>';
                        /*for (var i = 0, l = params.length; i < l; i++) {
                         res += '<br/>' + params[i].seriesName + ' : ' + params[i].value
                         }*/
                        res += '</div>';
                        return res;
                    }
                },

                calculable: true,
                grid: {
                    y: 80,
                    y2: 40,
                    x2: 40
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['优 '+((you/zong)*100).toFixed(1) +'%', '良 '+((liang/zong)*100).toFixed(1) +'%', '中 '+((zhong/zong)*100).toFixed(1) +'%', '差 '+((cha/zong)*100).toFixed(1) +'%']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name:"人数"
                    }
                ],
                series: [
                    {
                        name: '2010',
                        type: 'bar',
                        itemStyle: itemStyle,
                        "barWidth":50,
                        data: [you,liang,zhong,cha]
                    }
                ]
            };

            // 为echarts对象加载数据
            myChart1.setOption(option);
        }
    );
</script>
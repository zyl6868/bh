define(
    [
        'echarts/echarts',
        'sanhai_tools',
        "jquery_sanhai",
        'echarts/chart/bar'

    ],
    function (ec,sanhai_tools) {

        function my_charts(you,liang,zhong,cha,zong){
          // 基于准备好的dom，初始化echarts图表


            var myChart4 = ec.init(document.getElementById('homework_rate')); //题目难度 柱状图

            var zrColor = require('zrender/tool/color');

            var colorList = [ '#7edb92','#10ade5','#f3d883','#f97373'];
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


            var option4 = {
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
                        data: ['优 '+((you/zong)*100).toFixed(2) +'%', '良 '+((liang/zong)*100).toFixed(2) +'%', '中 '+((zhong/zong)*100).toFixed(2) +'%', '差 '+((cha/zong)*100).toFixed(2) +'%'],
                        axisLabel:{textStyle:{fontSize:'18',color:'#666'}}
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
                        name: '优',
                        type: 'bar',
                        itemStyle: itemStyle,
                        "barWidth":50,
                        data: [you,liang,zhong,cha]
                    }
                ]
            };

            // 为echarts对象加载数据
            myChart4.setOption(option4);
        }
        return {my_charts:my_charts};
    }
);
var old = document.getElementsByClassName('sub_content');
var len = old.length;
if(len > 0){
    for(var i = 0;i <= len+1;i++){
        if(old[i]){
            var oldText = old[i].text;
            if(oldText){
                var l = oldText.length;
                if (l > 4) {
                    var newText = oldText.substring(0,4)+"...";
                    old[i].innerText = newText;
                }
            }
        }
    }
}

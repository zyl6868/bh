<?php
//题目分析
use yii\helpers\Url;

?>
<div class="tabItem clearfix">
    <div class="statistics_item clearfix">
        <h6 class="tjqk">客观题正确率</h6>
        <?php
            if(empty($isFinishHomework)){
                echo '还没有学生完成该作业';
            }elseif(empty($objectiveArr)){
                echo '*该作业无客观题';
            }
        ?>
        <div id="echarts01" style="height:300px;"></div>
    </div>
    <div class="statistics_item clearfix">
        <h6 class="tjqk">主观题正确率</h6>
        <?php
        if(empty($isFinishHomework)){
            echo '还没有学生完成该作业';
        }elseif(empty($subjectiveArr)){
            echo '*该作业无主观题';
        }
        ?>
        <div id="echarts02" style="height:300px;"></div>
    </div>
    <div class="statistics_item clearfix">
        <h6 class="tjqk">题目难度正确率</h6>
        <?php
        if(empty($isFinishHomework)){
            echo '还没有学生完成该作业';
        }elseif(empty($complexityNameArr)){
            echo '该作业的题目都没有难度';
        }
        ?>
        <div id="echarts03" style="height:300px;"></div>
    </div>
</div>
<script type="text/javascript">
    
	//折线图
	require(
		[
			'echarts',
			'echarts/chart/line',
			'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
		],
		function (ec) {
			// 基于准备好的dom，初始化echarts图表
            var myChart1 = ec.init(document.getElementById('echarts01')); //主观题
			var myChart2 = ec.init(document.getElementById('echarts02')); //客观题
			var myChart3 = ec.init(document.getElementById('echarts03')); //题目难度 柱状图
			
	
			var option1={
                dataZoom:{
                    show : true,
                    start : 0
                },
				tooltip:{
					show:true,
					formatter: "{c} <点击显示原题>"
				},
				color:['#09f'],
				
				xAxis:[
					{
						type : 'category',name:'题号',
					//	data : ["1","2","3","4","5"]
                        data : <?=json_encode($objectiveArr);?>
					}
				],
				yAxis : [
					{
						type : 'value', name:'正确率（%）',min:0,max:100
					}
				],
				series : [
					{
						"name":"echarts01",
						"type":"line",
					//	"data":[14, 99, 19, 80,14]
                        "data":
                        <?= json_encode($objectiveAnswer); ?>

					}
				]
			};

			var option2={//客观题
                dataZoom:{
                    show : true,
                    start : 0
                },
				tooltip:{
					show:true,
					formatter: "{c} <点击显示原题>"
				},
				color:['#09f'],

				xAxis:[
					{
						type : 'category',name:'题号',
					//	data : ["1","2","3","4","5"]
                        data : <?= json_encode($subjectiveArr);?>
					}
				],
				yAxis : [
					{
						type : 'value', name:'正确率（%）',min:0,max:100
					}
				],
				series : [
					{
						"name":"echarts02",
						"type":"line",
					//	"data":[14, 21, 19, 15,14]
                        data : <?=json_encode($subjectiveAnswer);?>
					}
				]
			};

			var option3 = {//题目难度 柱状图
				tooltip: {
					show: true,
					formatter: "{b} : {c}"
				},
				color:['#4EBBFE'],
				legend: {
					data:['正确率统计']
				},
				xAxis : [
					{
						type : 'category',name:'难易程度',
						//data : ["简单题","中档题","难题"]
                        data : <?= json_encode($complexityNameArr)?>
					}
				],
				yAxis : [
					{
						type : 'value', name:'正确率（%）',min:0,max:100
					}
				],
				series : [
					{
						"name":"正确率",
						"type":"bar",
						"barWidth":"50",
						//"data":[5, 64, 8]
                        "data" : <?= json_encode($complexityRateArr)?>
					}
				]
			};
			
	
			// 为echarts对象加载数据
            <?php if(!empty($objectiveArr)){?>
            myChart1.setOption(option1);
            <?php }?>
            <?php if(!empty($subjectiveArr)){?>
            myChart2.setOption(option2);
            <?php }?>
            <?php if(!empty($complexityNameArr)){?>
			myChart3.setOption(option3);
            <?php }?>
			//添加点击事件
			var ecConfig = require('echarts/config');
			function open_topic_box(param){

				function delBox(){
					var box=document.getElementById('statistics_topic_box');
					if(box) document.body.removeChild(box);
				}
				delBox();

                if(sanhai_tools.isIE(6) ||sanhai_tools.isIE(7)||sanhai_tools.isIE(8)){
                    popBox.errorBox('您的浏览器版本过低,无法显示原题,请升级浏览器,推荐安装<a href="http://dlsw.baidu.com/sw-search-sp/soft/9d/14744/ChromeStandalone_46.0.2490.86_Setup.1447296650.exe" style="color:#fff; text-decoration:underline"><谷歌浏览器></a>');
                }
				else{
					var pageX=param.event.clientX;
					var pageY=param.event.clientY;
					var screenW=document.body.offsetWidth;
					var scrollH=document.body.scrollTop || document.documentElement.scrollTop ;
					var cls="statistics_topic_box";
					if(pageX<screenW/2)	pageX=pageX;
					else{
					pageX=pageX-400;
					cls="statistics_topic_box statistics_topic_box_l";
					}
					pageY=pageY+scrollH;
					var box=document.createElement('div');
					var arrow=document.createElement('i');
					var delBtn=document.createElement('a');
					var boxCont=document.createElement('div');


                    var dataIndex = param.dataIndex;
                    var tableId = param.seriesName;

                    if(tableId == 'echarts01'){
                       var  questionIdArr = <?php  echo json_encode($objectiveTrueArr)?>;
                    }else if(tableId == 'echarts02'){
                      var  questionIdArr = <?php echo  json_encode($subjectiveTrueArr)?>;
                    }

                    var questionId = questionIdArr[dataIndex];
                    $.post('<?= Url::to(['question-info'])?>',{questionId:questionId,'relId':<?php echo $relId;?>},function(data){
                        boxCont.innerHTML=data;
                    });
	
					delBtn.innerHTML="×";
					delBtn.setAttribute('href','javascript:;');
					delBtn.className="delBoxBtn";
					arrow.className="arrow";
					box.appendChild(arrow);
					box.appendChild(delBtn);
					box.appendChild(boxCont);
					box.id="statistics_topic_box";
					box.className=cls;
					box.style.top=pageY+20+"px";
					box.style.left=pageX-100+"px";
	
					document.body.appendChild(box);
					delBtn.onclick=function(){delBox()}
				}
			}
			myChart1.on(ecConfig.EVENT.CLICK,open_topic_box);
			myChart2.on(ecConfig.EVENT.CLICK,open_topic_box);
		}
	);    

</script>

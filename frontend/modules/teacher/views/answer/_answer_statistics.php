<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/7/28
 * Time: 14:05
 */

?>
<div class="asideItem anwser_rate">
	<h4><i></i>答疑统计</h4>

	<div class="pd15">
		<div id="anwser_rate_tab" class="sUI_tab anwser_rate_tab">
			<ul id="statistics_pie" class="tabList list_ul clearfix">
				<li id="pie1" data-id="1" class="lis quesMem">
					<a href="javascript:;" class="ac">
						<em class="que" style="color:#888 !important;">0</em>提问
						<span class="arrow"></span>
					</a>
				</li>
				<li id="pie2" data-id="2" class="lis answerMember">
					<a href="javascript:;">
						<em class="answerMem" style="color:#888 !important;">0</em>回答
						<span class="arrow"></span>
					</a>
				</li>
				<li id="pie3" data-id="3" class="lis isUseMem">
					<a href="javascript:;">
						<em class="isUse" style="color:#888 !important;">0</em>被采纳
						<span class="arrow"></span>
					</a>
				</li>
			</ul>
			<div id="anwser_rate" class="anwser_rate rate" style="height: 300px;">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	require.config({
		paths: {echarts: '<?php echo BH_CDN_RES.'/static' ?>' + '/js/lib/echarts/echarts'}
	});

	// 柱状图
	require(['echarts/echarts', 'echarts/chart/pie'], function (ec) {

		$(function () {
			$(document).ready(function () {
				$.get("<?php echo url("/answernew/personage-answer-statistics")?>", {}, function (data) {
					$(".que").html(data[0]);
					$(".answerMem").html(data[1]);
					$(".isUse").html(data[2]);

				});
			});

			//自动加载提问总数的 饼状图
			$(document).ready(function () {
				$.get("<?php echo url("/answernew/statistical-graph")?>", {}, function (data) {
					al(data);
				});
			});
			//点击提问总数 刷新饼状图
			$('.quesMem').click(function () {
				$.get("<?php echo url("/answernew/statistical-graph")?>", {}, function (data) {
					al(data);
				});
			});
			//点击回答总数 刷新饼状图
			$('.answerMember').click(function () {
				$.get("<?php echo url("/answernew/reply-stat-subject")?>", {}, function (data) {
					al(data);
				});
			});

			//点击被采纳总数 刷新饼状图
			$('.isUseMem').click(function () {
				$.get("<?php echo url("/answernew/reply-is-use-subject")?>", {}, function (data) {
					al(data);
				});
			});
			function al(data) {
				var myChart1 = ec.init(document.getElementById('anwser_rate'));
				option = {
					tooltip: {
						trigger: 'item',
						formatter: "{a} <br/>{b} : {c} ({d}%)",
						enterable: true
					},
					legend: {
						orient: 'vertical',
						x: 'left',
						y: '15px',
						data: data
					},

					calculable: true,
					series: [
						{
							name: '数据',
							center: ['60%', '60%'],
							type: 'pie',
							radius: ['30%', '50%'],
							itemStyle: {
								normal: {
									label: {
										show: false
									},
									labelLine: {
										show: false
									}
								},
								emphasis: {
									label: {
										show: true,
										position: 'center',
										textStyle: {
											fontSize: '30',
											fontWeight: 'bold'
										}
									}
								}
							},
							data: data
						}
					]
				};
				myChart1.setOption(option);
			}
		});
	})
</script>
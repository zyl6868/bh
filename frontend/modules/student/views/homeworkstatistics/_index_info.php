<?php
/**
 * Created by PhpStorm.
 * User: wgl
 * Date: 2016/10/12
 * Time: 11:19
 */

?>
<div id="chart_01" class="chart" style="height: 400px">
</div>

<script>
	require.config({
		paths: {echarts: '<?php echo BH_CDN_RES.'/static'?>' + '/js/lib/echarts'}
	});
	require(['echarts/echarts', 'echarts/chart/bar', 'echarts/chart/line', 'echarts/chart/pie'], function (ec) {
		var myChart01 = ec.init(document.getElementById('chart_01'));
		option = {
			tooltip: {
				trigger: 'item',
				formatter: "{a} <br/>{b} : {c} ({d}%)",
				enterable: true
			},
			color:['#7edb92', '#10ade5','#f3d883','#f97373'],
			legend: {
				orient: 'vertical',
				x: 'left',
				data: <?php echo json_encode($title);?>
			},
			calculable: true,
			series: [
				{
					name: <?php echo json_encode($rateName)?>,
					center: ['50%', '50%'],
					type: 'pie',
					radius: ['40%', '70%'],
					avoidLabelOverlap: false,
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
					data: <?php echo json_encode($newData)?>
				}
			]
		};
		myChart01.setOption(option);
	})

</script>
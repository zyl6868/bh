<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 2016/10/11
 * Time: 11:02
 */
use yii\helpers\Url;

$this->title = '个人统计-作业统计-作业优秀率统计';

$this->registerCssFile(BH_CDN_RES . '/static/css/personal-shortboard.css' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/statistic.css' . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/classes/class_work_excellent';
?>

<div class="main col1200 clearfix statistic_index" id="requireModule" rel="app/classes/class_work_excellent">
	<div class="aside col260 no_bg  alpha">
		<div class="asideItem">
			<div class="sel_classes">
				<div class="pd15">
					<h5 style="text-indent:10px;">作业统计</h5>
					<?php echo $this->render("_statistics_left_list") ?>
				</div>
			</div>
		</div>
		<?php echo $this->render("_homeworkstatistics_left_list") ?>
	</div>

	<div class="container col910 no_bg  omega">

		<div class="item sel_test_bar">
			<div class="sUI_tab">
				<ul class="tabList clearfix" style="background: #fff">
					<li><a href="<?php echo Url::to(['']) ?>" class="ac">作业统计</a></li>
				</ul>
			</div>
		</div>
		<div id="answerPage" style="background:white" class="pd25 answerPage">
			<div class="item sel_test_bar" style="border-bottom:1px solid #f5f5f5">
				<div class="sUI_formList">
					<div class="row">
						<div class="form_l" style="width:auto">
							<a data-sel-item href="javascript:;" style="font-weight: bold;color: #333;">星期：</a>
						</div>
						<div class="form_r" style="margin-left:55px;">
							<input
								style=" width: 190px; height: 40px; line-height: 40px; border: 1px solid #ccc; padding-left: 10px; vertical-align: middle; color: #999;"
								readonly
								class="text1" placeholder="点击选择周" value="<?php echo $defaultTime ?>"
								start="<?php echo $weekStart; ?>" end="<?php echo $weekEnd; ?>"
							>
							<a style="display: inline-block; border-radius: 5px; width: 90px; height: 35px; line-height: 35px; background: #10ade5; text-align: center; color: white; vertical-align: middle; margin-left: 35px;"
							   href="javascript:;" class="search1"
							>查询</a>

							<div class="calendar-wrapper pop" id="week"
							     style="left: 65px; top: 45px; width: 200px; border: 1px solid #cccccc">
								<div id="calendar-weekly" class="calendar-weekly"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="statistics">
				<?php echo $this->render('_index_info', ['newData' => $newData, 'title' => $title, 'rateName' => $rateName]); ?>
			</div>
		</div>
	</div>
</div>


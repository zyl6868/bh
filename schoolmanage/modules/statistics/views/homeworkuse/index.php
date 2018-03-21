<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/4/28
 * Time: 9:35
 */

$this->title = "作业使用统计";
$this->blocks['requireModule']='app/statistic/use_Statistics';

?>

<div class="main col1200 clearfix workStatistic" id="requireModule" rel="app/statistic/work_Statistics">
    <div class="aside col260 no_bg  alpha">
        <div class="asideItem" style="margin-bottom:0;">
            <div class="sel_classes">
                <div class="pd15">
                    <h5>使用统计</h5>
                </div>
            </div>
        </div>
        <div class="aside col260 alpha no_bg clearfix">
            <?php echo $this->render("/publicView/_personnel_left") ?>
        </div>
    </div>

    <div class="container col910  omega work_statistics">
        <div class="time">
            <span>开始时间：</span>
            <div><?php echo $week_start;?></div>
            <span>结束时间：</span>
            <div><?php echo $week_end;?></div>
        </div>
        <div class="pd25" id="viewpage" style="overflow-x: auto">
            <?= $this->render("_namelist", ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>



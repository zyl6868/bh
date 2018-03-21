<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/2/27
 * Time: 10:00
 */
use common\models\pos\SeClass;

?>
<div class="tabItem" classId="<?= $classId?>">
    <div class="echarts_item">
        <div class="sUI_pannel  title_pannel">
            <div class="pannel_l"><h5>平均分对比</h5></div>
            <div class="pannel_r">
                <select id="chartOne" examId="<?=$examId?>">
                    <option  value="">总成绩</option>
                    <?php if(!empty($subList)){foreach($subList as $key=>$val){?>
                        <option  value="<?=$key?>"><?=$val?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
        <div id="chart_01" class="chart"></div>
        <?php echo $this->render("_average_class",['dataList'=>$dataList])?>
    </div>
    <div class="echarts_item">
        <div class="sUI_pannel  title_pannel">
            <div class="pannel_l"><h5>三率对比</h5></div>
            <div class="pannel_r">
                <select id="chartTwo" examId="<?=$examId?>">
                    <option  value="">总成绩</option>
                    <?php if(!empty($subList)){foreach($subList as $key=>$val){?>
                        <option  value="<?=$key?>"><?=$val?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
        <div id="chart_02" class="chart"></div>

    </div>
    <div class="echarts_item">
        <div id="chart_03" class="chart"></div>
    </div>
    <div class="echarts_item">
        <div id="chart_04" class="chart"></div>
    </div>
        <?php echo $this->render("_three_contrast_class",['contrastList'=>$contrastList,'passList'=>$passList,'lowList'=>$lowList])?>
    <div class="echarts_item">
        <div class="sUI_pannel title_pannel">
            <div class="pannel_l"><h5>分数占比对比</h5></div>
            <div class="pannel_r">
                <select id="chartThree" examId="<?=$examId?>">
                    <option  value="">总成绩</option>
                    <?php if(!empty($subList)){foreach($subList as $key=>$val){?>
                        <option  value="<?=$key?>"><?=$val?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
        <div id="chart_05" class="chart" style="height: 400px"></div>
        <br>
        <!--<div id="chart_06" class="chart"  style="height: 400px"></div>-->
        <?php echo $this->render("_top_low_class",['topList'=>$topList,'lowScoreList'=>$lowScoreList])?>
    </div>
</div>

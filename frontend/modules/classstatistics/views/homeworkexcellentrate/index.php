<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/7
 * Time: 14:11
 */
use yii\helpers\Url;

$this->title = '班级统计-作业统计-作业未完成统计';
$this->blocks['requireModule']='app/classes/class_work_excellent';
?>

<div class="main col1200 clearfix statistic_index" id="requireModule" rel="app/classes/class_work_excellent">
    <div class="aside col260 no_bg  alpha">
        <div class="asideItem">
            <div class="sel_classes">
                <div class="pd15">
                    <h5 style="text-indent:10px;">作业统计</h5>
                    <?php echo $this->render("@app/modules/classstatistics/views/default/_statistics_left_list",['classId'=>$classId])?>
                </div>
            </div>
        </div>
        <?php echo $this->render("@app/modules/classstatistics/views/homeworkunfinish/_homeworkstatistics_left_list",['classId'=>$classId])?>

    </div>
    <div class="container col910 no_bg  omega">
        <div class="item sel_test_bar">
            <div class="sUI_tab">
                <ul class="tabList clearfix" style="background: #fff">
                    <li><a href="<?php echo Url::to(['homeworkexcellentrate/index','classId'=>$classId])?>" class="ac">班级作业统计</a></li>
                </ul>
            </div>
        </div>


        <div id="answerPage" style="background:white" class="pd25 answerPage">
            <div class="item sel_test_bar" style="border-bottom:1px solid #f5f5f5">
                <div class="sUI_formList">
                    <div class="row">
                        <div class="form_l" style="width:auto">
                            <a data-sel-item href="javascript:;" style="font-weight: bold;color: #333;">年份：</a>
                        </div>
                        <div class="form_r" style="margin-left:55px;">
                            <ul class="testList clearfix" id="select_year" data-url="<?= Yii::$app->getRequest()->getUrl()?>">
                                <?php foreach($years as $year){?>
                                    <li><a data-sel-item href="javascript:;" class="<?php
                                        if(date('Y',strtotime($firstDay)) == $year){echo 'sel_ac';} ?>" data-value="<?= $year?>"><?= $year ?></a></li>
                                <?php }?>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form_l" style="width:auto">
                            <a data-sel-item href="javascript:;" style="font-weight: bold;color: #333;">月份：</a>
                        </div>
                        <div class="form_r" style="margin-left:55px;">
                            <ul class="testList clearfix" id="select_month" data-url="<?= url::to('index',['classId'=>$classId]);?>">
                                <?php foreach($months as $month){
                                    ?>
                                    <li><a data-sel-item href="javascript:;" class="<?php
                                    if(date('m',strtotime($firstDay))  == $month){echo 'sel_ac';} ?>" data-value="<?= $month ?>" ><?= $month ?>月</a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="statistics">
                <?php echo $this->render('_index_info',['subjectArr'=>$subjectArr ,'data'=>$data]);?>
            </div>

        </div>
    </div>
</div>


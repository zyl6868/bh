<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile(BH_CDN_RES.'/pub/js/echarts/echarts.js',['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine-zh_CN.js');
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine.min.js');
$this->title="作业统计";

?>
<div class="grid_19 main_r">
        <div class="main_cont statistics_cont">
            <div class="title"> <a href="<?= Url::to(['/teacher/managetask/work-details','classhworkid'=>$relId])?>" class="txtBtn backBtn"></a>
                <h4>作业统计</h4>
            </div>
            <h5 class="zyname"><?php echo cut_str(Html::encode($homeWorkTeacher->name), 30)?></h5>
            <div class="tab">
            <ul class="tabList clearfix">
                    <li class="tabListShow" shuxing="1"><a href="javascript:;" class="ac">总体分析</a></li>
                <?php if($homeWorkTeacher->getType == 1):?>
                    <li class="tabListShow" shuxing="2"><a href="javascript:;">题目分析</a></li>
                    <li class="tabListShow" shuxing="3"><a href="javascript:;">学生分析</a></li>
                <?php endif;?>
            </ul>
            <div class="tabCont">
                <?php echo $this->render('work_statistical_all',array('relId'=>$relId,'overtimeId'=>$overtimeId,'noAnswerdId'=>$noAnswerdId,'deadlineTime'=>$deadlineTime,'level'=>$level));?>
          </div>
        </div>
    </div>
</div>
<script>
    $('.tabListShow').click(function(){
        $("#layerTopic,#statistics_topic_box").remove();
        var shuxing = $(this).attr('shuxing');
        var relId = <?php echo $relId;?>;
        var topicUrl = '';
        if(shuxing == '1'){
            topicUrl = '<?php echo Url::to(["work-statistical"]);?>';
        }else if(shuxing == '2'){
            topicUrl = '<?php echo Url::to(["work-statistical-topic"]);?>';
        }else if(shuxing == '3'){
            topicUrl = '<?php echo Url::to(["work-statistical-student"]);?>';
        }
        $.get(topicUrl,{relId:relId},function(data){
            $('.tabCont').html(data);
        });
    })
</script>
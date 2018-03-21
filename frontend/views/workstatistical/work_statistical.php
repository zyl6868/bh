<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile(BH_CDN_RES.'/pub/js/echarts/echarts.js',['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine-zh_CN.js');
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine.min.js');
$this->title="作业统计";
$this->blocks['requireModule']='app/classes/tch_hmwk_result_all';
?>

<div class="main col1200 clearfix tch_hmwk_result"   id="requireModule" rel="app/classes/tch_hmwk_result_all">
    <div class="container homework_title">
        <span class="return_btn"><a id="addmemor_btn"  href="javascript:history.back(-1);" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a></span>
        <h4><?php echo cut_str(Html::encode($homeWorkTeacher->name), 30)?></h4>
    </div>
    <div class="container">
        <div class="sUI_tab">
            <ul class="tabList clearfix">
                    <li class="tabListShow" shuxing="1"><a href="javascript:;" class="ac">总体分析</a></li>
                <?php if($homeWorkTeacher->getType == 1):?>
                    <li class="tabListShow" shuxing="2"><a href="javascript:;" class="b">题目分析</a></li>
                    <li class="tabListShow" shuxing="3"><a href="javascript:;" class="d">学生分析</a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>

</div>

<script>
    $('.tabListShow').click(function(){
        $('.tabListShow').children().attr('class','');
        $(this).children().attr('class','ac');
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
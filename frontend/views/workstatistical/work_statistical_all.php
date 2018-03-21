<?php
use common\helper\DateTimeHelper;
use common\components\WebDataCache;
use yii\helpers\Html;

$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/echarts.js',['position'=>\yii\web\View::POS_HEAD]);
$classModel=   $this->params['classModel'];
$classId = $classModel->classID;

$this->title="作业统计";
$this->blocks['requireModule']='app/classes/tch_hmwk_result_all';
?>
<div class="main col1200 clearfix tch_hmwk_result"   id="requireModule" rel="<?php echo BH_CDN_RES.'/static/js/app/classes/tch_hmwk_result_all'?>">
    <div class="container homework_title">
        <a id="addmemor_btn" href="<?= url('class/homework', ['classId' => $classId]) ?>" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
        <h4><?php echo cut_str(Html::encode($homeWorkTeacher->name), 30)?></h4>
    </div>
    <div class="container">
        <div class="sUI_tab">
            <ul class="tabList clearfix">
                <li class="tabListShow"><a href="<?php echo \yii\helpers\Url::to(["/workstatistical/work-statistical-all",'relId'=>$relId]);?>" class="ac">总体分析</a></li>
                <?php if($homeWorkTeacher->getType == 1):?>
                    <li class="tabListShow"><a href="<?php echo \yii\helpers\Url::to(["/workstatistical/work-statistical-topic",'relId'=>$relId]);?>">题目分析</a></li>
                    <li class="tabListShow"><a href="<?php echo \yii\helpers\Url::to(["/workstatistical/work-statistical-student",'relId'=>$relId]);?>">学生分析</a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <div class="container">
        <h4 class="cont_title"><i class="t_ico_user"></i>未按时提交作业人员</h4>
        <span class="alert_txt"><b></b>红色姓名代表作业仍未提交</span>

        <?php
        if(DateTimeHelper::timestampX1000()<$deadlineTime):?>
            <div class="noend">作业还未截止，请截止后查看</div>
        <?php else:?>
            <ul class="topic_userList">
                <?php foreach($overtimeId as $v):?>
                    <li class=""> <a style="width: 67px;" class="sub_content" href="javascript:;" title="<?php echo WebDataCache::getTrueNameByuserId($v); ?>"><?php echo WebDataCache::getTrueNameByuserId($v); ?></a></li>
                <?php endforeach;?>
                <?php foreach($noAnswerdId as $v1):?>
                    <li ><a style="width: 67px;" class="sub_content ac" href="javascript:;" title="<?php echo WebDataCache::getTrueNameByuserId($v1); ?>"><?php echo WebDataCache::getTrueNameByuserId($v1); ?></a></li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>

    </div>
    <div class="container">
            <h4 class="cont_title"><i class="t_ico_rate"></i>作业优良率分布比例</h4>

            <div class="pd25">
                <div id="homework_rate" style="height:400px;"></div>
                <p  class="tc red">优：作业正确率大于90%；&nbsp;&nbsp;&nbsp;
                良：作业正确率介于80%-90%；&nbsp;&nbsp;&nbsp;

                中：作业正确率介于60%-80%；&nbsp;&nbsp;&nbsp;
                差：作业正确率小于60%。</p>

                <?php
                    $excellent=!empty($level[4]) ? $level[4]: 0 ;
                    $good=!empty($level[3]) ? $level[3]: 0 ;
                    $middle=!empty($level[2]) ? $level[2]: 0 ;
                    $poor=!empty($level[1]) ? $level[1]: 0 ;
                    $total=$excellent + $good + $middle + $poor ;
                    if(!empty($total)){

                        $excPer = sprintf("%.2f",($excellent / $total) * 100);
                        $goodPer = sprintf("%.2f",($good / $total) * 100);
                        $midPer = sprintf("%.2f",($middle / $total) * 100);
                        $poorPer = sprintf("%.2f",($poor / $total) * 100);

                        if ($poorPer >= 10) {
                            echo '<div class="pd25 words">本次作业有' . $total . '人已批改，获得差的同学有' . $poor . '人（' . $poorPer . '%),差生占比较大，请多加注意！</div>';
                        }
                    }
                ?>

            </div>

    </div>
    <div class="container hide">
        <h4 class="cont_title"><i class="t_ico_list"></i>联盟排名</h4>
        <div class="pd25">
        </div>
    </div>
</div>


<script type="text/javascript">
    var you   = <?php echo $excellent; ?>;
    var liang = <?php echo $good ;?>;
    var zhong = <?php echo $middle ;?>;
    var cha   = <?php echo $poor ;?>;
    var zong = you+liang+zhong+cha;
    if(zong == 0){
        zong = 1;
    }
    $(function(){
        require(['app/classes/tch_hmwk_result_all'],function(result_all){
            result_all.my_charts(you,liang,zhong,cha,zong);

        })
    })
</script>
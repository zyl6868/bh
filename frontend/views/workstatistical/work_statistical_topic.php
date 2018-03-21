<?php
//题目分析
use yii\helpers\Html;

$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/echarts.js',['position'=>\yii\web\View::POS_HEAD]);
$classModel=   $this->params['classModel'];
$classId = $classModel->classID;

$this->title="作业统计";
$this->blocks['requireModule']='app/classes/tch_hmwk_result';
?>
<div class="main col1200 clearfix tch_hmwk_result"   id="requireModule" rel="<?php echo BH_CDN_RES.'/static/js/app/classes/tch_hmwk_result'?>">
    <div class="container homework_title">
        <a id="addmemor_btn" href="<?= url('class/homework', ['classId' => $classId]) ?>" class="btn bg_gray icoBtn_back return_btn"><i></i>返回</a>
        <h4><?php echo cut_str(Html::encode($homeWorkTeacher->name), 30)?></h4>
    </div>
    <div class="container">
        <div class="sUI_tab">
            <ul class="tabList clearfix">
                <li class="tabListShow"><a href="<?php echo \yii\helpers\Url::to(["/workstatistical/work-statistical-all",'relId'=>$relId]);?>">总体分析</a></li>
                <?php if($homeWorkTeacher->getType == 1):?>
                    <li class="tabListShow"><a href="<?php echo \yii\helpers\Url::to(["/workstatistical/work-statistical-topic",'relId'=>$relId]);?>" class="ac">题目分析</a></li>
                    <li class="tabListShow"><a href="<?php echo \yii\helpers\Url::to(["/workstatistical/work-statistical-student",'relId'=>$relId]);?>" >学生分析</a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <div class="container">
        <h4 class="cont_title"><i class="t_ico_rate"></i>客观题正确率<span>注：点击题号(蓝点)可以查看题目详情</span></h4>
        <div class="pd25">
            <?php
            if(empty($isFinishHomework)){
                echo '还没有学生完成该作业';
            }elseif(empty($objectiveArr)){
                echo '*暂无数据';
            }
            ?>
            <div id="echarts01" style="height:300px;"></div>

            <?php
                if(!empty($objectiveArr)):
            ?>
            <?php
                $leastRad = [];
                foreach($objectiveArr as $k=>$v){
                    if($objectiveAnswer[$k] <= 30){
                        $leastRad[$v]=$objectiveAnswer[$k];
                    }
                }

                if(!empty($leastRad)){
                    echo '<div class="pd25 words"> 客观题 ';
                    list($last_key, $last) = (end($leastRad) ? each($leastRad) : each($leastRad));
                    array_pop($leastRad);
                    foreach($leastRad as $key => $val){
                        echo '第'.$key.'正确率为'.$val.'%，';
                    }
                    echo '第'.$last_key.'正确率为'.$last.'%。</div>';
                }
            ?>

            <?php endif;?>

        </div>
    </div>
    <div class="container">
        <h4 class="cont_title"><i class="t_ico_list"></i>主观题正确率<span>注：点击题号(蓝点)可以查看题目详情</span></h4>
        <div class="pd25">
            <?php
            if(empty($isFinishHomework)){
                echo '还没有学生完成该作业';
            }elseif(empty($subjectiveArr)){
                echo '*暂无数据';
            }
            ?>
            <div id="echarts02" style="height:300px;"></div>

            <?php
                if(!empty($subjectiveArr)) {
                    $leastRad = [];
                    foreach ($subjectiveArr as $k => $v) {
                        if($subjectiveAnswer[$k] <= 30){
                            $leastRad[$v] = $subjectiveAnswer[$k];
                        }
                    }

                    if(!empty($leastRad)){
                        echo '<div class="pd25 words"> 主观题 ';
                        list($last_key, $last) = (end($leastRad) ? each($leastRad) : each($leastRad));array_pop($leastRad);
                        foreach($leastRad as $key=>$val){
                            echo '第' . $key . '正确率为' . $val . '%，';
                        }
                        echo '第' . $last_key . '正确率为' . $last . '%。</div>';
                    }

                }
            ?>

        </div>
    </div>

    <div class="container">
        <h4 class="cont_title"><i class="t_ico_list"></i>题目难度正确率</h4>
        <div class="pd25">
            <?php
            if(empty($isFinishHomework)){
                echo '还没有学生完成该作业';
            }elseif(empty($complexityNameArr)){
                echo '暂无数据';
            }
            ?>
            <div id="echarts03" style="height:300px;"></div>

            <?php
            if(!empty($complexityNameArr)):
                $complexityArr = [];
                foreach($complexityNameArr as $k=>$v){
                    $complexityArr[$v]['persum'] = $complexityPersumArr[$k];
                    $complexityArr[$v]['sum'] = $complexitySumArr[$k];
                    $complexityArr[$v]['per'] = $complexityRateArr[$k];
                }
            ?>

            <div class="pd25 words" style="margin-top: 0;">

            <?php
                if(array_key_exists('较难',$complexityArr) && array_key_exists('困难',$complexityArr)){
                    $complexityPer = sprintf("%.2f",($complexityArr['较难']['persum']+$complexityArr['困难']['persum'])/($complexityArr['较难']['sum']+$complexityArr['困难']['sum'])*100);

                    if($complexityPer >= 60){
                        echo '较难和困难题目正确率为'.$complexityPer.'%，尖端知识掌握程度较高，继续保持！<br/>';
                    }else{

                        echo '较难和困难题目正确率为'.$complexityPer.'%，尖端知识掌握程度较低，需加强关注！<br/>';
                    }
                }else if(array_key_exists('较难',$complexityArr) && array_key_exists('困难',$complexityArr) == false){
                    if($complexityArr['较难']['per'] >= 60){
                        echo '较难题目正确率为'.$complexityArr["较难"]['per'].'%，尖端知识掌握程度较高，继续保持！<br/>';
                    }else{
                        echo '较难题目正确率为'.$complexityArr["较难"]['per'].'%，尖端知识掌握程度较低，需加强关注！<br/>';
                    }
                }else if(array_key_exists('困难',$complexityArr) && array_key_exists('较难',$complexityArr) == false){
                    if($complexityArr['困难']['per'] >= 60){
                        echo '困难题目正确率为'.$complexityArr["困难"]['per'].'%，尖端知识掌握程度较高，继续保持！<br/>';
                    }else{
                        echo '困难题目正确率为'.$complexityArr["困难"]['per'].'%，尖端知识掌握程度较低，需加强关注！<br/>';
                    }
                }

                if(array_key_exists('一般',$complexityArr)){
                    if($complexityArr['一般']['per'] >= 60){
                        echo '一般题目正确率为'.$complexityArr["一般"]['per'].'%，知识点掌握较平均，继续保持！<br/>';
                    }else{
                        echo '一般题目正确率为'.$complexityArr["一般"]['per'].'%，知识点掌握不均匀，需加强关注！<br/>';
                    }
                }

                if(array_key_exists('容易',$complexityArr) && array_key_exists('较易',$complexityArr)){

                    $complexityPer = sprintf("%.2f",($complexityArr['容易']['persum']+$complexityArr['较易']['persum'])/($complexityArr['容易']['sum']+$complexityArr['较易']['sum'])*100);

                    if($complexityPer >= 60){
                        echo '容易和较易题目正确率为'.$complexityPer.'%，基础知识掌握良好，继续保持！';
                    }else{
                        echo '容易和较易题目正确率为'.$complexityPer.'%，基础知识掌握薄弱，需加强学习！';
                    }

                }else if(array_key_exists('容易',$complexityArr) && array_key_exists('较易',$complexityArr) == false){
                    if($complexityArr['容易']['per'] >= 60){
                        echo '容易题目正确率为'.$complexityArr["容易"]['per'].'%，基础知识掌握良好，继续保持！';
                    }else{
                        echo '容易题目正确率为'.$complexityArr["容易"]['per'].'%，基础知识掌握薄弱，需加强学习！';
                    }
                }else if(array_key_exists('较易',$complexityArr) && array_key_exists('容易',$complexityArr) == false){
                    if($complexityArr['较易']['per'] >= 60){
                        echo '较易题目正确率为'.$complexityArr["较易"]['per'].'%，基础知识掌握良好，继续保持！';
                    }else{
                        echo '较易题目正确率为'.$complexityArr["较易"]['per'].'%，基础知识掌握薄弱，需加强学习！';
                    }
                }

            ?>

            </div>

            <?php endif;?>
        </div>
    </div>
</div>

<script type="text/javascript">
    var option1_xAxis = <?=json_encode($objectiveArr);?>;
    var option1_series = <?= json_encode($objectiveAnswer); ?>;
    var option2_xAxis = <?= json_encode($subjectiveArr);?>;
    var option2_series = <?=json_encode($subjectiveAnswer);?>;
    var option3_xAxis = <?= json_encode($complexityNameArr)?>;
    var option3_series = <?= json_encode($complexityRateArr)?>;
    var relId= <?php echo $relId;?>;
    var objectiveTrueArr = <?php echo json_encode($objectiveTrueArr)?>;
    var subjectiveTrueArr = <?php echo json_encode($subjectiveTrueArr)?>;
    $(function(){
        require(['app/classes/tch_hmwk_result'],function(result_all){
            result_all.my_charts(option1_xAxis,option1_series,option2_xAxis,option2_series,option3_xAxis,option3_series,relId,objectiveTrueArr,subjectiveTrueArr);

        })
    })
</script>

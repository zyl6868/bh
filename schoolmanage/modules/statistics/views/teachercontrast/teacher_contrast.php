<?php
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

$this->title = '学校统计-老师对比';
$searchArr= array(
    'schoolLevel'=>app()->request->getParam('schoolLevel'),
    'gradeId'=>app()->request->getParam('gradeId'),
);
$this->blocks['requireModule']='app/statistic/teacher_contrast';
?>
<div class="main col1200 clearfix teacher_contrast" id="requireModule" rel="app/statistic/teacher_contrast">
<div class="container no_bg">
        <div class="item">
            <a href="<?php echo Url::to(['/statistics/default/index','schoolLevel'=>$examResult->departmentId])?>" class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
            <h4 class="test_title"><?=$examResult->examName?></h4>
        </div>
        <div class="item no_bg echarts_bar">
            <div class="sUI_tab">
                <?php echo $this->render("@app/modules/statistics/views/default/options_list",['examId'=>$examId]);?>
                <div class="tabCont">
                    <div class="tabItem">
                        <div class="echarts_item" style="margin: 0">
                            <div class="sUI_pannel  title_pannel">

                            </div>
                            <ul id="subList_con" class="subList_con">
                                <?php foreach($subjectResult as $v){?>
                                <li data-sel-value="<?=$v->subjectId?>" data-sel-item=""><a href="javascript:;"><?php echo SubjectModel::model()->getName($v->subjectId)?></a><span class="arrow"></span></li>
                                <?php }?>
                            </ul>
                            <div class="subject_table">
                            </div>
                        </div>
                        <div class="echart_bar">
                            <div style="font-size:18px;text-align: center; height: 100px; line-height: 100px; color: #999">请选择科目</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#subList_con li').click(function(){
        var $this=$(this);
        var schoolExamId=<?=$examId?>;
        var subjectId=$this.attr('data-sel-value');
        $.post('<?=Url::to(["/statistics/teachercontrast/get-teacher-and-class-list"])?>',{
            subjectId:subjectId,
            schoolExamId:schoolExamId
        },function(result){
            $this.addClass('sel_ac').siblings('li').removeClass('sel_ac');
                $('.subject_table').html(result);
            $.post('<?=Url::to(["/statistics/teachercontrast/teacher-contrast"])?>',{
                dataResult:$('.dataResult').val(),schoolExamId:schoolExamId,subjectId:subjectId
            },function(result){
                $(".echart_bar").html(result);
            })
        })
    })
</script>

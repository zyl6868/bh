﻿﻿<?php
use yii\helpers\Url;

$this->title = '学校统计-班级对比';
$searchArr = array(
    'schoolLevel' => app()->request->getParam('schoolLevel'),
    'gradeId' => app()->request->getParam('gradeId'),
);
$this->blocks['requireModule']='app/statistic/classes_contrast';
?>
<script type="text/javascript">
    require.config({
        paths: {echarts:'<?php echo BH_CDN_RES.'/static' ?>'+'/js/lib/echarts'}
    });
</script>
<div class="main col1200 clearfix classes_contrast" id="requireModule" rel="app/statistic/classes_contrast">


    <div class="container no_bg">
        <div class="item">
            <a href="<?= url::to(['/statistics/default', 'schoolLevel' => $examSchool->departmentId]) ?>"
               class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
            <h4 class="test_title"><?php if (!empty($examSchool)) {
                    echo $examSchool->examName;
                } ?></h4>
        </div>
        <div class="item no_bg echarts_bar">
            <div class="sUI_tab">
                <?php echo $this->render("options_list", ['examId' => $examId]); ?>
                <div class="tabCont">
                    <?php echo $this->render("_class_chart", ['examId' => $examId, 'subList' => $subList,
                        'dataList' => $dataList, 'contrastList' => $contrastList,'studentAnalyze'=>$studentAnalyze,
                        'passList' => $passList, 'lowList' => $lowList, 'topList' => $topList, 'lowScoreList' => $lowScoreList]);?>
                </div>
            </div>

        </div>


    </div>


</div>




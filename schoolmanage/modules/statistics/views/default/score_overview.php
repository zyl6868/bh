<?php
use common\models\pos\SeClass;

$this->title = '学校统计-概览';
$searchArr= array(
    'schoolLevel'=>app()->request->getParam('schoolLevel'),
    'gradeId'=>app()->request->getParam('gradeId'),
);
$this->blocks['requireModule']='app/statistic/score_overview';
?>

<div class="main col1200 clearfix score_overview" id="requireModule" rel="app/statistic/score_overview">

    <div class="container  no_bg">
        <div class="item">
            <?php echo $this->render("@app/modules/statistics/views/default/exam_title",['examName'=>$examName]);?>
        </div>
        <div class="item no_bg echarts_bar">
            <div class="sUI_tab">
                <?php echo $this->render("options_list",['examId'=>$examId]);?>

                <div class="tabCont" style="border:0;border-top:1px solid #e7e7e7;">
                    <div class="tabItem">
                        <div class="echarts_item">
                            <div class="sUI_pannel  title_pannel">
                                <div class="pannel_l"><h5>成绩概览</h5></div>
                                <div class="pannel_r">
                                    <select id="grade_select" data-id="<?= $examId?>">
                                        <option data-id="">全年级</option>
                                        <?php foreach($examClass as $class){?>
                                        <option data-id="<?= $class->classId?>"><?= \common\components\WebDataCache::getClassesNameByClassId($class->classId) ?></option>
                                        <?php }?>
                                    </select>
                                    <select id="subject_select" data-id="<?= $examId?>">
                                        <option data-id="">全部学科</option>
                                        <?php foreach($seExamSubject as $subject){?>
                                        <option data-id="<?= $subject->subjectId?>"><?= \common\models\dicmodels\SubjectModel::model()->getName((int)$subject->subjectId)?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div id="overview_info">
                                <?php
                                if(empty($subjectId)){
                                    echo $this->render('_score_overview_info' , ['seExamReprotBaseInfoList'=>$seExamReprotBaseInfoList ,
                                        'subjectId'=>$subjectId,
                                        'classId' =>$classId,
                                        'section'=>$section,
                                        'count'=>$count,
                                    ]);
                                }else{
                                    echo $this->render('_score_overview_info' , ['seExamReprotBaseInfoList'=>$seExamReprotBaseInfoList ,
                                        'subjectId'=>$subjectId,
                                        'classId' =>$classId,
                                        'section'=>$section,
                                        'count'=>$count,
                                        'rankListDesc'=>$rankListDesc,
                                        'rankListAsc'=>$rankListAsc
                                    ]);
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


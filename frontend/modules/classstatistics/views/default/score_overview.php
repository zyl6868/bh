<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/19
 * Time: 13:19
 */

$this->title = '班级统计-概览';
$searchArr= array(
    'schoolLevel'=>app()->request->getParam('schoolLevel'),
    'gradeId'=>app()->request->getParam('gradeId'),
);
$this->blocks['requireModule']='app/classes/score_overview';
?>
<div class="main col1200 clearfix score_overview" id="requireModule" rel="app/classes/score_overview">

    <div class="container  no_bg">
        <div class="item">
            <?php echo $this->render("@app/modules/classstatistics/views/default/exam_title",['examName'=>$examName,'classId'=>$classId]);?>
        </div>
        <div class="item no_bg echarts_bar">
            <div class="sUI_tab">
                <?php echo $this->render("options_list",['examId'=>$examId,'classId'=>$classId]);?>

                <div class="tabCont">
                    <div class="tabItem">
                        <div class="echarts_item">
                            <div class="sUI_pannel  title_pannel">
                                <div class="pannel_l"><h5>成绩概览</h5></div>
                                <div class="pannel_r">
                                    <select id="subject_select" data-id="<?= $examId?>" classId="<?= $classId?>">
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
<?php

use common\models\pos\SeClass;

$this->title = '学校统计-上线分数';
$this->blocks['requireModule']='app/statistic/online_score';
?>
<div class="main col1200 clearfix online_score" id="requireModule" rel="app/statistic/online_score">
    <div class="container no_bg">
        <div class="item">
            <?php echo $this->render("@app/modules/statistics/views/default/exam_title",['examName'=>$examName]);?>
       </div>
        <div class="item no_bg echarts_bar">
            <div class="sUI_tab">
                <?php echo $this->render("@app/modules/statistics/views/default/options_list",['examId'=>$examId]);?>
                <div class="tabCont">
                    <div class="tabItem">
                        <div class="echarts_item">
                            <div class="sUI_pannel  title_pannel">
                                <div class="pannel_l">
                                    <h6>上线分数分析</h6>
                                </div>
                            </div>
                            <div  class="tableWrap" style="padding-top: 20px">
                                <table class="sUI_table sUI_table_border online_table">
                                    <thead>
                                    <th></th>
                                    <th>总分</th>

                                    <?php
                                    $totalScore = 0;
                                    foreach($seExamSubject as $subject){
                                        $totalScore += $subject->borderlineOne;
                                        ?>
                                    <th colspan="3"><?= \common\models\dicmodels\SubjectModel::model()->getName((int)$subject->subjectId)?></th>
                                    <?php }?>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>分数线</td>
                                        <td><?=  sprintf("%.2f",$totalScore)?></td>
                                        <?php foreach($seExamSubject as $subjectScore){?>
                                        <td colspan="3"><?= $subjectScore->borderlineOne?></td>
                                        <?php }?>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>总分上线</td>
                                        <?php for($i=0;$i<count($seExamSubject);$i++){?>
                                        <td>双上线</td>
                                        <td>单科未上</td>
                                        <td>贡献率</td>
                                        <?php }?>
                                    </tr>

                                    <?php foreach($data as $key => $val){ ?>
                                        <tr>
                                            <td><?= \common\components\WebDataCache::getClassesNameByClassId($key) ?></td>
                                            <td><?= $val['totalOverLineNum']?></td>
                                            <?php foreach($val['subject'] as $subVal){?>
                                            <td><?= $subVal['bothOverLineNum']?></td>
                                            <td><?= $subVal['singleNotOverLineNum']?></td>
                                            <td><?= sprintf("%.2f",$subVal['contributionRate'])?></td>
                                            <?php }?>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                    <tfoot>
                                    <tr style="background: #f5f5f5">
                                        <td>全校总计</td>
                                        <td><?= $totalOverlineArr['totalOverLine']?></td>
                                        <?php foreach($totalOverlineArr['subject'] as $totalOverline){?>
                                        <td><?= $totalOverline['bothOverLineNumTotal']?></td>
                                        <td><?= $totalOverline['singleNotOverLineNumTotal']?></td>
                                        <td><?= sprintf("%.2f",$totalOverline['totalcontributionRate'])?></td>
                                        <?php }?>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <br>
                            <div class="sUI_pannel">
                                <div class="pannel_r">
                                    <select id="grade_select" data-id="<?php echo $examId?>">
                                        <option data-id="">全年级</option>
                                        <?php foreach($examClass as $class){?>
                                            <option data-id="<?php echo $class->classId?>"><?php echo \common\components\WebDataCache::getClassesNameByClassId($class->classId) ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div id="statistics">
                                <?php echo $this->render('statistics',['onlineNum'=>$onlineNum]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
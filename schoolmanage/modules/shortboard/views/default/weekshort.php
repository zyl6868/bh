<?php
use yii\helpers\Url;

$this->title = '短板统计';
$searchArr= array(
    'schoolLevel'=>app()->request->getParam('schoolLevel'),
    'gradeId'=>app()->request->getParam('gradeId'),
);
$this->blocks['requireModule']='app/shortboard/shortboard_index';
?>
<div class="main col1200 clearfix school_short_pool" id="requireModule" rel="app/shortboard/shortboard_index">
    <div class="aside col260 no_bg alpha">
        <?php echo $this->render("_index_exam_left_department_grade_list",['searchArr'=>$searchArr,"gradeModel"=>$gradeModel,'department'=>$department,'lengthOfSchooling'=>$lengthOfSchooling,'upTime'=>$upTime]);?>
    </div>

    <div class="container col910 no_bg omega">
        <div class="container gnn_main">
        <div class="item sel_test_bar">
            <div id="time_tab" class="sUI_tab">
                <ul class="tabList clearfix" style="background: #fff">
                    <li><a href="<?php echo Url::to(["/shortboard/default/index",'schoolLevel'=>$schoolLevelId,'gradeId'=>$gradeId,'joinYear'=>$joinYear]);?>">月短板</a></li>
                    <li><a href="<?php echo Url::to(["/shortboard/default/week-short",'schoolLevel'=>$schoolLevelId,'gradeId'=>$gradeId,'joinYear'=>$joinYear]);?>" class="ac">周短板</a></li>
                </ul>
                <div class="tabCont">
                    <div class="tabItemm selector clearfix">
                        <div class="gnn_tabCon">
                            <label>学科：</label>
                            <select id="subject_select1" joinYear="<?php echo $joinYear;?>" schoolLevelId=<?php echo $schoolLevelId ;?>>
                                <?php foreach($subjectNumber as $v):
                                    foreach($v as $key=>$val):
                                        ?>
                                        <option subjectId="<?php echo $key?>"><?php echo $val;?></option>
                                    <?php endforeach;endforeach;?>
                            </select>

                            <label>星期：</label>
                            <input class="text1" placeholder="点击选择周" value="<?php echo $defaultTime?>" start="<?php echo $weekstart;?>" end="<?php echo $weekend;?>">
                            <a href="javascript:;" class="search1">查询</a>

                            <div class="calendar-wrapper  pop" id="week">
                                <div id="calendar-weekly" class="calendar-weekly"></div>
                            </div>

                            <div class="shortKnowledge pd25">
                                <h5>短板知识点</h5>
                                <div id="shortboard">
                                    <?php echo $this->render("short_board",['monthShortBoard'=>$monthShortBoard]);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <br>
</div>


<?php
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

$this->title = '学校-统计-短板池';

$this->blocks['requireModule']='app/classes/class_short_pool';

?>

<div class="main col1200 clearfix class_short_pool" id="requireModule" rel="app/classes/class_short_pool">
    <div class="aside col260 no_bg  alpha">
        <div class="asideItem">
            <div class="sel_classes">
                <div class="pd15">
                    <h5>短板池</h5>
                    <?php echo $this->render("@app/modules/classstatistics/views/default/_statistics_left_list",['classId'=>$classId])?>
                </div>
            </div>
        </div>
    </div>
    <div class="container omega right pd15">班级短板池</div>
    <div class="container gnn_main">
        <div class="item sel_test_bar">
            <div id="time_tab" class="sUI_tab">
                <ul class="tabList clearfix" style="background: #fff">
                    <li><a href="<?php echo Url::to(["/classstatistics/classshortboard/index",'classId'=>$classId]);?>">月短板</a></li>
                    <li><a href="<?php echo Url::to(["/classstatistics/classshortboard/week-short",'classId'=>$classId]);?>" class="ac">周短板</a></li>
                    <li><a href="<?php echo Url::to(["/classstatistics/classshortboard/day-short",'classId'=>$classId]);?>">日短板</a></li>
                </ul>
                <div class="tabCont">

                    <div class="tabItem selector clearfix">
                        <div class="gnn_tabCon">
                            <label>学科：</label>
                            <select id="subject_select1" classId="<?= $classId?>">
                                <?php foreach($subjectNumber as $v):
                                    foreach($v as $key=>$val):?>
                                        <option subjectId="<?php echo $key?>"><?php echo $val;?></option>
                                    <?php endforeach;endforeach;?>
                            </select>

                            <label>星期：</label>
                            <input readonly="readonly" class="text1" placeholder="点击选择周" value="<?php echo $defaultTime?>" start="<?php echo $weekstart;?>" end="<?php echo $weekend;?>">
                            <a href="javascript:;" class="search1">查询</a>

                            <div class="calendar-wrapper  pop" id="week">
                                <div id="calendar-weekly" class="calendar-weekly"></div>
                            </div>

                            <div class="shortKnowledge pd25">
                                <h5>短板知识点</h5>
                                <div id="shortboard">
                                    <?php echo $this->render("short_board",['monthShortBoard'=>$monthShortBoard]);?>
                                </div>

                                <h5>短板错题<span>请点击左侧知识点查看</span></h5>
                            </div>

                            <div class="testPaper">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

</div>

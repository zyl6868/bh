<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 2015/6/16
 * Time: 14:07
 */
use frontend\components\helper\NumberHelper;

/* @var $this yii\web\View */  $this->title="试卷预览";
?>
<div class="main_cont  make_testpaper">
<div class="title">
    <h4>组卷</h4>
</div>
<form class="form_id">
<div class="form_list">
<div class="row makePaper">
<div class="testPaperDemo make_testpaper_View clearfix">
<div class="testPaperHead">
    <div id="line" class="paper_bindLine"><span class="hide">装订线</span></div>
    <div id="secret_sign" class="paper_top">
        <p>绝密★启用前</p>
    </div>
    <div id="main_title" class="paper_title1 setup">
        <p><?=$result->pageMain->main_title->content?></p>
    </div>
    <div id="sub_title" class="paper_title12 setup">
        <p><?=$result->pageMain->sub_title->content?></p>
    </div>
    <div id="info" class="paper_data setup">
        <p>考试时间120分</p>
    </div>
    <div id="student_input" class="paper_name  setup">
        <p>学校：_________姓名：________班级：________考号：_____</p>
    </div>
    <?php $size=count($result->pageMain->win_paper_typeone->questionTypes)+count($result->pageMain->win_paper_typetwo->questionTypes)?>
    <div class="part7">
        <table class="topTotalTable">
            <thead>
            <tr>
                <th>题号</th>
                <?php for($i=1;$i<=$size;$i++){?>
                    <th><?=NumberHelper::number2Chinese($i)?></th>
                <?php }?>
                <th>总分</th>
            </tr>
            <tr>
                <td>得分</td>
            <?php for($i=0;$i<=$size;$i++){?>
                <td></td>
            <?php }?>

            </tr>
            </thead>
        </table>
    </div>
    <div id="pay_attention" class="paper_attention setup">
        <h6>注意事项：</h6>
        <p> 1.答题前填写好自己的姓名、班级、考号等信息<br>
            2.请将答案正确填写在答题卡上<br>
       </p>
    </div>
</div>
<div class="testPaperBody">
<div id="16251354" class="paperPart" >
    <div class="testPaperTitle setup">
        <p>分卷I</p>
    </div>
    <div class="testPaperCom setup">
        <h6>说明:</h6>
        <p>分卷I 注释</p>
    </div>
    <?php
    $lev=0;
    foreach ($result->pageMain->win_paper_typeone->questionTypes as $key => $value) {
        $lev++;
        ?>
    <div id="66820176" class="subPart setup">
        <table>
            <thead>
            <tr>
                <th>评卷人</th>
                <th>得分</th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </thead>
        </table>
        <h6><i><?=NumberHelper::number2Chinese($lev)?>.</i><em><?=$value->title?></em></h6>
        <p>(<?=$value->content?>)</p>
        <div class="testPaperView pr">
            <div class="paperArea">
                <?php foreach($value->questions as $item) {
                    echo $this->render('//publicView/paper/_recombinationItemPreview', array('item' => $item));
                }    ?>

            </div>
        </div>
    </div>
    <?php   }?>
</div>
<div id="16251355" class="paperPart">
    <div class="testPaperTitle setup">
        <p>分卷II</p>
    </div>
    <div class="testPaperCom setup">
        <h6>说明:</h6>
        <p>分卷II 注释</p>
    </div>
    <?php foreach($result->pageMain->win_paper_typetwo->questionTypes as $v){
       $lev++;
        ?>
    <div id="66820276" class="subPart setup">
        <table>
            <thead>
            <tr>
                <th>评卷人</th>
                <th>得分</th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </thead>
        </table>
        <h6><i><?=NumberHelper::number2Chinese($lev)?>.</i><em><?=$v->title?></em></h6>
        <p>(<?=$value->content?>)</p>
        <div class="testPaperView pr">
            <div class="paperArea">
                <?php foreach ($v->questions as $key => $item) {
                    echo $this->render('//publicView/paper/_recombinationItemPreview', array('item' => $item));
                 }?>

            </div>
        </div>
    </div>
           <?php  }?>
</div>
</div>
</div>
<hr>
</div>
</div>
<div class="submitBtnBar tc">
    <a  class="btn bg_blue btn40 w120" href="<?=url('teacher/makepaper/print-word',array('id'=>$result->paperId))?>">下载</a>
</div>
</form>
</div>
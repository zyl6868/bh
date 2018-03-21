<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title="教师-组卷-设定分值";

$backend_asset = BH_CDN_RES.'/pub';

$this->registerJsFile($backend_asset . '/js/ztree/jquery.ztree.all-3.5.min.js'.RESOURCES_VER);
$this->registerCssFile($backend_asset . '/js/ztree/zTreeStyle/zTreeStyle.css'.RESOURCES_VER);
?>

<script>
    $(function(){

        function mergeScore(){//计算试卷最终总成绩
            var totalScore=0;
            var testpaper_totalScore=$('.testpaper_totalScore');
            $('.itemScore').each(function(index, element) {
                var val=parseInt($(this).text());
                totalScore+=val;
            });
            testpaper_totalScore.text(totalScore);
        }
        function set_itemScore(pa,btn){//点击设置分数
            var itemScore=pa.next('em').children('b');//显示单个题型总分
            var item_totalScore=0;//单个总分
            setScore=btn.prev('.text').val();//设定的分数
            if(isNaN(setScore) || setScore=="" ){
                popBox.errorBox('请填写数字!!');
                btn.prev('.text').val('').focus();
                return false;
            }
            var sel_chkbox=pa.find('dd input:checkbox[checked="checked"]');
            sel_chkbox.each(function() {
                setScore=parseInt(setScore);
                $(this).next('.text').val(setScore);
            });

            pa.find('dd input:text').each(function() {
                var inputVal=parseInt($(this).val());
                if(isNaN(inputVal)) inputVal=0;
                item_totalScore+=inputVal;
            });
            btn.prev('.text').val("");
            itemScore.text(item_totalScore);
        }
        function itemScore(pa){//计算"每个"题型的总分数
            var totalScore=pa.next('em').children('b');
            var inputs=pa.find('dd .text');
            var itemScore=0;
            inputs.each(function(index, element) {
                var val=parseInt($(this).val());
                if(isNaN(val)) val=0;
                itemScore+=val;
            });
            totalScore.text(itemScore);
        }
        //试卷预览后显示分值
        $('.score').each(function(index, element) {
            itemScore($(this));
        });
        mergeScore();

        $('.score dt .set_btn').click(function(){
            var pa=$(this).parents('.score');
            set_itemScore(pa,$(this));
            mergeScore();
        });

        $('#setGlobalSeoreBtn').click(function(){
            set_itemScore($('.scoreList'),$(this));

            $('.score').each(function(index, element) {
                itemScore($(this));
            });
            mergeScore();
        });

        $('.score dd .text').change(function(){
            var pa=$(this).parents('.score');
            itemScore(pa);
            mergeScore();
        });

        $(".viewBtn").click(function () {
            var objArray = [];
            $(".getScore").each(function (index, el) {
                var obj = {"id": $(el).attr("id"), "score": $(el).val()};
                objArray.push(obj);
            });

            $.ajax({
                type: "POST",
                async: false,
                url: "<?php echo url('teacher/makepaper/set-score')?>",
                data: {
                    "paperId":<?php echo app()->request->getParam("paperId")?>,
                    "scoreJson": JSON.stringify(objArray)
                },
                dataType: "json",
                success: function (result) {
                    if (result.code) {
                        return true;
                    } else {
                        popBox.errorBox(result.message);
                        return false;
                    }
                }
            });
            return true;
        });

        //全选
        $('.score').each(function(index, element) {
            var itemCheckAllBtn=$(this).find('.itemCheckAll');
            var checkboxs=$(this).find('dd input:checkbox');
            itemCheckAllBtn.checkAll(checkboxs);
        });

        //验证是否有未填分数的表单
        function chkInput(){
            var chk=0;
            $('.score dd input:text').each(function() {
                if($(this).val()=="") {
                    $(this).focus();
                    chk++;
                }
            });
            if(chk>0) return false;
            else return true;
        }
        $('.saveSetBtn').click(function(){

            if(chkInput()==false) {
                popBox.errorBox('分数不能为空！');
                return false;
            }
            return true;
        });

    })


</script>

<div class="grid_19 main_r">
    <div class="main_cont make_setScore">
        <div class=" title">
            <h4>设定分值
            </h4>
        </div>
        <ul class="stepList clearfix">
            <li class="step_finish "><span>试卷标题</span><i></i></li>
            <li class="step_finish "><span>试卷结构</span><i></i></li>
            <li class="step_finish step_ac_before"><span>筛选题目</span><i></i></li>
            <li class="step_ac step_end"><span>设定分值</span><i></i></li>
        </ul>



        <?php echo Html::beginForm(); ?>
        <ul class="form_list scoreList">
            <?php foreach ($selectQuestions as $selQuestion) { ?>
                <li class="row" id="<?php echo $selQuestion->typeId ?>">
                    <div class="formL">
                        <label><?php echo $selQuestion->typeName ?>：</label>
                    </div>
                    <div class="formR">
                        <dl class="score clearfix">
                            <dt>每题
                                <input type="text" class="text w30">
                                分
                                <button type="button" class="bg_red_d set_btn">确定</button>&nbsp;&nbsp;&nbsp;<input class="itemCheckAll" type="checkbox" /> 全选
                            </dt>
                            <?php foreach ($selQuestion->questions as $qu) { ?>
                                <dd>
                                    <input type="checkbox">
                                    <?php echo $qu->id ?>_<?php echo $qu->name ?>

                                    <input type="text" name="score[<?php echo $qu->id ?>]" class="text w30  getScore"
                                           id="<?php echo $qu->id ?>"
                                           value="<?php echo $qu->score ?>">
                                </dd>
                            <?php } ?>
                        </dl>
                        <em class="scoreBar"><b class="itemScore">0</b>分</em>
                    </div>

                </li>
            <?php } ?>

            <li class="row">
                <div class="formL"></div>
                <div class="formR">
                    <label>设置选定题目的分数为：</label>
                    <input type="text" class="text w30">
                    <button id="setGlobalSeoreBtn" class="mini_btn make_btn" type="button">确定</button>
                    &nbsp;&nbsp;&nbsp;<em class="scoreBar">总分:<b class="testpaper_totalScore">0</b></em>
                </div>
            </li>
        </ul>
        <br>

        <p class="tc bottomBtnBar">
            <button type="button" onclick="history.go(-1);" class="btn40 bg_blue preStepBtn">上一步</button>
            <button type="submit" class="btn40 bg_blue saveSetBtn">保存设置</button>
            <a href="<?php echo url('teacher/makepaper/paper-review', array('paperId' => app()->request->getParam('paperId'))) ?>"
               target="_blank" class="a_button w120 btn40 bg_blue viewBtn">试卷预览</a>
        </p>
        <?php echo Html::endForm(); ?>
    </div>
</div>
<?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
    <script type="text/javascript">
        popBox.successBox(' <?php  echo    Yii::$app->getSession()->getFlash('success'); ?>');
    </script>
<?php } ?>

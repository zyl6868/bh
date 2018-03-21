<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/18
 * Time: 12:00
 */
use common\components\WebDataCache;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<script type="text/javascript">
    //$(function(){
        require(['popBox','jqueryUI','jquery_sanhai'],function(popBox) {
            $('#cancelHomework').click(function(){
                $( "#popBox1" ).dialog( "close" );
            });

            $(".myclass_table dt span").click(function(){
              var checkbox = $(this).siblings("input");
              if(checkbox.is(":checked")){
                checkbox.prop("checked",false);
              }else{
                checkbox.prop("checked",true);
              }
              pitchOn(checkbox);
            });

            $(".myclass_table dt input").click(function(){
              var checkbox = $(this);
              pitchOn(checkbox);
            });

            function pitchOn(checkbox){
              var dt = checkbox.parent('dt');
              if(checkbox.is(":checked")){
                var classId = dt.attr('data-id');
                dt.siblings("input").val(classId);
              }else{
                dt.siblings("input").val('');
              }
            }


            $('#isShare').attr('checked','checked');
            $('#isShare').click(function(){
                _this = $(this);
                var isShare = _this.val();
                if(isShare==1){
                    _this.attr('checked',false);
                    _this.val('0');
                }else if(isShare ==0){
                    _this.attr('checked','checked');
                    _this.val('1');
                }
            });

            $("#saveHomework").click(function(){
                var checkbox = $(".unmyclass_table dt input");
                var checkedbox = $(".unmyclass_table dt input:checked");
                if($(".unmyclass_table dt input[type='checkbox']").size() == 0){
                    popBox.errorBox('已经布置过作业！');
                }else if(!checkbox.is(":checked")){
                    popBox.errorBox('请选择班级！');
                }else{
                    var code = true;
                    checkedbox.parent('dt').siblings('dd').each(function(){
                        var _this = $(this);
                        var deadlineTime = _this.children('input').val();
                        if(deadlineTime == ''){
                            code = false;
                            popBox.errorBox('请给选择的班级填写时间！');
                        }
                    });

                    if(code){
                        $form_id = $('#form_id');
                        $.post($form_id.attr('action'), $form_id.serialize(),function(data){
                            if(data.success){
                                popBox.successBox(data.message);
                                location.reload();
                            }else{
                                popBox.alertBox(data.message);
                            }
                        });
                    }else{
                        return false;
                    }
                }

            });
        })


  //  })
</script>
<?php

$form = ActiveForm::begin( array(
    'id' => 'form_id',
    'action' =>'/teacher/managetask/send-homework'
)) ?>
<div class="popCont">
    <div class="">
            <?php if(!empty($homeworkRelList)){?>
            <div class="form_list form_work_pre form_workcon">
                <div class="row clearfix">
                    <div class="formL"> 已布置的班级: </div>
                    <div class="formR formR_text">
                        <?php foreach($homeworkRelList as $assignClass){?>
                            <dl class="myclass_table myclass_tablebox">
                                <dt class="curnone">
                                  <h5 class="ification" title="<?=WebDataCache::getClassesNameByClassId($assignClass->classID)?>"><?=WebDataCache::getClassesNameByClassId($assignClass->classID)?></h5>
                                </dt>
                                <dd>
                                    <span>交作业截止时间:</span>
                                    <label class="date_bj"><?= date("Y-m-d",$assignClass->deadlineTime/1000)?></label>
                                </dd>
                            </dl>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php if(!empty($unassignClass)){?>
            <div class="form_list form_work_pre">
                <div class="row clearfix">
                    <div class="formL"> 未布置的班级: </div>
                    <div class="formR formR_text">
                        <?php
                        foreach($unassignClass as $key=>$val){?>
                        <dl class="myclass_table unmyclass_table">
                            <dt data-id="<?= $val?>">
                                <input type="checkbox"/>
                                <span title="<?= Html::encode(WebDataCache::getClassesNameByClassId($val))?>"><?= Html::encode(WebDataCache::getClassesNameByClassId($val))?></span>
                            </dt>
                            <input type="hidden" class="classId" name='TeacherClassForm[<?=$key?>][classID]' value="" />
                            <dd>
                                <span>交作业截止时间</span>
                                <input type="text" class="edit_box" id="listenTime" name='TeacherClassForm[<?= $key?>][deadlineTime]'
                                       onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'<?php echo date('Y-m-d h:i:s',time())?>',maxDate:'2099'})"
                                       data-validation-engine="validate[required] validate[minSize[2]] validate[maxSize[20]]"
                                       data-prompt-position="inline" data-prompt-target="listenTimeError" readonly="readonly">
                            </dd>
                        </dl>
                        <?php }?>
                        <input type="hidden" name="homeworkId" value="<?= $homeworkTeaOne->id?>" />
                    </div>
                </div>
            </div>
            <?php }?>
    </div>
</div>
<div class="popBtnArea">
    <div class="share_work">
        <?php if(isset($getType) && $getType==1){?>
        <input type="checkbox" name="isShare" value="1" id="isShare">共享到平台作业库
        <?php }?>
    </div>
    <div class="btn_work">
        <button type="button" class="okBtn" id="saveHomework">确定</button>
        <button type="button" class="cancelBtn" id="cancelHomework">取消</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
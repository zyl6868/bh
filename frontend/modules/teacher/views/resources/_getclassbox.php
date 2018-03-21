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
                            <dt class="bg_f" data-id="<?= $val?>">
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
<div class="popBtnArea" style="height: 45px">
    <div class="share_work tl">
        <?php if(isset($getType) && $getType==1){?>
        <input type="checkbox" name="isShare" value="1" id="isShare">共享到平台作业库&nbsp;&nbsp;<br>
        <input type="checkbox" name="isSignature" value="1" id="isSignature" checked>本次作业需要家长签字
        <?php }?>
    </div>
    <div class="btn_work">
        <button type="button" class="okBtn" id="saveHomework" hmwid = "<?php echo $hmwid; ?>">确定</button>
        <button type="button" class="cancelBtn" id="cancelHomework">取消</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
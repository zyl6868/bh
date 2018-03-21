<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/3/4
 * Time: 10:15
 */
use schoolmanage\components\helper\GradeHelper;
use yii\helpers\Url;

?>
<?php $form =\yii\widgets\ActiveForm::begin( array(
    'enableClientScript' => false,
    'id' => "exam_form",
    'method'=>'post'
)) ?>
    <div class="popCont">
        <div class="sUI_formList">
            <input  type="hidden" value="<?=$schoolID?>" class="schoolID"/>
            <input  type="hidden" value="<?=$department?>" class="department"/>
            <div class="row">
                <div class="form_l"><b>*</b>年级:</div>
                <div class="form_r exam_grade">
                    <?php foreach($gradeData as $k=>$v){
                        ?>
                        <label>
                            <input type="checkbox" class="checkbox validate[minCheckbox[1]]" name="grade[]" value="<?=$v->gradeId?>"  data-errormessage-range-underflow="请选择年级"><?php echo GradeHelper::getComingYearByGrade($v->gradeId,$schoolData->lengthOfSchooling,$schoolID,$department).'级（现'.$v->gradeName.'）'?></label>
                        <?php if(($k+1)%3==0){?>
                            <br>
                        <?php } }?>
                </div>
            </div>
            <div class="row">
                <div class="form_l"><b>*</b>学年:</div>
                <div class="form_r exam_grade schoolYear">
                    <label>
                        <?php $currentYear=GradeHelper::getCurrentSchoolYear($schoolID,$department);?>
                        <input type="radio" class="radio  validate[required]" name="schoolYear" value="<?=($currentYear-1).'-'.$currentYear?>" data-errormessage-value-missing="请选择学年"><?=($currentYear-1).'-'.$currentYear?></label>
                </div>
            </div>
            <div class="row">
                <div class="form_l"><b>*</b>学期:</div>
                <div class="form_r exam_grade">
                    <label>
                        <input type="radio" class="radio validate[required]" name="semester" value="21301" data-errormessage-value-missing="请选择学期">上学期</label>
                    <label>
                        <input type="radio" class="radio validate[required]" name="semester" value="21302" data-errormessage-value-missing="请选择学期">下学期</label>
                </div>
            </div>
            <div class="row">
                <div class="form_l"><b>*</b>月份:</div>
                <div class="form_r">
                    <?php for($i=1;$i<13;$i++){?>
                        <input type="checkbox" class="checkbox validate[minCheckbox[1]]" name="month[]" value="<?=$i?>" data-errormessage-range-underflow="请选择月份">
                        <label><?=$i?>月</label>
                    <?php }?>
                </div>
            </div>
            <div class="row sch_exam_con">
                <div class="form_l"><b>*</b>文/理:</div>
                <div class="form_r exam_grade">
                    <label>
                        <input type="radio" class="radio validate[required]" value="1" name="wenli" data-errormessage-value-missing="请选择是否区分文理">不分文理</label>&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" class="radio validate[required]" value="2" name="wenli" data-errormessage-value-missing="请选择是否区分文理">区分文理</label>
                </div>
            </div>
            <div class="exam_list">
                <button id="exam_name"  class="bg_blue exam_name" type="button">预览考试名称</button>
                <ul class="subject_list">
                </ul>
            </div>
            <p class="backstage"><i></i>学校后台管理员只能创建考试类型为“月考”的考试，其余类型考试由平台统一创建</p>
        </div>
    </div>
    <div class="popBtnArea">
        <button type="button" class="okBtn create">确定</button>
        <button type="button" class="cancelBtn">取消</button>
    </div>
<?php \yii\widgets\ActiveForm::end(); ?>
<script>

    $('.cancelBtn').click(function(){
        $('.popBox').dialog("close");
    })
    schoolID=$('.schoolID').val();
    //    改变年级对应学年改变
    $('[name="grade[]"]').click(function(){
        gradeArray=[];
        $('[name="grade[]"]').each(function(index,el){
            if($(el).is(':checked')==true){
                gradeID=$(el).attr('value');
                gradeArray.push(gradeID);
            }
        });
      var  department =$('.department').val();
        if(gradeArray.length>0){
            url='<?=Url::to(["default/get-school-year-list"])?>';
            $.post(url,{schoolID:schoolID,gradeArray:gradeArray,department:department},function(result){
                $('.schoolYear').html(result);
            })
        }

    })
    $('#exam_name').click(function(){

        if ($('#exam_form').validationEngine('validate')) {


            gradeArray = [];
            $('[name="grade[]"]').each(function (index, el) {
                if ($(el).is(':checked') == true) {
                    gradeID = $(el).attr('value');
                    gradeArray.push(gradeID);
                }
            });
            var schoolYear = $('[name="schoolYear"]:checked').attr('value');
            var semester = $('[name="semester"]:checked').attr('value');
            var wenli = $('[name="wenli"]:checked').attr('value');
            var department=$('.department').val();
            var monthArray = [];
            $('[name="month[]"]').each(function (index, el) {
                if ($(el).is(':checked') == true) {
                    month = $(el).attr('value');
                    monthArray.push(month);
                }
            });
            url = '<?=Url::to(["produce-exam-name"])?>';
            $.post(url, {
                schoolID:schoolID,
                gradeArray: gradeArray,
                schoolYear: schoolYear,
                semester: semester,
                wenli: wenli,
                monthArray: monthArray,
                department:department
            }, function (result) {
                $('.subject_list').html(result);
            })
        }

    })
    $('.create').click(function(){

        if ($('#exam_form').validationEngine('validate')) {


            gradeArray = [];
            $('[name="grade[]"]').each(function (index, el) {
                if ($(el).is(':checked') == true) {
                    gradeID = $(el).attr('value');
                    gradeArray.push(gradeID);
                }
            });
            var schoolYear = $('[name="schoolYear"]:checked').attr('value');
            var semester = $('[name="semester"]:checked').attr('value');
            var wenli = $('[name="wenli"]:checked').attr('value');
            var department=$('.department').val();
            var monthArray = [];
            $('[name="month[]"]').each(function (index, el) {
                if ($(el).is(':checked') == true) {
                    month = $(el).attr('value');
                    monthArray.push(month);
                }
            });
            url = '<?=Url::to(["create-exam"])?>';
            $.post(url, {
                schoolID:schoolID,
                gradeArray: gradeArray,
                schoolYear: schoolYear,
                semester: semester,
                wenli: wenli,
                monthArray: monthArray,
                department:department
            }, function (result) {
                if(result.success){
                    location.reload();
                }
            })
        }

    })
</script>
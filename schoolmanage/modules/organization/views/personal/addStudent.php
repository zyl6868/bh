<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/15
 * Time: 14:58
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->title = '添加学生';
$this->registerCssFile(BH_CDN_RES . '/static/css/school_add_stu.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/school_testMag.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/require.js'. RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/app/school/app_add_stu.js'.RESOURCES_VER , ['position' => View::POS_HEAD]);
?>
<div class="main col1200 clearfix sch_mag_person sch_mag_teacher" id="requireModule">
    <input type="hidden" id="classID" value="<?php echo $classID ?>"/>

    <div class="mag_title">
        <a href="<?= Url::to(['/organization/personal/manage-list', 'classId' => $classID]) ?>"
           class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
        <h4>单个添加学生</h4>
    </div>
    <div id="form_add_stu" class="container">
        <?php $form = ActiveForm::begin(array(
            'enableClientScript' => false,
            'id' => "edit_user_info_form",
            'method' => 'post'
        )) ?>
        <div class="add_stu">
            <label for="stu_ID">
                <div class="lable">学号：</div>
            </label>
            <input id="stu_ID" name="stu_ID" type="text"
                   data-validation-engine="validate[custom[onlyLetterNumber],maxSize[20]]"/><br>

            <div class="lable">
                <label for="stu_name">
                    <i class="req">*</i>姓名：
                </label>
            </div>
            <input id="stu_name" name="stu_name" type="text" class="input_txt  "
                   data-validation-engine="validate[required,minSize[2],maxSize[20]]"
                   data-errormessage-value-missing="用户名不能为空"
            /><br>
            <label for="stu_mol">
                <div class="lable">
                    <i class="req">*</i>手机号：
                </div>
            </label>
            <input id="stu_mol" name="stu_mol" type="text" class="input_txt  "
                   data-validation-engine="validate[required,custom[phoneNumber]]"
                   data-errormessage-value-missing="手机号不能为空"
            /><br>

            <label>
                <div class="lable">性别：</div>
            </label>
            <label for="male"></label>
            <input type="radio" name="sex_again" id="male" value="1"/>男
            <label for="female"></label>
            <input type="radio" name="sex_again" id="female" value="2"/>女
            <div id="verification" class="verification">
                <button class="btn" id="proof" type="button">校验</button>
            </div>
        </div>
        <div class="add_stu_verification">
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?php $form = ActiveForm::begin(array(
        'enableClientScript' => false,
        'id' => "edit_user_info_form_again",
        'method' => 'post'
    )) ?>
    <div id="form_add_stu_1" class="form_add_stu_1">


    </div>
    <?php ActiveForm::end(); ?>
</div>

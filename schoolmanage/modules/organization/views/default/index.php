<?php

use frontend\components\CHtmlExt;
use common\models\dicmodels\ClassListModel;
use yii\base\View;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = "组织管理-班级管理";
$this->registerCssFile(BH_CDN_RES.'/static/css/class_mag.css'.RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/require.js'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/school/app_mag.js'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="main col1200 clearfix sch_mag_person sch_mag_teacher" id="requireModule" rel="app/school/app">
    <div class="aside col260 alpha clearfix">
        <div class="sel_classes">
            <?php echo $this->render('_organization_left');?>

        </div>
    </div>
    <div class="container col910 omega currency_hg">
        <ul class="class_grade" schoolId = <?php echo $schoolId;?> departmentId = "<?php echo $departmentId;?>">
            <?php
            $departmentArray = explode(',', $departmentIds);
            foreach($departmentArray as $v){
                    $departmentName = '';
                    if($v == 20201){
                        $departmentName = '小学';
                    }else if($v == 20202){
                        $departmentName = '初中';
                    }else if($v == 20203){
                        $departmentName = '高中';
                    }
            ?>
            <li class="<?php echo $v == $departmentId ? 'ac' : '' ?>">
                <a href="<?php echo Url::to(['/organization/default/index','departmentId'=>$v]); ?>"><?php echo $departmentName;?></a>
            </li>
            <?php } ?>
        </ul>
        <div class="class_status">
<!--            <button id="update" class="update" data-alert="on"><i class="update"></i>升级</button>-->
            <button id="closure"><i class="closure"></i>创建班级</button>
            <button id="found"><i class="found"></i>封班</button>
        </div>
    </div>
    <div class="aside col260 alpha no_bg clearfix">
        <div class="asideItem">
            <ul class="left_menu">
                <li>
                    <a class="<?php echo $this->context->highLightUrl(['organization/default/index']) ? 'cur' : ''?>" href="<?php echo Url::to("/organization/default/index")?>">班级管理</a>
                </li>
                <li>
                    <a class="<?php echo $this->context->highLightUrl(['organization/school/index']) ? 'cur' : ''?>" href="<?php echo Url::to("/organization/school/index")?>">学校管理</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container col910 omega">
        <div class="pd25 clearfix">
            <div class="right_con">
                <div class="sUI_pannel">
                    <div class="pannel_l">
                        <?php
                        echo CHtmlExt::dropDownListAjax(Html::getAttributeName('gradeId'), "", $gradeDataList, array(
                            'prompt' => '年级',
                            'data-validation-engine' => 'validate[required]',
                            'data-prompt-target' => "grade_prompt",
                            'data-prompt-position' => "inline",
                            'id' => 'gradeId',
                        )) ?>

                        <select id="classStatus" name="classStatus" data-validation-engine="validate[required]" data-prompt-target="enrollment_prompt" data-prompt-position="inline">
                            <option value="0">状态</option>
                            <option value="1" id="status_selected">活动</option>
                            <option value="2">已封班</option>
                            <option value="3">已毕业</option>
                        </select>
                    </div>
                </div>
                <div class="table_con">
                    <?php echo $this->render("_class_list", ["schoolId" => $schoolId,'departmentId'=>$departmentId,'classCount'=>$classCount,'classListData'=>$classListData]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--弹框-->
<!--弹框重置密码-->
<div id="reset_passwordBox" class="popBox reset_passwordBox hide" title="重置密码">

</div>

<!--教师个人信息-->
<div id="infoBox" class="popBox infoBox hide" title="教师个人信息">

</div>

<!--编辑教师个人信息-->
<div id="editInfoBox" class="popBox editInfoBox hide" title="编辑教师个人信息">

</div>
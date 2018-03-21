<?php

use frontend\components\helper\ViewHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = "组织管理-学校管理";
$this->registerCssFile(BH_CDN_RES.'/static/css/sch_introduction.css'.RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES.'/static/css/class_mag.css'.RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/require.js'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/jquery.js'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->blocks['requireModule'] = 'static/sch_mag/sch_introduction';
?>

<div class="main col1200 clearfix sch_mag_person sch_mag_teacher" id="requireModule" rel="app/school/app">
    <div class="aside col260 alpha clearfix">
        <div class="sel_classes">
            <?php echo $this->render('_organization_left');?>

        </div>
    </div>
    <div class="container col910 omega currency_hg">
        <p class="class_grade">学校介绍</p>
        <a href="<?php echo \yii\helpers\Url::to(['/organization/school/modify-school-summary','seSchoolInfoModel'=>$seSchoolInfoModel])?>" class="class_status"><i></i>编辑</a>
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
        <?php if(empty($seSchoolInfoModel->logoUrl) && empty($brief)){
            ViewHelper::emptyView('暂无数据');
        } else {?>
        <div class="pd25 clearfix">
            <?php if(!empty($seSchoolInfoModel->logoUrl)){?>
            <img class="sch_logo" src="<?php echo $seSchoolInfoModel->logoUrl ?>" alt="">
            <?php };?>
            <div class="content" id="contentImg">
                <?php echo $brief; ?>
            </div>
        </div>
        <?php }?>
    </div>
</div>


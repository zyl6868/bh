<?php
/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main.php');
$this->registerCssFile(BH_CDN_RES.'/pub/css/school.css'.RESOURCES_VER);

$schoolModel = $this->params['schoolModel'];
$schoolId = $schoolModel->schoolID;
$this->blocks['bodyclass'] = "school";
?>
<?php $this->beginBlock('head_html_ext'); ?>
<div class="bodyBg">
    <img src="<?php echo BH_CDN_RES.'/pub' ?>/images/schoolBG.jpg">
</div>
<div class="opacity_mask"></div>
<?php $this->endBlock('head_html_ext') ?>
<div class="cont24 homepage  school_public">
    <h2><?= $schoolModel->schoolName ?></h2>

    <div class="grid_24 main_nav">
        <div class="main_nav_BG"></div>
        <ul class="clearfix">
            <li><a href="<?= url('school/index', ['schoolId' => $schoolId]) ?>">首页</a></li>
            <!--            <li><a href="#">学校公示</a></li>-->
            <li><a class="<?php echo $this->context->highLightUrl('school/teacher') ? 'ac' : '' ?>"
                   href="<?php echo url('school/teacher', array('schoolId' => $schoolId)) ?>">教师</a></li>
            <!--            <li><a class="-->
            <?php //echo $this->context->highLightUrl('school/teachinglist') ? 'ac' : '' ?><!--"-->
            <!--                   href="-->
            <?php //echo url('school/teachinglist', array('schoolId' => $schoolId)) ?><!--">教研组</a></li>-->
            <li>
                <a class="<?php echo $this->context->highLightUrl('school/classes') ? 'ac' : '' ?>"
                   href="<?php echo url('school/classes', array('schoolId' => $schoolId)) ?>">班级</a></li>
            <li>
                <a class="<?php echo $this->context->highLightUrl('school/answer-questions') ? 'ac' : '' ?>"
                   href="<?php echo url('school/answer-questions', array('schoolId' => $schoolId)) ?>">答疑</a></li>
            <li>
                <a class="<?php echo $this->context->highLightUrl(['school/publicity', 'school/new-publicity', 'school/publicity-details', 'school/update-publicity']) ? 'ac' : '' ?>"
                   href="<?php echo url('school/publicity', array('schoolId' => $schoolId)) ?>">公示</a></li>

            <!--            <li >-->
            <!--                <a class="-->
            <?php //echo $this->context->highLightUrl(['school/addbrief', 'school/briefList', 'school/briefView', 'school/briefUpdate']) ? 'ac' : '' ?><!--" href="-->
            <?php //echo url('school/briefList', array('schoolId' => $schoolId)) ?><!--">招生简章</a>-->
            <!--            </li>-->
            <?php $departmentArray = in_array("20203", explode(",", $schoolModel->department));
            //高中有分数线和招生简章
            if ($departmentArray) {
                ?>
                <li><a class="<?php echo $this->context->highLightUrl('school/fraction') ? 'ac' : '' ?>"
                       href="<?php echo url('school/fraction', array('schoolId' => $schoolId)) ?>">录取分数线</a>
                </li>
            <?php
            }
            ?>

        </ul>

    </div>
    <div class="grid_24 main">
        <?php echo $content ?>
    </div>
</div>
<?php $this->endContent(); ?>

<?php
/**
 * Created by yangjie
 * User: Administrator
 * Date: 14-9-19
 * Time: 上午9:56
 */
use common\models\pos\SeClassMembers;
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main_v2.php');
$this->blocks['bodyclass'] = "classes classes_theme1";
$this->registerCssFile(BH_CDN_RES.'/static/css/classes.css'.RESOURCES_VER);

/** @var \common\models\pos\SeClass $classModel */
$classModel = $this->params['classModel'];
$classId = $classModel->classID;

if ($this->beginCache('classHeader'.$classId, ['duration' => 600])) {

    $teacherCount = $classModel->getClassTeacherCount();
    $studentCount = $classModel->getClassStudentCount();

    ?>
    <div class="class_home_info">
        <div class="infoBar pr col1200">
            <dl class="classes_head clearfix">
                <dt class="fl"><img src="<?=BH_CDN_RES;?>/pub/images/class.png" alt=""></dt>
                <dd class="">
                    <div class="attention">
                        <h2><?= $classModel->className ?></h2>
                    </div>
                    <div class="tab_ls">
                        <p>教师（<?php echo $teacherCount;?>）人</p>
                        <p>学生（<?php echo $studentCount;?>）人</p>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
    <?php
    $this->endCache();
}
?>
<div class="col1200">
    <div class="class_nav">
        <div class="class_nav_opacity"></div>
        <p class="class_top"></p>
        <ul class="class_nav_list clearfix">
            <li class="<?= $this->context->highLightUrl('class/index') ? 'ac' : '' ?>">
                <a href="<?= url('class/index', ['classId' => $classId]) ?>">班级首页</a>
            </li>
            <?php if(loginUser()->isTeacher()){?>
                <li class="<?= $this->context->highLightUrl(['class/homework','class/work-detail','workstatistical/work-statistical-student','workstatistical/work-statistical-topic','workstatistical/work-statistical-all','class/correct-org-hom','class/correct-pic-hom']) ? 'ac' : '' ?>">
                    <a href="<?= url('class/homework', ['classId' => $classId]) ?>">班级作业</a>
                </li>
            <?php }elseif(loginUser()->isStudent()){ ?>
                <li class="<?= $this->context->highLightUrl(['class/student-homework','classes/managetask/details','class/work-detail']) ? 'ac' : '' ?>">
                    <a href="<?= url('class/student-homework', ['classId' => $classId]) ?>">班级作业</a>
                </li>
            <?php } ?>
            <li class="<?= $this->context->highLightUrl('class/member-manage') ? 'ac' : '' ?>">
                <a href="<?= url('class/member-manage', ['classId' => $classId]) ?>">班级成员</a>
            </li>
            <li class="<?= $this->context->highLightUrl(['class/class-file','class/class-file-details']) ? 'ac' : '' ?>">
                <a href="<?= url('class/class-file', ['classId' => $classId]) ?>">班级文件</a>
            </li>
            <li class="<?= $this->context->highLightUrl('class/answer-questions') ? 'ac' : '' ?>"><a
                    href="<?= Url::to(['//class/answer-questions','classId' => $classId]) ?>">班内答疑</a>
            </li>
            <li class="<?= $this->context->highLightUrl(['class/memorabilia','class/add-memorabilia','class/memorabilia-album']) ? 'ac' : '' ?>"><a
                    href="<?= url('class/memorabilia', ['classId' => $classId]) ?>">大事记</a>
            </li>
            <?php if (loginUser()->isTeacher()) { ?>
                <li class="<?= $this->context->highLightUrl(['classstatistics/default/index','classstatistics/default/overview','classstatistics/default/classes-contrast',
                    'classstatistics/namelist/index','classstatistics/onlinescore/index','classstatistics/teachercontrast/index',
                    'classstatistics/homeworkexcellentrate/index','classstatistics/homeworkunfinish/index',
                    'classstatistics/classshortboard/index','classstatistics/classshortboard/week-short','classstatistics/classshortboard/day-short']) ? 'ac' : '' ?>"><a
                        href="<?= url('classstatistics/default/index', ['classId' => $classId]) ?>">班级统计</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php echo $content ?>

<?php $this->endContent() ?>

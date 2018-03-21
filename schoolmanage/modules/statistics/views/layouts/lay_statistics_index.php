<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 16:47
 */
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main.php');
$this->blocks['bodyclass'] = "statistic";
$this->registerCssFile(BH_CDN_RES.'/static/css/statistic.css'.RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/echarts.js'.RESOURCES_VER , ['position'=>\yii\web\View::POS_HEAD ]);
?>

<div class="col1200 school_name"><h3><?php echo $this->context->schoolModel->schoolName;?></h3>
</div>
<div class="class_nav col1200">
    <div class="class_nav_opacity"></div>
    <ul class="class_nav_list clearfix">
        <li class="<?= $this->context->highLightUrl(['exam/default/index']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/exam/default/index")?>">考务管理</a>
        </li>
        <li class="<?php echo $this->context->highLightUrl(['personnel/teacher/index', 'personnel/student/index']) ? 'ac' : ''?>">
            <a href="<?php echo Url::to("/personnel/teacher/index")?>">人员管理</a>
        </li>
        <!--        <li><a href="javascript:;">组织管理</a></li>-->
        <!--        <li><a href="javascript:;">公示管理</a></li>-->
        <li class="<?= $this->context->highLightUrl(['statistics/default/index','statistics/default/overview','statistics/default/classes-contrast',
            'statistics/teachercontrast/index','statistics/onlinescore/index','statistics/namelist/index']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/statistics/default/index")?>">成绩统计</a>
        </li>
        <li class="<?= $this->context->highLightUrl(['shortboard/default/index','shortboard/default/week-short']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/shortboard/default/index")?>">短板统计</a>
        </li>
        <li class="<?= $this->context->highLightUrl(['statistics/activate/index','statistics/activate/student','statistics/homeworkuse/index']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/statistics/activate/index")?>">使用统计</a>
        </li>
        <li class="<?= $this->context->highLightUrl(['organization/default/index']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/organization/default/index")?>">组织管理</a>
        </li>
    </ul>
</div>
<?php echo $content ?>

<?php $this->endContent() ?>

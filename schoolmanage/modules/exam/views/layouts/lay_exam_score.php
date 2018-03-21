<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-19
 * Time: 上午9:56
 */
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main.php');
$this->blocks['bodyclass'] = "student";
$this->registerCssFile(BH_CDN_RES.'/static/css/sch_mag.css'.RESOURCES_VER);

?>
<div class="class_nav col1200">
    <div class="class_nav_opacity"></div>
    <ul class="class_nav_list clearfix">
        <li class="<?= $this->context->highLightUrl(['exam/default/index','exam/default/set-score','exam/scoreinput/index','exam/scoreinput/check-class','exam/scoreinput/manual-input',
            'exam/scoreinput/auto-input']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/exam/default/index")?>">考务管理</a>
        </li>
        <li class="<?php echo $this->context->highLightUrl(['personnel/teacher/index', 'personnel/student/index']) ? 'ac' : ''?>">
            <a href="<?php echo Url::to("/personnel/teacher/index")?>">人员管理</a>
        </li>
        <li class="<?= $this->context->highLightUrl('statistics/default/index') ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/statistics/default/index")?>">成绩统计</a>
        </li>
        <li class="<?= $this->context->highLightUrl(['shortboard/default/index','shortboard/default/week-short']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/shortboard/default/index")?>">短板统计</a>
        </li>
        <li class="<?= $this->context->highLightUrl('statistics/activate/index') ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/statistics/activate/index")?>">使用统计</a>
        </li>
        <li class="<?= $this->context->highLightUrl(['organization/default/index']) ? 'ac' : '' ?>">
            <a href="<?php echo Url::to("/organization/default/index")?>">组织管理</a>
        </li>
    </ul>
</div>
<?php echo $content ?>

<?php $this->endContent() ?>

<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/10/23
 * Time: 11:54
 */

use common\clients\AdManageService;
use common\models\pos\SeClassMembers;
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main_v2.php');
$this->blocks['bodyclass'] = "classes";

/*新的*/
$this->registerCssFile(BH_CDN_RES.'/static/css/classes.css'.RESOURCES_VER);
$this->blocks['requireModule']='app/classes/classes_index';

/** @var \common\models\pos\SeClass $classModel */
$classModel=   $this->params['classModel'];
$classId = $classModel->classID;

//加载广告
$ad = AdManageService::getOneByCode('class-index');

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
<!-- 广告轮播图-->
<?php
if(count($ad) !== 0){
    foreach($ad as  $adValue){
?>
<div class="col1200">
    <div id="classes_AD_banner" class="container  classes_AD_banner">
        <ul id="classes_AD_banner_list" class="classes_AD_banner_list">
            <li><a target="_blank" href="<?php echo $adValue->href;?>">
                    <img src="<?php echo $adValue->image;?>">
                </a>
            </li>
        </ul>
        <div class="slideBtn"></div>
    </div>
</div>
<?php
        }
    }
?>
<div class="class_nav col1200">
    <div class="class_nav_opacity"></div>
    <p class="class_top"></p>
	<ul class="class_nav_list clearfix">
		<li class="<?= $this->context->highLightUrl('class/index') ? 'ac' : '' ?>">
			<a href="<?= url('class/index', ['classId' => $classId]) ?>">班级首页</a>
		</li>
        <?php if(loginUser()->isTeacher()){?>
            <li class="<?= $this->context->highLightUrl('class/homework') ? 'ac' : '' ?>">
                <a href="<?= url('class/homework', ['classId' => $classId]) ?>">班级作业</a>
            </li>
        <?php }elseif(loginUser()->isStudent()){ ?>
            <li class="<?= $this->context->highLightUrl('class/student-homework') ? 'ac' : '' ?>">
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
				href="<?= Url::to(['class/answer-questions','classId' => $classId]) ?>">班内答疑</a>
		</li>
		<li class="<?= $this->context->highLightUrl(['class/memorabilia']) ? 'ac' : '' ?>"><a
				href="<?= url('class/memorabilia', ['classId' => $classId]) ?>">大事记</a>
		</li>
        <?php if (loginUser()->isTeacher()) { ?>
            <li class="<?= $this->context->highLightUrl(['classstatistics/default/index']) ? 'ac' : '' ?>"><a
                    href="<?= url('classstatistics/default/index', ['classId' => $classId]) ?>">班级统计</a>
            </li>
        <?php } ?>
	</ul>
</div>

	

<div data-main-align class="main clearfix classes_home col1200" id="requireModule" rel="app/classes/classes_index">
		<?php echo $content ?>
</div>

<?php $this->endContent() ?>

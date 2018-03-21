<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/27
 * Time: 15:11
 */
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main_v2.php');
$this->registerCssFile(BH_CDN_RES . '/static/css/teacher.css' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/platform.css' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/pub/js/ztree/zTreeStyle/zTreeStyle.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/pub/js/ztree/jquery.ztree.all-3.5.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/echarts/echarts.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
?>
	<div class="col1200 clearfix">
		<div class="tch_head container currency_hg">
			<ul>
				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/setting/my-center']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/student/setting/my-center']) ?>">个人中心</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/managetask/work-list', 'student/managetask/view-correct']) ? 'ac' : '' ?>"
					   href="<?php echo url('student/managetask/work-list'); ?>">我的作业</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/answer/my-questions', 'student/answer/my-answer', 'student/answer/add-question', 'student/answer/update-question']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/student/answer/my-questions']) ?>">我的答疑</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/wrongtopic/manage', 'student/wrongtopic/wro-top-for-item']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/student/wrongtopic/manage']) ?>">错题本</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/integral/income-details', 'student/integral/my-ranking']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/student/integral/my-ranking']) ?>">我的积分</a>
				</li>

                <li>
                    <a class="<?php echo $this->context->highLightUrl(['student/mytreasure/my-treasure','student/mytreasure/treasure-details','student/mytreasure/treasure-exchange']) ? 'ac' : ''?>"
                       href="<?php echo Url::to(['/student/mytreasure/my-treasure'])?>">我的财富</a>
                </li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/setting/basic-information', 'student/setting/student-edit-basic-information', 'student/setting/change-password', 'student/setting/set-head-pic', 'student/setting/change-class']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/student/setting/basic-information']) ?>">个人设置</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['student/homeworkstatistics/homework-excellent-rate', 'student/homeworkstatistics/homework-unfinished', 'student/classshortboard/index', 'student/classshortboard/week-short']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/student/homeworkstatistics/homework-excellent-rate']) ?>">学习统计</a>
				</li>

			</ul>
		</div>
	</div>
<?php echo $content ?>
<?php $this->endContent() ?>
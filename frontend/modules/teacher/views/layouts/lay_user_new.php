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
?>
	<div class="col1200 clearfix">
		<div class="tch_head container currency_hg">
			<ul>
				<li>
					<a class="<?php echo $this->context->highLightUrl(['teacher/setting/personal-center']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/teacher/setting/personal-center']) ?>">个人中心</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['teacher/resources/collect-work-manage', 'teacher/resources/my-create-work-manage', 'teacher/question/index', 'teacher/managepaper/upload-paper', 'teacher/managepaper/index', 'teacher/favoritematerial/index', 'teacher/favoritematerial/index-create', 'teacher/managetask/organize-work-details-new', 'teacher/managetask/new-update-work-detail']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(["/teacher/resources/collect-work-manage"]) ?>">我的资源</a>
				</li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['teacher/answer/view-test', 'teacher/answer/add-question', 'teacher/answer/update-question', 'teacher/answer/my-questions', 'teacher/answer/my-answer']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/teacher/answer/my-questions']) ?>">我的答疑</a>
				</li>
				<li>
					<a class="<?php echo $this->context->highLightUrl(['teacher/integral/income-details', 'teacher/integral/my-ranking']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/teacher/integral/my-ranking']) ?>">我的积分</a>
				</li>

                <li>
                    <a class="<?php echo $this->context->highLightUrl(['teacher/mytreasure/treasure-details','teacher/mytreasure/treasure-exchange']) ? 'ac' : ''?>"
                       href="<?php echo Url::to(['/teacher/mytreasure/treasure-details'])?>">我的财富</a>
                </li>

				<li>
					<a class="<?php echo $this->context->highLightUrl(['teacher/setting/basic-information','teacher/setting/teacher-edit-basic-information','teacher/setting/change-password', 'teacher/setting/set-head-pic', 'teacher/setting/change-class']) ? 'ac' : '' ?>"
					   href="<?php echo Url::to(['/teacher/setting/basic-information']) ?>">个人设置</a>
				</li>
			</ul>
		</div>
	</div>
<?php echo $content ?>
<?php $this->endContent() ?>
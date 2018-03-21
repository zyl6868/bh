<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-28
 * Time: 上午11:47
 */
use frontend\components\helper\ImagePathHelper;
use common\components\WebDataCache;

/* @var $this yii\web\View */

$this->title = '学生-首页';
$this->registerCssFile(BH_CDN_RES . '/pub/js/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/pub/js/fancyBox/jquery.fancybox.js' . RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
/** @var common\models\pos\SeAnswerQuestion $modelList */
?>

<!--主体-->
<script type="text/javascript">
	$(function () {
		$(".fancybox").fancybox();
	})
</script>

<div class="grid_24 main">
	<div class="grid_16 alpha omega main_l">
		<div class="main_cont pr">
			<?php
			echo $this->render('_list_view', ['modelList' => $modelList, 'studentId' => $studentId, 'pages' => $pages]) ?>
		</div>
	</div>
	<div class="grid_8 alpha omega main_r">
		<div class="main_cont">
			<div class="mainContBorder">
				<div class="item">
					<h4><?php echo $studentId == user()->id ? 'Wo' : 'Ta'; ?>的答疑总汇</h4>
					<ul class="total_QA_list clearfix">
						<li>
							<span class="accept_ico">采纳</span>
							<?php echo $useCnt; ?>
						</li>
						<li>
							<span class="QA_ico">回答</span>
							<?php echo $answerCnt; ?>
						</li>
						<li>
							<span class="ask_ico">提问</span>
							<?php echo $askQuesCnt; ?>
						</li>
					</ul>
				</div>
				<div class="item">
					<h4><?php echo $studentId == user()->id ? 'Wo' : 'Ta'; ?>的教师/同学</h4>
					<ul class="ta_student_list clearfix">
						<?php
						$classAll = $this->context->getClassMemberAll($studentId);
						if (!empty($classAll)) {
							$classMember = array_slice($classAll, 0, 10);
							foreach ($classMember as $k => $v) {
								if ($v->userID != $studentId) {
									?>
									<li>
										<a href="<?php echo url('student/default/index', array('studentId' => $v->userID)) ?>">
											<img data-type='header' title="<?php echo $v->memName; ?>"
											     onerror="userDefImg(this);"
											     src="<?php echo ImagePathHelper::imgThumbnail(WebDataCache::
											     getFaceIconUserId($v->userID), 70, 70) ?>"
											     width="50" height="50" alt=""/>
											<?php echo $v->memName ?></a>
									</li>
									<?php
								}
							}
						} ?>
					</ul>
					<?php if (!empty($classMember) && $classMember[0]->classID != null) { ?>
						<a href="<?php echo url('class/member-manage', array('classId' => $classMember[0]->classID)); ?>"
						   class="blue underline">查看全部 <?php echo count($classAll); ?> 位成员 》</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!--主体end-->
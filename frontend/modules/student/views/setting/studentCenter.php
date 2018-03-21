<?php
/**
 * Created by PhpStorm.
 * User: wsk
 * Date: 2016/8/17
 * Time: 16:32
 */
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
$this->title = '学生个人中心';
$this->blocks['bodyclass'] = "platform";
$this->blocks['requireModule'] = 'app/student/stu_personal_center';
$this->registerCssFile(BH_CDN_RES . '/static/css/classes.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/stu_personal_center.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/echarts/echarts.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
/** @var common\models\pos\SeAnswerQuestion[] $answerResult */
/** @var common\models\pos\SeHomeworkRel[] $taskResult */
/** @var common\models\pos\SeWrongQuestionBookInfo[] $wrongQuestion */
/** @var common\models\search\Es_testQuestion $item */
/** @var frontend\components\BaseController $schoolModel */
/** @var common\models\pos\SeQuestionResult[] $answerCount */
/** @var common\clients\JfManageService $gradePonits */

?>

<div id="main" class="clearfix main classes_answering_question">
	<!-- 左侧 -->
	<div id="main_left" class="main_left">
		<!-- 我的作业 -->
		<div id="MyHomeWork" class="spacing MyHomeWork">
			<div class="header gap clearfix"><i class="center"></i>
				<h4 class="fl">我的作业</h4>
				<span class="gray">未完成</span>
				<a href="<?php echo url('student/managetask/work-list', ['classid' => $classId]) ?>" class="jump"></a>
			</div>
			<div>
				<?php echo $this->render("_homework_list", ['taskResult' => $taskResult, 'classId' => $classId]); ?>
			</div>
		</div>
		<!-- 我的答疑 -->
		<div id="MyQuestion" class="MyQuestion">
			<ul>
				<li class="spacing">
					<div class="header gap clearfix"><i class="center"></i>
						<h4 class="fl">我的答疑</h4>
						<a href="<?php echo url('student/answer/my-questions') ?>" class="jump"></a>
					</div>
					<?php echo $this->render('//publicView/answer/_my_question_list', ['modelList' => $answerResult, 'pages' => $pages]) ?>
				</li>
			</ul>
		</div>
		<!-- 错题本 -->
		<div id="MyError" class="MyError">
			<div class="header gap clearfix"><i class="center"></i>
				<h4 class="fl">错题本</h4>

				<div id="ComboBox" class="fl ComboBox">
					<?php
					$subject = SubjectModel::getSubjectByDepartmentCache(loginUser()->getModel(false)->department, 1);
					?>
					<div>&nbsp;<span>全部</span><i class="bottom"></i></div>
					<ul class="wrong_sel tc">
						<li>全部</li>
						<?php foreach ($subject as $val) { ?>
							<li type="<?= $val->secondCode; ?>"><?= $val->secondCodeValue; ?></li>
						<?php } ?>
					</ul>
				</div>
				<a href="<?php echo url('student/wrongtopic/manage') ?>" class="jump"></a>
			</div>
			<div class="content testPaper clearfix spacing" id="wrong_list">
				<?php echo $this->render('//publicView/wrong/_new_wrong_question_list', ['wrongQuestion' => $wrongQuestion, 'pages' => $pages]); ?>
			</div>
		</div>
		<!-- 我的组织 -->
		<div id="MyOrganizes" class="MyOrganizes">
			<div class="header gap clearfix">
				<i class="center"></i>
				<h4 class="fl">我的组织</h4>
			</div>
			<div class="groups content">
				<p>学校</p>
				<ul class="school">
					<li class="clearfix">
						<a href="<?= url(['school/index', 'schoolId' => $schoolModel->schoolID]); ?>"
						   title="<?php echo Html::encode($schoolModel->schoolName); ?>">
							<img data-type='header' onerror="userDefImg(this);"
							     src="<?php echo WebDataCache::getSchoolFaceIcon($schoolModel->schoolID) ?>" width="50"
							     height="50" alt="">
						</a>
					</li>
				</ul>
				<p>班级</p>
				<ul>
					<li class="clearfix">
						<a href="<?= url(['class/index', 'classId' => $classModel->classID]); ?>"
						   title="<?php echo Html::encode($classModel->className); ?>">
							<img data-type='header' onerror="userDefImg(this);"
							     src="<?php echo WebDataCache::getClassFaceIcon($classModel->classID) ?>" width="50"
							     height="50" alt="">
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 右侧 -->
	<div id="main_right" class="main_right">

		<div class="spacing MyIntegral">
			<h4 class="header">
				<i class="mark"></i>
				<span>我的积分</span>
				<a href="<?php echo url('student/integral/income-details') ?>" class="jump"></a>
			</h4>

			<div class="content">
				<ul>
					<li><span><?php echo !empty($todayPoints)?$todayPoints:0; ?></span>今日积分
					</li>
					<li><span></span>
					</li>
                    <li><span><?php echo !empty($totalPoints)?$totalPoints:0; ?></span>累计积分
                    </li>
					<i class="scoreArrow"></i>
				</ul>
				<?php if (empty($totalPoints)) { ?>
					<p>等级：<a href="javascript:;"><?php echo 'LV1'; ?></a></p>
					<div class="percent">
						<div class="percentRate" style="width:0;">
							<div class="percentNumWhite">
								<em><?php echo 0; ?></em>
								<em>/</em>
								<em><?php echo 300; ?></em>
							</div>
						</div>
						<div class="percentNumBlue">
							<em><?php echo 0; ?></em>
							<em>/</em>
							<em><?php echo 300; ?></em>
						</div>
					</div>
				<?php } else { ?>
					<p>等级：<a href="javascript:;"><?php
							if (!empty($gradePonits->gradeName)) {
								echo $gradePonits->gradeName;
							} ?></a></p>
					<div class="percent">
						<?php $endPoints = $gradePonits->endPoints <= 99999 ? $gradePonits->endPoints : 99999; ?>
						<div class="percentRate" style="width: <?php echo ceil(($totalPoints / $endPoints) * 100); ?>%">
							<div class="percentNumWhite">
								<em><?php echo $totalPoints; ?></em>
								<em>/</em>
								<em><?php echo $endPoints; ?></em>
							</div>
						</div>
						<div class="percentNumBlue">
							<em><?php echo $totalPoints; ?></em>
							<em>/</em>
							<em><?php echo $endPoints; ?></em>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var userId = <?php echo user()->id;?>;
		$.get("<?=url('student/setting/get-stu-messages')?>", {userId: userId}, function (result) {
			$('#studentmsg').html(result);
		})
	});
	//根据所选科目查询我的错题集
	$('.wrong_sel li').bind('click', function () {
		var type = $(this).attr('type');
		$.get('<?= url('/student/setting/wro-top-for-item');?>', {type: type}, function (data) {
			$("#wrong_list").html(data);
		})
	})
</script>



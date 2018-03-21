<?php
use common\models\pos\SeSchoolInfo;
use common\components\WebDataCache;
use common\components\WebDataKey;
use yii\helpers\Html;

$this->title = '教师个人中心';
$this->blocks['requireModule'] = 'app/teacher/teacher_home';
/**
 * @var integer $todayPoints
 * @var integer $totalPoints
 * @var integer $points
 * @var object $gradePonits
 * @var SeSchoolInfo $schoolModel
 */
?>
<div class="main col1200 clearfix tch_home" id="requireModule" rel="app/teacher/teacher_home">
	<div class="container col910 alpha no_bg">
		<div class="tch_nav">
			<ul>
				<li class="leave"><a href="<?= url('teacher/resources/collect-work-manage'); ?>"><i></i>留作业</a></li>
				<li class="ask"><a href="<?= url(['teacher/answer/add-question']); ?>"><i></i>提问题</a></li>
			</ul>
		</div>
		<div class="myResources">
			<div class="title_pannel sUI_pannel">
				<div class="pannel_l"><h4><i></i><span>我的资源</span></h4></div>
			</div>
			<div class="resources">
				<?php
					echo $this->render('_teacher_home_statistics', ['userId' => user()->id]);
				?>
			</div>
		</div>
		<div class="myOrganizes">
			<div class="title_pannel sUI_pannel">
				<div class="pannel_l"><h4><i></i><span>我的组织</span></h4></div>
				<!--        <div class="pannel_r"><a href="#"></a></div>-->
			</div>
			<div class="organizes pd25">
				<div class="groups">
					<p>学校</p>
					<ul>
						<li>
							<a href="<?= url(['school/index', 'schoolId' => $schoolModel->schoolID]); ?>"
							   title="<?php echo Html::encode($schoolModel->schoolName); ?>">
								<img data-type='header' onerror="userDefImg(this);"
								     src="<?php echo WebDataCache::getSchoolFaceIcon($schoolModel->schoolID) ?>"
								     width="50" height="50" alt="">
							</a>
						</li>
					</ul>
				</div>
				<div class="groups">
					<p>班级</p>
					<ul>
						<?php foreach ($classArr as $classVal) { ?>

							<li>
								<a href="<?= url(['class/index', 'classId' => $classVal->classID]); ?>"
								   title="<?php echo Html::encode($classVal->className); ?>">
									<img data-type='header' onerror="userDefImg(this);"
									     src="<?php echo WebDataCache::getClassFaceIcon($classVal->classID) ?>"
									     width="50" height="50" alt="">
								</a>
							</li>

						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="aside col260 omega no_bg">
		<div class="myScores">
			<div class="title_pannel sUI_pannel">
				<div class="pannel_l"><h4><i></i><span>我的积分</span></h4></div>
				<div class="pannel_r"><a href="<?php echo url('teacher/integral/income-details') ?>"></a></div>
			</div>
			<div class="scores pd25">
				<div class="score">
					<div><span><?php echo $todayPoints; ?></span>今日积分</div>
                    <div><span></span></div>
                    <div><span><?php echo $totalPoints; ?></span>累计积分</div>
					<i class="scoreArrow"></i>
				</div>
				<p>等级：<a href="javascript:;"><?php echo $gradePonits->gradeName; ?></a></p>
				<div class="percent">
					<?php $endPoints = $gradePonits->endPoints <= 99999 ? $gradePonits->endPoints : 99999; ?>
					<div class="percentRate" style="width:<?php echo ceil(($totalPoints / $endPoints) * 100) ?>%;">
						<div class="percentNumWhite">
							<em><?php echo $totalPoints; ?></em><em>/</em><em><?php echo $endPoints; ?></em></div>
					</div>
					<div class="percentNumBlue">
						<em><?php echo $totalPoints; ?></em><em>/</em><em><?php echo $endPoints; ?></em></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		var userId = <?php echo user()->id;?>;
		$.get("<?=url('teacher/setting/get-messages')?>", {userId: userId}, function (result) {
			$('#teachermsg').html(result);
		})

	});
</script>
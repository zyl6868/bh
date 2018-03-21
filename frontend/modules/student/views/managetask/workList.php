<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/8/18
 * Time: 11:31
 */
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = '我的作业';
$this->registerCssFile(BH_CDN_RES . '/static/css/student_test_paper.min.css'. RESOURCES_VER);
$this->blocks['requireModule'] = 'app/student/student_test_paper';

$department = loginUser()->getModel()->department;

$subjectArray = SubjectModel::getSubjectByDepartmentCache($department);
$countSubject = count($subjectArray);
?>
<div class="main col1200 clearfix" id="requireModule" rel="app/teacher/teacher_home_hmwk">
	<div class="tch_question container col910 omega no_bg">
		<div class="container del_margin">
			<div class="pd25">
				<div id="classes_file_crumbs" class="classes_file_crumbs">

				</div>
				<div id="classes_sel_list" class="sUI_formList sUI_formList_min classes_file_list classes_sel_list"
				     cl="10170520">
					<div id="AllSubjects" class="row" style="overflow: hidden;">
						<div class="form_l tl subject_list">
							<a class="sel_ac" subject="" data-sel-item="" href="javascript:;">全部学科</a>
						</div>
						<div class="form_r moreContShow">
							<?php if ($countSubject > 9) { ?>
								<a class="showMoreBtn" href="javascript:;">更多<i></i></a>
							<?php } ?>
							<ul>
								<?php
								$i = 0;
								foreach ($subjectArray as $key => $val) {

									++$i;
									?>
									<li class="sub_find">
										<a class="subject_list" subject="<?php echo $val->secondCode; ?>"
										   data-sel-item="" href="javascript:;">
											<?php echo $val->secondCodeValue; ?>
										</a>
									</li>

									<?php
									if ($i == 9) {
										echo '<br />';
									}
								} ?>


							</ul>

						</div>
					</div>
					<div id="FullState" class="row">
						<div class="form_l tl click_state">
							<a class="" state="2" data-sel-item="" href="javascript:;">全部状态</a>
						</div>
						<div class="form_r">
							<ul>
								<li class="click_state">
									<a state="1" data-sel-item="" href="javascript:;" class="">已完成</a>
								</li>
								<li class="click_state">
									<a class="sel_ac" state="0" data-sel-item="" href="javascript:;">未完成</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container no_bg">
			<div class="classbox">    <!-- 年份开始 -->
				<?php echo $this->render('work_list', ['list' => $list, 'pages' => $pages, 'classId' => $classId]); ?>
			</div>

		</div>
	</div>
</div>
<script>
	$('#FullState').find('a').click(function () {
		var state = $(this).attr('state');
		var subjectId = $('#AllSubjects').find('.sel_ac').attr('subject');
		$.post('<?=Url::to(["/student/managetask/work-list"])?>', {
			state: state,
			subjectId: subjectId
		}, function (result) {
			$('.classbox').html(result);

		})
	});
	$('#AllSubjects').find('a').not('.showMoreBtn').click(function () {
		var state = $('#FullState').find('.sel_ac').attr('state');
		var subjectId = $(this).attr('subject');
		$.post('<?=Url::to(["/student/managetask/work-list"])?>', {
			state: state,
			subjectId: subjectId
		}, function (result) {
			$('.classbox').html(result);

		})
	})
</script>
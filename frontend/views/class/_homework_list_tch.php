<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/7
 * Time: 11:44
 */

use common\helper\DateTimeHelper;
use common\models\pos\SeHomeworkTeacher;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;
use yii\helpers\Url;
/** @var common\models\pos\SeHomeworkRel[] $homework */
/** @var common\models\pos\SeHomeworkRel[] $newHomeworkGVal */
?>

<?php
if (empty($homework)):
	echo ViewHelper::emptyView("暂无作业，请创建！");
endif;

$newHomeworkGroup = [];
foreach ($homework as $homeworkKey => $homeworkVal) {
	$date = date('Y-m-d', DateTimeHelper::timestampDiv1000($homeworkVal->createTime));
	$newHomeworkGroup[$date][] = $homeworkVal;
}

foreach ($newHomeworkGroup as $newHomeworkGKey => $newHomeworkGVal) { ?>

	<div class="yearitem">
		<div class="title_pannel sUI_pannel">
			<div class="pannel_l">
				<h4>
					<i class="calendar_pic"></i>
					<span><?php echo date("Y年m月", strtotime($newHomeworkGKey)); ?></span>
				</h4>
			</div>
		</div>
		<!-- 日份开始 -->
		<div class="monthbox">
			<ul class="worklist">
				<?php
				$isTop = true;
				$isNoBorder = false;

				foreach ($newHomeworkGVal as $key => $val) {

					//作业详情
					$homeworkInfo = $val->homeworkTeacherInfo;

					if (!empty($homeworkInfo)) {
						?>
						<!-- 年月份开始 -->

						<li class="clearfix <?php if ($isTop) {
							echo 'work_notop';
							$isTop = false;
						} ?>" relId="<?= $val->id ?>">

							<em class="num"><?php echo date('d', DateTimeHelper::timestampDiv1000($val->createTime)); ?></em>

							<div class="work_left">
								<div class="work_top clearfix">
									<span class="work_img <?php if ($homeworkInfo->getType == 0) {
										echo 'picture';
									} elseif ($homeworkInfo->getType == 1) {
										echo 'word';
									} ?>"></span>

									<div class="work_info">
										<p class="work_title">
											<a title=" <?php echo Html::encode($homeworkInfo->name); ?>"
											   href="<?php if ($homeworkInfo->getType == 0) {
												   echo Url::to(['up-details', 'homeworkId' => $homeworkInfo->id, 'classId' => $classId]);
											   } else {
												   echo Url::to(['organize-details', 'homeworkId' => $homeworkInfo->id, 'classId' => $classId]);
											   } ?>">
												<?php echo Html::encode($homeworkInfo->name); ?>
											</a></p>

										<p>
											截止：<?php echo date('Y年m月d日', DateTimeHelper::timestampDiv1000($val->deadlineTime)); ?></p>
									</div>
								</div>
								<div class="work_bottom clearfix">
									<ul class="progress">
										<li class="clearfix">
											<span>提交：</span>

											<div class="progress_outer">
												<div class="progress_inner" style="width: <?php
												if (isset($val->memberTotal) && $val->memberTotal != 0) {
													echo ($val->uploadNum / $val->memberTotal) * 100;
												} else {
													echo '0';
												}
												?>%"></div>
											</div>
											<label><?php echo $val->uploadNum . "/" . $val->memberTotal; ?></label>
										</li>

                                    <?php if($homeworkInfo->homeworkType != SeHomeworkTeacher::SPOKEN_HOMEWORK && $homeworkInfo->homeworkType != SeHomeworkTeacher::READ_HOMEWORK ){?>
										<li class="clearfix">
											<span>批改：</span>

											<div class="progress_outer">
												<div class="progress_inner" style="width: <?php
												if (isset($val->uploadNum) && $val->uploadNum != 0) {
													echo ($val->checkNum / $val->uploadNum) * 100;
												} else {
													echo '0';
												}
												?>%"></div>
											</div>
											<label><?php echo $val->checkNum . "/" . $val->uploadNum; ?></label>
										</li>
                                    <?php }?>
									</ul>
								</div>
							</div>
							<div class="work_right">
								<img src="<?= url('qrcode/zy/' . $val->id) ?>" class="qr" alt="" width="144"
								     height="144">

								<div class="oper">
									<?php
									$nowDatetime = time();
									?>
									<?php if ($nowDatetime > strtotime(date('Y-m-d 23:59:59', DateTimeHelper::timestampDiv1000($val->deadlineTime)))) { ?>
										<a href="javascript:;"
										   class="btn bg_white btn40 icoBtn_book bookBtn btn_disable"><i></i>已截止</a>
									<?php } else {
										if ($val->isSendMsgStudent == 0) { ?>
											<a href="javascript:;"
											   class="btn bg_white btn40 icoBtn_book bookBtn urge"><i></i>催作业</a>
										<?php } else { ?>
											<a href="javascript:;"
											   class="btn bg_white btn40 icoBtn_book bookBtn  btn_disable "><i></i>催作业</a>
										<?php }
									} ?>

                                    <?php
                                        if($homeworkInfo->homeworkType == SeHomeworkTeacher::SPOKEN_HOMEWORK || $homeworkInfo->homeworkType == SeHomeworkTeacher::READ_HOMEWORK ){
                                    ?>
                                        <a href="javascript:void ();" class="btn bg_white btn40 icoBtn_gou gouBtn btn_disable"><i></i>去批改</a>

                                    <?php }else{ ?>

                                        <a href="<?php echo Url::to(['/class/work-detail', 'classId' => $classId, 'classhworkid' => $val->id]) ?>"
                                               class="btn bg_white btn40 icoBtn_gou gouBtn"><i></i>去批改</a>

                                   <?php } ?>


									<?php if ($homeworkInfo->getType == 0) { ?>
										<a href="javascript:;"
										   class="btn bg_white btn40 icoBtn_book bookBtn btn_disable"><i></i>看结果</a>
									<?php } else {
									    $url = "/workstatistical/work-statistical-all";
                                        if( $homeworkInfo->homeworkType == SeHomeworkTeacher::SPOKEN_HOMEWORK || $homeworkInfo->homeworkType == SeHomeworkTeacher::READ_HOMEWORK ){
                                            $url = "/workstatistical/work-statistical-audio";
                                        }
									    ?>
										<a href="<?php echo Url::to([$url, 'relId' => $val->id, 'classId' => $val->classID]) ?>"
										   class="btn bg_white btn40 icoBtn_result resultBtn"><i></i>看结果</a>
									<?php } ?>
								</div>
							</div>
						</li>
					<?php }
				} ?>
			</ul>
		</div>
		<!-- 月份结束-->
	</div>
	<!-- 年份结束-->

<?php } ?>
<div class="page">
	<?php
	echo \frontend\components\CLinkPagerExt::widget(array(
			'pagination' => $pages,
			'updateId' => '.classbox',
			'maxButtonCount' => 10,
			'showjump' => true
		)
	);
	?>
</div>
<script>
	$('.urge').click(function () {
		var $this = $(this);
		var relId = $(this).parents('li').attr('relId');
		$.post('<?=Url::to("/ajax/urge-homework")?>', {relId: relId}, function (result) {
			if (result.success) {
				require(['popBox'], function (popBox) {
					popBox.successBox('已成功给学生发送信息');
				});
				$this.addClass('btn_disable').removeClass('urge');
				$this.unbind('click');
			} else {
				require(['popBox'], function (popBox) {
					popBox.errorBox(result.message);
				})
			}
		})
	})
</script>
<?php
/**
 * Created by PhpStorm.
 * User: wsk
 * Date: 2016/8/17
 * Time: 17:39
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php
if (empty($taskResult)):
	echo ViewHelper::emptyView("暂无作业！");
endif;

/** @var common\models\pos\SeHomeworkRel[] $taskResult */
/** @var common\models\pos\SeHomeworkRel[] $newHomeworkGVal */

$newHomeworkGroup = [];
foreach ($taskResult as $homeworkKey => $homeworkVal) {
	$date = date('Y-m-d', DateTimeHelper::timestampDiv1000($homeworkVal->createTime));
	$newHomeworkGroup[$date][] = $homeworkVal;
}

foreach ($newHomeworkGroup as $newHomeworkGKey => $newHomeworkGVal) {
	?>
	<div class="content gap">
		<h4 class="time"><?php echo date("Y年m月", strtotime($newHomeworkGKey)); ?></h4>
		<ul>
			<?php
			$isTop = true;
			foreach ($newHomeworkGVal as $key => $val) {
				//作业详情
				$homeworkInfo = $val->homeworkTeacherInfo;

				if (!empty($homeworkInfo)) { ?>
					<li class="clearfix <?php if ($isTop) {
						echo 'work_notop';
						$isTop = false;
					} ?>">
						<!-- 日期 -->
						<em class="num"><?php echo date('d', DateTimeHelper::timestampDiv1000($val->createTime)); ?></em>
                <span class="work_img <?php if ($homeworkInfo->getType == 0) {
	                echo 'picture';
                } elseif ($homeworkInfo->getType == 1) {
	                echo 'word';
                } ?>"></span>

						<div class="work_info">
                            <a title=" <?php echo Html::encode($homeworkInfo->name); ?>"
                               href="<?php echo Url::to(['/classes/managetask/details', 'classId' => $classId, 'relId' => $val->id]); ?>">
                                <p class="work_title" title="<?php echo Html::encode($homeworkInfo->name); ?>">
                                    <?php echo Html::encode($homeworkInfo->name); ?>
                                </p>
                            </a>

							<p>
								截止：<?php echo date('Y年m月d日', DateTimeHelper::timestampDiv1000($val->deadlineTime)); ?></p>

							<div class="work_bottom clearfix">
								<span>提交:</span>

								<div class="scaling">
									<div style="width: <?php
									if (isset($val->memberTotal) && $val->memberTotal != 0) {
										echo ($val->uploadNum / $val->memberTotal) * 100;
									} else {
										echo '0';
									}
									?>%"></div>
								</div>
								<span><?php echo $val->uploadNum . "/" . $val->memberTotal; ?></span>
							</div>
						</div>
						<span class="not_complete_ico"></span>

						<div class="work_right fr">
							<img src="<?= url('qrcode/zy/' . $val->id) ?>" class="qr" alt="" width="102" height="102">

                            <div class="oper do">
                                <div>扫码<span>写作业</span></div>
                                <u></u>
                                <p>请在班海APP中使用“扫一扫”</p>
                            </div>
						</div>
					</li>
					<?php
				}
			} ?>
		</ul>
	</div>
<?php } ?>


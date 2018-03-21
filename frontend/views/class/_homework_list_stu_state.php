<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/13
 * Time: 14:26
 */
use common\helper\DateTimeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php
$isTop = true;
/** @var common\models\pos\SeHomeworkRel[] $newHomeworkGVal */
foreach ($newHomeworkGVal as $key => $val) {
	$isUploadAnswer = $val->existsStuIsUpload;
	//作业详情
	$homeworkInfo = $val->homeworkTeacherInfo;

	if (!empty($homeworkInfo)) { ?>
		<li class="clearfix <?php if ($isTop) {
			echo 'work_notop';
			$isTop = false;
		} ?>">
			<em class="num"><?php echo date('d', DateTimeHelper::timestampDiv1000($val->createTime)); ?></em>

			<div class="work_left">
				<div class="work_top clearfix">
					<span class="work_img <?php if ($homeworkInfo->getType == 0) {
						echo 'picture';
					} elseif ($homeworkInfo->getType == 1) {
						echo 'word';
					} ?>"></span>

					<div class="work_info">
						<p class="work_title" title="<?php echo Html::encode($homeworkInfo->name); ?>">
                            <a title=" <?php echo Html::encode($homeworkInfo->name); ?>"
                               href="<?php echo Url::to(['/classes/managetask/details', 'classId' => $classId, 'relId' => $val->id]); ?>">
                                <?php echo Html::encode($homeworkInfo->name); ?>
                            </a>
						</p>

						<p>
							截止：<?php echo date('Y年m月d日', DateTimeHelper::timestampDiv1000($val->deadlineTime)); ?>
						</p>
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
					</ul>
				</div>
			</div>
			<span class="<?php if ($isUploadAnswer) {
				echo "complete_ico";
			} elseif (!$isUploadAnswer) {
				echo "not_complete_ico";
			} ?>"></span>

			<div class="work_right">
				<img src="<?= url('qrcode/zy/' . $val->id) ?>" class="qr" alt="" width="102"
				     height="102">

                <?php if ($isUploadAnswer){ ?>
                    <div class="oper do">
                        <div>扫码<span>看结果</span></div>
                        <u></u>
                        <p>请在班海APP中使用“扫一扫”</p>
                    </div>
                <?php }else{ ?>
                    <div class="oper do">
                        <div>扫码<span>写作业</span></div>
                        <u></u>
                        <p>请在班海APP中使用“扫一扫”</p>
                    </div>
                <?php } ?>
			</div>
		</li>
		<?php
	}
} ?>

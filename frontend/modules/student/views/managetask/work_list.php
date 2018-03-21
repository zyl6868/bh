<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/8/18
 * Time: 14:46
 */
use common\helper\DateTimeHelper;
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\pos\SeHomeworkRel $value */

$newWorkList = [];
foreach ($list as $k => $v) {
	$date = date('Y-m-d', DateTimeHelper::timestampDiv1000($v->createTime));
	$newWorkList[$date][] = $v;
}

?>

<!-- 年份开始 -->
<?php if (!empty($newWorkList)) {
	foreach ($newWorkList as $k => $v) { ?>
		<div class="yearitem">
			<div class="title_pannel sUI_pannel">
				<div class="pannel_l">
					<h4>
						<i class="calendar_pic"></i>
						<span><?php echo date('Y年m月', strtotime($k)) ?></span>
					</h4>
				</div>
			</div>
			<!-- 月份开始 -->
			<div class="monthbox">
				<ul class="worklist">
					<?php foreach ($v as $key => $value) {
						//查询已答数
						$isUploadAnswer = $value->existsStuIsUpload;

						?>
						<li class="clearfix <?= $key == 0 ? 'work_notop' : ''; ?>">
							<em class="num"><?= date('d', strtotime($k)); ?></em>

							<div class="work_left">
								<div class="work_top clearfix">
									<span
										class="work_img <?= $value['homeWorkTeacher']->getType ? 'word' : 'paper'; ?>"></span>

									<div class="work_info">
                                        <p class="work_title" title="<?= Html::encode($value['homeWorkTeacher']->name); ?>">
                                            <a title=" <?php echo Html::encode($value['homeWorkTeacher']->name); ?>"
                                               href="<?php echo Url::to(['/classes/managetask/details', 'classId' => $classId, 'relId' => $value->id]); ?>">
                                                <?php echo Html::encode($value['homeWorkTeacher']->name); ?>
                                            </a>
                                        </p>

										<p>
											截止：<?= date('Y年m月d日', DateTimeHelper::timestampDiv1000($value->deadlineTime)); ?>
										</p>
									</div>
								</div>
								<div class="work_bottom clearfix">
									<ul class="progress">
										<li class="clearfix">
											<span>提交：</span>

											<div class="progress_outer">
												<div class="progress_inner"
												     style="width: <?= empty($value->uploadNum) ? 0 : $value->uploadNum / $value->memberTotal * 100; ?>%"></div>
											</div>
											<label><?= $value->uploadNum; ?>/<?= $value->memberTotal; ?></label>
										</li>
									</ul>
								</div>
							</div>

							<span class="<?= $isUploadAnswer ? 'complete_ico' : 'not_complete_ico'; ?>"></span>

							<div class="work_right">
								<img src="<?= url('qrcode/zy/' . $value->id); ?>" class="qr" alt="" width="102"
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

					<?php } ?>
				</ul>
			</div>
			<!-- 月份结束-->
		</div>
	<?php }
} else {
	ViewHelper::emptyViewByPage($pages, $message = '暂无作业！');
} ?>
<!-- 年份结束-->
<div class="page">
	<?php
	echo CLinkPagerExt::widget(array(
			'pagination' => $pages,
			'updateId' => '.classbox',
			'maxButtonCount' => 10,
			'showjump' => true
		)
	);
	?>
</div>

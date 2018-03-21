<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-28
 * Time: 下午12:10
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;

if (empty($modelList)) {
	ViewHelper::emptyView();
} else {
	/** @var common\models\pos\seAnswerQuestion $item */
	foreach ($modelList as $key => $item) {
		$questionResult = $item->getQuestionResult()->all();
		?>

		<dl class="QA_list">
			<dt class="newTime">
				<em><?php echo date('Y', DateTimeHelper::timestampDiv1000($item->createTime)); ?></em>
				<?php echo date('m', DateTimeHelper::timestampDiv1000($item->createTime)); ?>
			</dt>
			<dd>
				<div class="dot_line first_dot_line"><i></i></div>
				<?php if ($item->ifSelfAsked($studentId)) { ?>

					<div class="QA_cont">
						<span class="arrow"></span>
						<h5>提出了1个<?php echo SubjectModel::model()->getName((int)$item->subjectID); ?>问题</h5>

						<p class="gray_d time">
							<?php echo date('Y-m-d H:i:s', DateTimeHelper::timestampDiv1000($item->createTime)); ?>
						</p>

						<div class="form_list">
							<div class="row">
								<div class="formL">
									<label>问:</label>
								</div>
								<div class="formR">
									<span class="gray_555"><?php echo Html::encode($item->aqName); ?></span>
								</div>
							</div>
							<?php if (!empty($item->aqDetail)) { ?>
								<div class="row">
									<div class="formL">
										<label>补:</label>
									</div>
									<div class="formR">
										<span class="gray_777">
											<?php echo StringHelper::htmlPurifier($item->aqDetail); ?>
										</span>
										<?php if ($item->imgUri !== null && $item->imgUri !== '') { ?>
											<div class="QA_cont_imgBox">
												<?php
												//分离图片
												$img = explode(',', $item->imgUri);
												foreach ($img as $k => $imgSrc) {
													?>
													<a class="fancybox" href="<?php echo resCdn($imgSrc); ?>"
													   data-fancybox-group="gallery_<?php echo $item->aqID; ?>">
														<img width="160" height="120"
														     src="<?php echo resCdn($imgSrc); ?>" alt=""/>
													</a>
												<?php } ?>
											</div>
										<?php } ?>

									</div>
								</div>
							<?php } ?>

							<?php if (!empty($questionResult)) {
								?>
								<div class="row">
									<div class="formL">
										<label>答:</label>
									</div>
									<div class="formR">
										<span class="gray_777"><?php echo $questionResult[0]['resultDetail']; ?></span>
									</div>
								</div>
							<?php } ?>


							<div class="row row_button">
								<div class="formL">
									<label></label>
								</div>
								<div class="formR tr">

									<a href="<?php echo url(['/platform/answer/detail', 'aqid' => $item->aqID]); ?>#answerCntPoint"
									   class="btn w120 bg_green answerBtn">马上回答</a>
								</div>
							</div>
						</div>
					</div>

				<?php } else { ?>
					<?php if ($item->ifAccepted($studentId) == 0) { ?>
						<div class="QA_cont">
							<span class="arrow"></span>
							<h5>
								回答了1道<?php echo \common\models\dicmodels\SubjectModel::model()->getName((int)$item->subjectID); ?>
								问题</h5>

							<p class="gray_d time"><?php echo date('Y-m-d H:i:s', DateTimeHelper::timestampDiv1000($item->createTime)); ?></p>

							<div class="form_list">
								<div class="row">
									<div class="formL">
										<label>问:</label>
									</div>
									<div class="formR">
										<span class="gray_555"><?php echo Html::encode($item->aqName); ?></span>
									</div>
								</div>
								<?php if (!empty($questionResult)) { ?>
									<div class="row">
										<div class="formL">
											<label>答:</label>
										</div>

										<div class="formR">
											<span
												class="gray_777"><?php echo $questionResult[0]['resultDetail']; ?></span>
											<?php if ($item->imgUri !== null && $item->imgUri !== '') { ?>
												<div class="QA_cont_imgBox">
													<?php
													//分离图片

													$img = explode(',', $item->imgUri);

													foreach ($img as $k => $imgSrc) {
														?>
														<a class="fancybox " href="<?php echo resCdn($imgSrc); ?>"
														   data-fancybox-group="gallery_<?php echo $item->aqID; ?>">
															<img width="160" height="120" src="<?php echo $imgSrc; ?>"
															     alt=""/>
														</a>
													<?php } ?>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<div class="row row_button">
									<div class="formL">
										<label></label>
									</div>
									<div class="formR tr">
										<a href="<?php echo url(['/platform/answer/detail', 'aqid' => $item->aqID]); ?>#answerCntPoint"
										   class="btn w120 bg_green answerBtn">继续回答</a>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="QA_cont">
							<span class="arrow"></span>
							<h5>
								1个<?php echo SubjectModel::model()->getName((int)$item->subjectID) ?>
								答案被采纳</h5>

							<p class="gray_d time"><?php echo date('Y-m-d H:i:s', \common\helper\DateTimeHelper::timestampDiv1000($item->createTime)); ?></p>

							<div class="form_list">
								<div class="row">
									<div class="formL">
										<label>问:</label>
									</div>
									<div class="formR">
										<span class="gray_555"><?php echo Html::encode($item->aqName); ?></span>
									</div>
								</div>
								<?php if (!empty($questionResult)) { ?>
									<div class="row choose_div">
										<div class="formL">
											<label>答:</label>
										</div>
										<div class="formR">
											<span
												class="gray_777"><?php echo $questionResult[0]['resultDetail']; ?></span>
											<?php if ($item->imgUri !== null && $item->imgUri !== '') { ?>
												<div class="QA_cont_imgBox">
													<?php
													//分离图片
													$img = explode(',', $item->imgUri);
													foreach ($img as $k => $imgSrc) {
														?>
														<a class="fancybox" href="<?php echo resCdn($imgSrc); ?>"
														   data-fancybox-group="gallery_<?php echo $item->aqID; ?>">
															<img width="160" height="120"
															     src="<?php echo resCdn($imgSrc); ?>" alt=""/>
														</a>
													<?php } ?>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php
					}

				}
				?>
			</dd>
		</dl>
		<?php
	}
} ?>
<?php
if (!empty($modelList)) {
	if ($pages->getPageCount() > $pages->getPage() + 1) {
		?>
		<div id="more" class="moreQA"
		     onclick="return  getEvent(<?php echo $studentId; ?>,<?php echo $pages->getPage() + 2; ?>);">更多
		</div>
		<script>
			var getEvent = function (userid, page) {
				$.get('<?php echo url('student/default/get-pages') ?>', {
					userid: userid,
					page: page
				}, function (data) {
					$('#more').replaceWith(data);
				});
			}
		</script>
	<?php } else { ?>

		<div class="moreQA emptyQA">没有了</div>

		<?php
	}
} ?>


<script>
	$(function () {
		$('.textBtnJS').click(function () {
			$(this).parents('.row_button').hide().siblings('.textarea_box').show();
		});
		$('.resultAnswer').live('click', function () {
			var $_this = $(this);
			var aqid = $_this.attr('data_val');
			var answer = $_this.parent().parent().parent().find('.detail textarea').val();
			if (answer == '') {
				popBox.errorBox('内容不能为空！');
				return false;
			}
			$.post("<?php echo url('student/default/result-question')?>", {
				aqid: aqid,
				answer: answer
			}, function (data) {
				$_this.parents('.QA_list').find('.row_button').before(data);
				$_this.parents('.textarea_box').find('textarea').val('');
				$_this.parents('.textarea_box').hide();
				$_this.parents('.QA_cont').find('.row_button').show();
			})
		})
	})


</script>

<script type="text/javascript">
	var obj = $(".main_l").find(".QA_list");
	var array = [];
	obj.each(function (index, el) {
		var result = $(el).find(".newTime").text();
		if ($.inArray(result, array) == -1) {
			array.push(result);
		}
		else {
			$(el).find(".newTime").hide();
		}

	})
</script>
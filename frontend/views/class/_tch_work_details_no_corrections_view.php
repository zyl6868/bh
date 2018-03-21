<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/11
 * Time: 17:20
 */
use common\models\pos\SeHomeworkAnswerImage;
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\StringHelper;
use common\components\WebDataCache;

/** @var common\models\pos\SeHomeworkTeacher $homeworkDetailsTeacher */
/** @var common\models\pos\SeHomeworkAnswerInfo $item */
/** @var common\models\pos\SeHomeworkAnswerInfo $homeworkAnswerID */
/** @var common\models\pos\SeHomeworkAnswerQuestionAll $v */

$answerInfoImg = $item->getHomeworkAnswerDetailImage()->all();
$answerInfoImgCount = count($answerInfoImg);
$answerQuestionAll = $item->getHomeworkAnswerQuestionAll()->all();
$answerImg = SeHomeworkAnswerImage::find()->where(['homeworkAnswerId' => $item->homeworkAnswerID])->all();
$isCountAnswerImg = count($answerImg);
//判断有没有主观题
$hasMajor = false;
foreach ($answerQuestionAll as $v) {

	$shTestQuestion = ShTestquestion::getTestQuestionDetails_Cache($v->questionID);
	if ($shTestQuestion) {
		$isMajor = $shTestQuestion->isMajorQuestion();
		if ($isMajor) {
			$hasMajor = true;
			break;
		}
	}
}

?>
<div class="stu_item">
	<div class="title item_title noBorder replyTitle">
		<div class="sUI_pannel">
			<div class="pannel_l">
				<h4><a href="#" class="blue_l_l"
				       title="<?php echo WebDataCache::getTrueNameByuserId($item->studentID); ?>">
						<?php echo WebDataCache::getTrueNameByuserId($item->studentID); ?>
					</a>
					的答案<?php
					if ($answerInfoImgCount != '0') {
						echo "--共" . $answerInfoImgCount . "页&nbsp;&nbsp;";
					}
					?>
					<span class="gray">
						<?php
						if ($item->isCheck == 1) {
							echo '已批改';
						} else {
							echo '未批改';
						} ?>
					</span>
				</h4>
			</div>
			<div class="pannel_r">
				<span>
					<?php
					if ($item->isCheck == 1) {
						if ($item->getType == 0) { ?>
							<a class="btn btn26 bg_blue icoBtn_add_blue"
							   href="<?= url('class/correct-pic-hom', ['classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerID, 'type' => 1]) ?>">查看批改</a>
						<?php } elseif ($hasMajor == true && $item->getType == 1) { ?>
							<a class="btn btn26 bg_blue icoBtn_add_blue"
							   href="<?= url('class/correct-org-hom', ['classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerID, 'type' => 1]) ?>">查看批改</a>
						<?php }
					} else { ?>
						<?php if ($hasMajor == false && $item->getType == 1) { ?>
							<a class="btn btn26 bg_blue icoBtn_add_blue stuOperation"
							   modify="<?php echo $homeworkAnswerID; ?>">批改作业</a>
						<?php } else {
							if ($item->getType == 0) { ?>
								<a class="btn btn26 bg_blue icoBtn_add_blue"
								   href="<?= url('class/correct-pic-hom', ['classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerID]) ?>">批改作业</a>
							<?php } elseif ($item->getType == 1) { ?>
								<a class="btn btn26 bg_blue icoBtn_add_blue"
								   href="<?= url('class/correct-org-hom', ['classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerID]) ?>">批改作业</a>
							<?php }
						}
					} ?>
				</span>
			</div>
		</div>
	</div>
	<div class="questionArea">
		<div class="pd25">
			<div class="my_answer">
				<div class="digitalFile">
					<?php

					if ($item->getType == 1) {

						$questionIdResult = [];
						foreach ($answerQuestionAll as $v) {
							$testQuestion = $v->getShTestquestion_cache();
							if (!isset($testQuestion)) {
								continue;
							}
							$getQuestionShowType = $testQuestion->getQuestionShowType();
							$isMajorQuerstion = $testQuestion->isMajorQuestion();
							$questionIdResult[$homeworkDetailsTeacher->getQuestionNo($v['questionID'])] ['questionID'] = $v['questionID'];
							$questionIdResult[$homeworkDetailsTeacher->getQuestionNo($v['questionID'])] ['type'] = $getQuestionShowType;
							$questionIdResult[$homeworkDetailsTeacher->getQuestionNo($v['questionID'])] ['correctResult'] = $v['correctResult'];
							$questionIdResult[$homeworkDetailsTeacher->getQuestionNo($v['questionID'])] ['answerOption'] = $v['answerOption'];
							$questionIdResult[$homeworkDetailsTeacher->getQuestionNo($v['questionID'])] ['isMajorQuestion'] = $isMajorQuerstion;
						}
						ksort($questionIdResult);
						foreach ($questionIdResult as $key => $item) {
							if ($item['isMajorQuestion'] == 0) {
								echo "<h6>客观题答案</h6>";
								break;
							}
						} ?>
						<p>
							<?php
							foreach ($questionIdResult as $key => $item) {
								if ($item['isMajorQuestion'] == 0) {
									?>
									<span class="correct">
								<?php echo $key . '.';
								if ($item["answerOption"] == '') {
									echo '未答';
								} else {

									if ($item['type'] == 9) {
										echo LetterHelper::rightOrWrong($item["answerOption"]);
									} else {
										$answerOption = explode(",", $item["answerOption"]);
										foreach ($answerOption as $v1) {
											echo LetterHelper::getLetter($v1);
										}
									}
								}
								?>
										<i class="
								<?php if ($item['correctResult'] == 1) {
											echo 'wrong';
										} elseif ($item['correctResult'] == 2) {
											echo 'half';
										} elseif ($item['correctResult'] == 3) {
											echo 'right';
										} else {
											echo '';
										} ?>
								"></i>
							</span>
									<?php
								}
							}
							?>
						</p>
						<?php if ($hasMajor) { ?>
							<h6>主观题答案</h6>
						<?php }

						if ($hasMajor) {
							?>

							<p>
							<?php
							if ($hasMajor && $isCountAnswerImg == 0) {
								echo '该学生未答主观题' . "<br>";
							} ?>
							<?php
							foreach ($questionIdResult as $key => $item) {
								if ($item['isMajorQuestion'] == 1) {
									?>
									<span class="correct">
								<?php echo $key . '.'; ?>
										<i class="
								<?php if ($item['correctResult'] == 1) {
											echo 'wrong';
										} elseif ($item['correctResult'] == 2) {
											echo 'half';
										} elseif ($item['correctResult'] == 3) {
											echo 'right';
										} else {
											echo '';
										} ?>
								"></i>
							</span>
								<?php }
							}
						} ?>
						</p>
						<ul class="up_test_list clearfix ">
							<?php
							foreach ($answerImg as $val) { ?>
								<li>
									<a href="<?= url('class/correct-org-hom', ['classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerID, '#' => $val->answerImageId]) ?>">
										<img src="<?php echo ImagePathHelper::imgThumbnail($val->url, 180, 120) ?>">
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } else { ?>
						<div class="digitalFile">

							<h6>答案</h6>
							<ul class="up_test_list clearfix ">
								<?php foreach ($answerInfoImg as $val) {
									?>
									<li>
										<a href="<?= url('class/correct-pic-hom', ['classId' => $classId, 'homeworkAnswerID' => $homeworkAnswerID, '#' => $val->tID]) ?>">
											<img
												src="<?php echo ImagePathHelper::imgThumbnail($val->imageUrl, 180, 120); ?>"
												alt="">
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
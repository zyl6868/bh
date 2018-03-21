<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/29
 * Time: 14:48
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;
use yii\web\View;

$this->registerCssFile(BH_CDN_RES . '/static/js/lib/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/fancyBox/jquery.fancybox.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/lib/lazyload/jquery.lazyload.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
/** @var  common\models\pos\SeAnswerQuestion $modelList */
?>
<script type="text/javascript">
	$(function () {
		$(".fancybox").die().fancybox();
		$("img.lazy").lazyload({
			effect: "fadeIn"
		});
	})
</script>

<div id="answerPage" class="answerPage">

	<ul class="QA_list">
		<?php
		if (empty($modelList)) {
			echo ViewHelper::emptyView("暂无答疑！");
		}

		foreach ($modelList as $key => $val):
			echo $this->render('//publicView/answer/_new_answer_question_list_details', array('no' => $key + 1, 'val' => $val));
		endforeach;
		?>

	</ul>
	<div class="page">
		<?php
		echo CLinkPagerExt::widget(
			array(
				'pagination' => $pages,
				'updateId' => '#answerPage',
				'maxButtonCount' => 8,
				'showjump' => true
			)
		)
		?>
	</div>
</div>

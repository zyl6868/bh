<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/12/29
 * Time: 16:49
 */

use yii\helpers\Url;

/** @var common\models\pos\SeAnswerQuestion $val */

?>
<script type="text/javascript">
	$(function () {
		var aqId = <?php echo $val->aqID;?>;
		$(document).ready(function () {
			$.get('<?php echo Url::to(["/answernew/also-ask-head"])?>', {aqId: aqId}, function (data) {
				$('.AlsoAsk_head' + aqId).append().html(data);
			});
		});
	});
</script>
<span class="askerList AlsoAsk_head<?php echo $val->aqID ?> head_card samequestion">
</span>

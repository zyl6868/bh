<?php

use yii\helpers\Url;

?>
<ul class="main_left">
	<a href="<?php echo Url::to(["/student/message/notice"]) ?>">
		<li class="font_c <?php echo $this->context->highLightUrl('student/message/notice') ? 'select' : '' ?>">
			学校通知
		</li>
	</a>
	<a href="<?php echo Url::to(["/student/message/sys-msg"]) ?>">
		<li class="font_c <?php echo $this->context->highLightUrl('student/message/sys-msg') ? 'select' : '' ?>">
			提醒消息
		</li>
	</a>
</ul>


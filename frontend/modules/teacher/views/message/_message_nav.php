<?php

use yii\helpers\Url;

?>
<ul class="main_left">
	<a href="<?php echo Url::to(["/teacher/message/receiver"])?>"><li class="font_c <?php echo $this->context->highLightUrl(['teacher/message/receiver','teacher/message/msg-contact']) ? 'select' : '' ?>">
		学校通知
	</li></a>
	<a href="<?php echo Url::to(["/teacher/message/notice"])?>"><li class="font_c <?php echo $this->context->highLightUrl('teacher/message/notice') ? 'select' : '' ?>">
		班海消息
	</li></a>
    <a href="<?php echo Url::to(["/teacher/message/quality-work"])?>"><li class="font_c <?php echo $this->context->highLightUrl('teacher/message/quality-work') ? 'select' : '' ?>">
        精品作业
    </li></a>
</ul>


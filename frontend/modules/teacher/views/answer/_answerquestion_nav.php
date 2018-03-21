<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/7/27
 * Time: 16:45
 */
use yii\helpers\Url;

?>
<ul id="tabLis" class="tabLis clearfix">
	<li data-id="1" id="upload1">
		<a href="<?php echo Url::to(["/teacher/answer/my-questions"]); ?>"
		   class="<?php echo $this->context->highLightUrl(['teacher/answer/my-questions']) ? 'ac' : '' ?>">我的提问</a>
	</li>
	<li data-id="2" id="upload2">
		<a href="<?php echo Url::to(["/teacher/answer/my-answer"]); ?>"
		   class="<?php echo $this->context->highLightUrl(['teacher/answer/my-answer']) ? 'ac' : '' ?>">我的回答</a>
	</li>
</ul>
<a href="javascript:;" id="i_askBtn" type="button" class="tab-btn myQuestion">我要提问</a>

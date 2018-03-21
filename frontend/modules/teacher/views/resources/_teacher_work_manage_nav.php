<?php
/**
 * 教师作业 左部菜单
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/30
 * Time: 14:12
 */
use yii\helpers\Url;

?>
<ul class="custom_groups">
	<li class="collection">
		<a href="<?php echo Url::to(["/teacher/resources/collect-work-manage","department" => $department, "subjectId" => $subjectId])?>"
		    class="<?php echo $this->context->highLightUrl('teacher/resources/collect-work-manage') ? 'ac' : '' ?>">
			<i></i>我的收藏
		</a>
	</li>
	<li class="establish">
		<a href="<?php echo Url::to(["/teacher/resources/my-create-work-manage","department" => $department, "subjectId" => $subjectId])?>"
		   class="<?php echo $this->context->highLightUrl('teacher/resources/my-create-work-manage') ? 'ac' : '' ?>">
		   <i></i>我的创建
		</a>
	</li>
</ul>


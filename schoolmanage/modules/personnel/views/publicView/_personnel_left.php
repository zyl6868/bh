<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/2
 * Time: 12:03
 */
use yii\helpers\Url;

?>
<div class="asideItem">
	<ul class="left_menu">
		<li>
			<a class="<?php echo $this->context->highLightUrl(['personnel/teacher/index']) ? 'cur' : ''?>" href="<?php echo Url::to("/personnel/teacher/index")?>">教师管理</a>
		</li>
		<li><a class="<?php echo $this->context->highLightUrl(['personnel/student/index','personnel/student/no-class-students']) ? 'cur' : ''?>" href="<?php echo Url::to("/personnel/student/index")?>">学生管理</a></li>
	</ul>
</div>

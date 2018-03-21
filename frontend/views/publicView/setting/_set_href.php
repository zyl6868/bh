<?php
/**
 * Created by PhpStorm.
 * User: gaoli_000
 * Date: 2015/6/3
 * Time: 11:45
 */
?>
<ul id="tabList" class="tabList clearfix">
	<?php if (loginUser()->isTeacher()) { ?>
		<li data-id="1" id="upload0">
			<a href="<?php echo url('teacher/setting/basic-information') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['teacher/setting/basic-information','teacher/setting/teacher-edit-basic-information']) ? 'ac' : '' ?>">基本信息</a>
		</li>
		<li data-id="1" id="upload1">
			<a href="<?php echo url('teacher/setting/set-head-pic') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['teacher/setting/set-head-pic']) ? 'ac' : '' ?>">修改头像</a>
		</li>
		<li data-id="2" id="upload2">
			<a href="<?php echo url('teacher/setting/change-password') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['teacher/setting/change-password']) ? 'ac' : '' ?>">修改密码</a>
		</li>
		<li data-id="3" id="upload3">
			<a href="<?php echo url('teacher/setting/change-class') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['teacher/setting/change-class']) ? 'ac' : '' ?>">修改任教班级</a>
		</li>
	<?php } elseif (loginUser()->isStudent()) { ?>
		<li data-id="1" id="upload0">
			<a href="<?php echo url('student/setting/basic-information') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['student/setting/basic-information','student/setting/student-edit-basic-information']) ? 'ac' : '' ?>">基本信息</a>
		</li>
		<li data-id="1" id="upload1">
			<a href="<?php echo url('student/setting/set-head-pic') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['student/setting/set-head-pic']) ? 'ac' : '' ?>">修改头像</a>
		</li>
		<li data-id="2" id="upload2">
			<a href="<?php echo url('student/setting/change-password') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['student/setting/change-password']) ? 'ac' : '' ?>">修改密码</a>
		</li>
		<li data-id="3" id="upload3">
			<a href="<?php echo url('student/setting/change-class') ?>"
			   class="tc <?php echo $this->context->highLightUrl(['student/setting/change-class']) ? 'ac' : '' ?>">修改班级</a>
		</li>
	<?php } ?>
</ul>
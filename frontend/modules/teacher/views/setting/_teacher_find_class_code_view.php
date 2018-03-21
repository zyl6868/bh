<?php
/**
 * 查找班级 输入邀请码页面片段
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/17
 * Time: 10:30
 */
?>

<div id="content">
	请输入班级八位邀请码: <input type="text" id="find_text">
	<input type="button" id="find_class" class="tc" value="查找班级">
</div>
<p id="wait"></p>

<div id="class_content" class="hide">
	<h4></h4>

	<p class="clearfix">
		学校:
		<span></span>
		<a href="javascript:;" id="mix" class="tc join_class">加入</a>
	</p>

	<p>班主任:<span></span></p>
</div>

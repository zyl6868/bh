<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/16
 * Time: 16:23
 */
?>
<h4>学生信息</h4>
<div>
	<div class="lable">
		<label for="stu_ID_again">学号：</label>
	</div>
	<input id="stu_ID_again" name="stu_ID_again" type="text"
	       data-validation-engine="validate[custom[onlyLetterNumber],maxSize[20]]"/>
	<br>

	<div class="lable">
		<label for="stu_name_again"><i class="req">*</i>姓名：</label>
	</div>
	<input id="stu_name_again" name="stu_name_again" type="text" class="read_only user_select_"
	       data-validation-engine="validate[required,minSize[2],maxSize[20]]"
	       data-errormessage-value-missing="用户名不能为空"
	       value="<?= $trueName ?>"
	/><br>

	<div class="lable">
		<label for="stu_mol_again"><i class="req read_only">*</i>手机号：</label>
	</div>
	<input id="stu_mol_again" name="stu_mol" type="text" class="user_select_"
	       data-validation-engine="validate[required,custom[phone]]"
	       data-errormessage-value-missing="手机号不能为空"
	       value="<?= $bindphone ?>"
	/><br>

	<div class="lable">
		<label>性别：</label>
	</div>
	<label for="male_again"></label>
	<input type="radio" name="sex" id="male_again" class="read_only" value="1"/>&nbsp;男
	<label for="female_again"></label>
	<input type="radio" name="sex" id="female_again" class="read_only" value="2"/>&nbsp;女<br>

	<div class="lable">
		<label for="phoneReg"><i class="req">*</i>帐号：</label>
	</div>
	<input type="text" class="read_only user_select_"
	       data-validation-engine="validate[required,minSize[2],maxSize[20]]"
	       data-errormessage-value-missing="账号不能为空"
	       id="phoneReg"
	       value="<?= $phoneReg ?>" style="border: 0px;background:#ffffff"
	/>
	<ul>
		<li class="posit">提示:&nbsp;</li>
		<li>
			1.新创建的学生帐号为:<?= $phoneReg ?>。<br>
			2.新创建的学生帐号的初始密码为:123456。
		</li>
	</ul>
</div>

<div class="btn_class">
	<button class="alter btn" id="return_up" type="button">上一步</button>
	<button class="btn" id="submit_new" type="button">确定</button>
</div>
<script>
	$('#edit_user_info_form_again').validationEngine();
</script>
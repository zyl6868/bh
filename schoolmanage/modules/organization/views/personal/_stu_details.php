<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/16
 * Time: 10:40
 */
/** @var common\models\pos\SeUserinfo $userDetails */
?>
<h4>学生信息</h4>
<div>
	<div class="lable">
		<label for="stu_ID_again">学号：</label>
	</div>

	<input id="stu_ID_again" name="stu_ID_again" type="text"  data-validation-engine="validate[custom[onlyLetterNumber],maxSize[20]]"/>
	<br>

	<div class="lable">
		<label for="stu_name_again"><i class="req">*</i>姓名：</label>
	</div>
	<input id="stu_name_again" name="stu_name_again" type="text" class="read_only user_select_"
	       value="<?php echo $userDetails->trueName ?>"/><br>

	<div class="lable">
		<label for="stu_mol_again"><i class="req read_only">*</i>手机号：</label>
	</div>
	<input id="stu_mol_again" name="stu_mol" type="text" class="user_select_"
	       value="<?= $userDetails->bindphone ?>"/><br>

	<div class="lable">
		<label>性别：</label>
	</div>
	<label for="male_again"></label>
	<input type="radio" name="sex" id="male_again" class="read_only" value='1' <?php if ($userDetails->sex == 1) {
		echo "checked='checked'";
	} ?>/>&nbsp;男
	<label for="female_again"></label>
	<input type="radio" name="sex" id="female_again" value="2" class="read_only" <?php
	if ($userDetails->sex == 2) {
		echo "checked='checked'";
	}
	?>/>&nbsp;女<br>

	<div class="lable">
		<label for="phoneReg">帐号：</label>
	</div>
	<input type="text" class="read_only user_select_" id="phoneReg" value="<?= $userDetails->phoneReg ?>"/>

</div>
<?php if ($userDetails->phone != null) { ?>
	<h4>学生家长信息</h4>
	<div id="parent_message" class="parent_message">
		<div class="lable">
			<label for="parent_ID">家长姓名：</label>
		</div>
		<input id="parent_ID" name="parent_ID" type="text" class="user_select_" value="<?= $userDetails->parentsName ?>"
		       data-validation-engine="validate[maxSize[20]]"/><br>

		<div class="lable">
			<label for="parent_mol"><i class="req">*</i>手机号：</label>
		</div>
		<input id="parent_mol" name="parent_mol" type="text" class="user_select_"
		       value="<?= $userDetails->phone ?>"/><br>
	</div>
<?php } ?>
<div class="btn_class">
	<button class="alter btn" id="return_up" type="button">上一步</button>
	<button class="btn" id="submit_update" type="button">确定</button>
</div>
<script>
	$('#edit_user_info_form_again').validationEngine();
</script>
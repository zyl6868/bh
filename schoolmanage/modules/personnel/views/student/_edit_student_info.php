<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/4
 * Time: 14:01
 */
use common\models\dicmodels\SchoolLevelModel;

?>
<?php $form = \yii\widgets\ActiveForm::begin(array(
	'enableClientScript' => false,
	'id' => "edit_user_info_form",
	'method' => 'post'
)) ?>
	<div class="popCont">
		<div class="new_sch_con">
			<?php if (!empty($classMembers)) { ?>
				<dl class="row clearfix">
					<dt><em>*</em>学号：</dt>
					<dd>
						<input type="text" id="stu_number"
						       class="input_txt validate[required,minSize[1],maxSize[20]] "
						       name="<?php echo $stuInfo["stuID"]; ?>"
						       value="<?php echo $stuInfo["stuID"]; ?>"
						       data-validation-engine="validate[required,minSize[1],maxSize[20]]" ,
						       data-errormessage-value-missing="请填写学号">
					</dd>
				</dl>
			<?php } ?>
			<dl class="row clearfix">
				<dt><em>*</em>姓名：</dt>
				<dd>
					<input type="text" id="stu_name"
					       class="input_txt validate[required,minSize[2],maxSize[20],chinese] "
					       name="<?php echo $stuInfo["trueName"]; ?>"
					       value="<?php echo $stuInfo["trueName"]; ?>"
					       data-validation-engine="validate[required,minSize[2],maxSize[20],chinese]" ,
					       data-errormessage-value-missing="请填写真实姓名">
				</dd>
			</dl>
			<dl class="row clearfix">
				<dt><em>*</em>手机号：</dt>
				<dd><?php
					if (empty($stuInfo["bindphone"])) {
						echo "<em style='color: red'>未填写</em>";
					} else {
						echo $stuInfo["bindphone"];
					} ?></dd>
			</dl>
			<dl class="row clearfix">
				<dt><em>*</em>性别：</dt>
				<dd>
					<label>
						<input type="radio" class="radio validate[required]" name="sex"
						       value="0" <?php if ($stuInfo["sex"] == 0) {
							echo "checked='checked'";
						} ?>>保密
					</label>
					&nbsp;&nbsp;&nbsp;
					<label>
						<input type="radio" class="radio validate[required]" name="sex"
						       value="1" <?php if ($stuInfo["sex"] == 1) {
							echo "checked='checked'";
						} ?>>男
					</label>
					&nbsp;&nbsp;&nbsp;
					<label>
						<input type="radio" class="radio validate[required]" name="sex"
						       value="2" <?php if ($stuInfo["sex"] == 2) {
							echo "checked='checked'";
						} ?>>女
					</label>
				</dd>
			</dl>
			<dl class="row clearfix">
				<dt><em>*</em>学段：</dt>
				<dd>
					<?php echo SchoolLevelModel::model()->getName($stuInfo['department']); ?>
				</dd>
			</dl>
			<dl class="row clearfix">
				<dt><em>*</em>班级：</dt>
				<dd><?php echo empty($classMembers) ? '暂无班级' : \common\components\WebDataCache::getClassesNameByClassId($stuInfo["classID"]); ?></dd>
			</dl>
			<?php if (!empty($stuInfo["phone"]) || !empty($stuInfo["parentsName"])) { ?>
				<h5 style="height: 30px; line-height: 30px; font-size: 16px;background:#f5f5f5; text-indent: 10px;margin-bottom: 30px">
					学生家长信息</h5>
				<dl class="row clearfix">
					<dt>家长姓名：</dt>
					<dd>
						<?= $stuInfo["parentsName"] ?>
						<span id="parentsName_prompt" class="errorTxt" style="left:376px"></span>
					</dd>
				</dl>
				<dl class="row clearfix">
					<dt>手机号：</dt>
					<dd><?php echo $stuInfo["phone"]; ?></dd>
				</dl>
			<?php } ?>
		</div>
	</div>
	<div class="popBtnArea">
		<button type="button" class="okBtn edit_info_btn" uId="<?php echo $stuInfo["userID"]; ?>"
		        pId="<?php echo $stuInfo["userID"] ?>">保存
		</button>
		<button type="button" class="cancelBtn">取消</button>
	</div>
<?php \yii\widgets\ActiveForm::end(); ?>
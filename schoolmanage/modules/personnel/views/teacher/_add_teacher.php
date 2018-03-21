<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/4
 * Time: 14:01
 */
use frontend\components\CHtmlExt;
use common\components\WebDataCache;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<?php $form = ActiveForm::begin(array(
	'enableClientScript' => false,
	'id' => "add_user_info_form",
	'method' => 'post'
)) ?>
<div class="popCont">
	<div class="new_sch_con">
		<dl class="row clearfix">
			<dt><em class="red">*</em>姓名：</dt>
			<dd>
				<input type="text"
					   id="tea_name"
					   class="input_txt validate[required,minSize[2],maxSize[20]] "
					   name="tea_name"
					   data-validation-engine="validate[required,minSize[2],maxSize[20]]"
					   data-errormessage-value-missing="用户名不能为空"
					   data-prompt-position="topLeft"
				>
			</dd>
		</dl>
		<dl class="row clearfix">
			<dt><em class="red">*</em>手机号：</dt>
			<dd>
				<input type="text"
					   id="tea_mol"
					   class="input_txt validate[required,custom[phoneNumber]] "
					   name="tea_mol"
					   data-validation-engine= "validate[required,custom[phoneNumber]]"
					   data-errormessage-value-missing="手机号不能为空"
					   data-prompt-position="topLeft"
				/>
			</dd>
		</dl>
		<dl class="row clearfix">
			<dt>性别：</dt>
			<dd>
				<label><input type="radio" class="radio" name="sex" value="0">保密</label>&nbsp;&nbsp;&nbsp;
				<label><input type="radio" class="radio" name="sex" value="1">男</label>&nbsp;&nbsp;&nbsp;
				<label><input type="radio" class="radio" name="sex" value="2">女</label>
			</dd>
		</dl>
		<dl class="row clearfix">
			<dt><em class="red">*</em>学科：</dt>
			<dd>
				<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('department'), "", SchoolLevelModel::model()->getListInData($departmentArray), array(
					'prompt' => '学段',
					'data-validation-engine' => 'validate[required]',
					"data-errormessage-value-missing"=>"请选择学段",
					"data-prompt-position"=>"topLeft",
					'data-prompt-target' => "department_prompt",
					'id' => 'department',
					'class' => "validate[required]",
					'ajax' => [
						'url' => Yii::$app->urlManager->createUrl('personnel/teacher/get-subject'),
						'data' => ['department' => new \yii\web\JsExpression('this.value')],
						'success' => 'function(html){jQuery("#' . 'subject' . '").html(html).change();}'
					],
				)) ?>
				<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('subject'), "", SubjectModel::model()->getListData(), array(
					'prompt' => '学科',
					"data-validation-engine"=>"validate[required]",
					"data-errormessage-value-missing"=>"请选择学科",
					"data-prompt-position"=>"topLeft",
					'data-prompt-target' => "grade_prompt",
					'id' => 'subject',
					'class' => "validate[required]",
					'ajax' => [
						'url' => Yii::$app->urlManager->createUrl('personnel/teacher/get-versions'),
						'data' => ['subject' => new \yii\web\JsExpression('this.value'), 'department' => new \yii\web\JsExpression("jQuery('#department').val()")],
						'success' => 'function(html){jQuery("#' . 'version' . '").html(html).change();}'
					],

				)) ?>
				<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('version'), "", EditionModel::model()->getListData(), array(
					'prompt' => '版本',
					"data-validation-engine"=>"validate[required]",
					"data-errormessage-value-missing"=>"请选择版本",
					"data-prompt-position"=>"topLeft",
					'id' => 'version',
					'class' => "validate[required]",
				)) ?>
			</dd>
		</dl>
	</div>
</div>
<div class="popBtnArea">
	<button type="button" class="okBtn add_info_btn">保存</button>
	<button type="button" class="cancelBtn">取消</button>
</div>
<?php ActiveForm::end(); ?>
<script>
	$('#add_user_info_form').validationEngine();
</script>
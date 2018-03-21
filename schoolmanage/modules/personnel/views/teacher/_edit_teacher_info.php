<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/4
 * Time: 14:01
 */
use frontend\components\CHtmlExt;
use common\components\WebDataCache;
use common\models\dicmodels\LoadTextbookVersionModel;
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var common\models\pos\SeUserinfo $teaInfo */
if(empty($teaInfo)){
	return $this->notFound("未找到该用户");
}
?>

<?php $form = ActiveForm::begin(array(
	'enableClientScript' => false,
	'id' => "edit_user_info_form",
	'method' => 'post'
)) ?>
<div class="popCont">
	<div class="new_sch_con">
		<dl class="row clearfix">
			<dt><label for="tea_name"><em>*</em>姓名：</label></dt>
			<dd>

				<input type="text"
				       id="tea_name"
				       class="input_txt validate[required,minSize[2],maxSize[20],chinese] "
				       name="<?php
				       echo $teaInfo["trueName"]; ?>"
				       value="<?php echo $teaInfo["trueName"]; ?>"
				       data-validation-engine="validate[required,minSize[2],maxSize[20],chinese]"
				       data-errormessage-value-missing="用户名不能为空"
				>
			</dd>

		</dl>

		<dl class="row clearfix">
			<dt><em>*</em>手机号：</dt>
			<dd><?php echo $teaInfo["bindphone"] ?></dd>
		</dl>
		<dl class="row clearfix">
			<dt><em>*</em>性别：</dt>
			<dd>
				<label>
					<input type="radio" class="radio validate[required]" name="sex"
					       value="0" <?php if ($teaInfo["sex"] == 0) {
						echo "checked='checked'";
					} ?>>保密
				</label>
				<label>
					<input type="radio" class="radio validate[required]" name="sex"
					       value="1" <?php if ($teaInfo["sex"] == 1) {
						echo "checked='checked'";
					} ?>>男
				</label>
				&nbsp;&nbsp;&nbsp;
				<label>
					<input type="radio" class="radio validate[required]" name="sex"
					       value="2" <?php if ($teaInfo["sex"] == 2) {
						echo "checked='checked'";
					} ?>>女
				</label>
			</dd>
		</dl>
		<dl class="row clearfix">
			<dt><em>*</em>学段：</dt>
			<dd>
				<?php echo SchoolLevelModel::model()->getName($teaInfo["department"]); ?>

			</dd>
		</dl>
		<dl class="row clearfix">
			<dt><em>*</em>学科：</dt>
			<dd>

				<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('subject'), $teaInfo["subjectID"], SubjectModel::model()->getSubjectByDepartmentListData($teaInfo["department"]), array(
					'prompt' => '请选择',
					"data-validation-engine" => "validate[required]",
					"data-errormessage-value-missing" => "请选择学科",
					'id' => 'subject',
					'class' => "validate[required]",
					'ajax' => [
						'url' => Yii::$app->urlManager->createUrl('personnel/teacher/get-versions'),
						'data' => ['subject' => new \yii\web\JsExpression('this.value'), "department" => $teaInfo["department"]],
						'success' => 'function(html){jQuery("#' . 'version' . '").html(html).change();}'
					],
				)) ?>
				&nbsp;&nbsp;
				<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('version'), $teaInfo["textbookVersion"], LoadTextbookVersionModel::model($teaInfo["subjectID"], null, $teaInfo["department"])->getListData(), array(
					'prompt' => '请选择版本',
					'id' => 'version',
					"data-validation-engine" => "validate[required]",
					"data-errormessage-value-missing" => "请选择版本",
						'class' => "validate[required]",
				)) ?>
			</dd>
		</dl>
		<dl class="row clearfix">
			<dt>任教班级：</dt>
			<dd>
				<span>
					<?php
					if (!empty($classMem)) {
						foreach ($classMem as $item) {
							echo WebDataCache::getClassesNameByClassId($item->classID) . "&nbsp;&nbsp;";
						}
					} else {
						echo "<em style='color: red'>未设置班级</em>";
					} ?>
				</span>
			</dd>
		</dl>
	</div>
</div>
<div class="popBtnArea">
	<button type="button" class="okBtn edit_info_btn" uId="<?php echo $teaInfo["userID"]; ?>">保存</button>
	<button type="button" class="cancelBtn">取消</button>
</div>
<?php ActiveForm::end(); ?>

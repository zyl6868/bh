<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/3
 * Time: 10:38
 */
use frontend\components\CHtmlExt;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = "个人设置-修改密码";
$this->blocks['requireModule'] = 'app/personal_settings/upload_Pic';

$backend_asset = BH_CDN_RES.'/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile($backend_asset . '/js/lib/jquery.validationEngine.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile($backend_asset . '/js/lib/jquery.validationEngine_zh_CN.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile( $backend_asset . '/js/module/register.js'. RESOURCES_VER, ['position' => View::POS_HEAD]);

/** @var frontend\models\EditPasswordForm $model */
?>
<?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
	<script type="text/javascript">
		$(function(){
			require(['popBox','jquery_sanhai'],function(popBox) {
				popBox.successBox('<?php echo Yii::$app->getSession()->getFlash('success'); ?>');
			});
		});

	</script>
<?php } ?>
<!--主体-->
<div class="cont24 " id="requireModule" rel="app/personal_settings/upload_Pic" data-script="upload_Pic">
	<div class="grid24 main">
		<div class="grid_19 main_r">
			<div class="main_cont userSetup change_pwd">
				<div class="tab">
					<?php echo $this->render('//publicView/setting/_set_href'); ?>
					<div class="tabCont">
						<?php $form = ActiveForm::begin( array(
								'enableClientScript' => false,
						))?>
						<div class="form_list">
							<div class="row clearfix">
								<div class="formL">
									<label for="editpasswordform-oldpasswd"><i class="red">*</i> 旧密码：</label>
								</div>
								<div class="formR">
									<label>
										<input style="display:none">
									</label>
									<input type="password"
									       autocomplete="off"
									       class="text w310"
									       id="<?php echo Html::getInputId($model, 'oldpasswd') ?>"
									       name="<?php echo Html::getInputName($model,'oldpasswd')?>"
									       data-validation-engine="validate[required,minSize[6],maxSize[20]]"
									       data-prompt-position="topLeft"
									       data-prompt-target="oldError"


									       title=""/>
									<?php echo CHtmlExt::validationEngineError($model, 'oldpasswd') ?>


								</div>
							</div>
							<div class="row clearfix">
								<div class="formL">
									<label for="editpasswordform-passwd"><i class="red">*</i> 新密码：</label>
								</div>
								<div class="formR">
									<input type="password"
									       class="text w310"
									       name="<?php echo  Html::getInputName($model,'passwd')?>"
									       id="<?php echo Html::getInputId($model, 'passwd') ?>"
									       data-validation-engine="validate[required,minSize[6],maxSize[20]]"
									       data-prompt-position="topLeft"
									       data-prompt-target="newError" title=""/>
									<?php echo CHtmlExt::validationEngineError($model, 'passwd') ?>


								</div>
							</div>
							<div class="row clearfix">
								<div class="formL">
									<label><i class="red" style="margin-right:3px;">*</i>确认新密码：</label>
								</div>
								<div class="formR">
									<input type="password"
									       class="text w310"
									       name="<?php echo  Html::getInputName($model,'repasswd')?>"
									       data-validation-engine="validate[required,equals[<?php echo Html::getInputId($model, 'passwd') ?>]]"
									       data-prompt-position="topLeft"
									       data-prompt-target="affirmError" title=""/>
								</div>
							</div>
							<div class="row clearfix">
								<div class="formL">
									<label></label>
								</div>
								<div class="formR">
									<button type="submit" class="bg_blue btn40 w140">保存修改</button>
								</div>
							</div>
						</div>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--主体end-->


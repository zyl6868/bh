<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-9-19
 * Time: 上午11:17
 */
use yii\helpers\Html;

/* @var $this yii\web\View */  $this->title="修改邮箱";

$this->registerJsFile($publicResources . '/js/jquery.validationEngine.min.js');
$this->registerJsFile($publicResources . '/js/jquery.validationEngine-zh_CN.js');
$this->registerJsFile($publicResources . '/js/register.js');
?>
<div class="currentRight grid_22  cp_email_cl setup">
    <p>如果你的注册邮箱有误，请你修改注册邮箱为能够正常使用的邮箱，便可以享受我们的各项服务</p>

    <div class="editBox cp_box">
        <?php $form =\yii\widgets\ActiveForm::begin( array(
            'enableClientScript' => false,
        ))?>
            <ul class="form_list organization">
                <li>
                    <div class="formL">
                        <label>现有邮箱：</label>
                    </div>
                    <div class="formR">
                        <label><?php echo loginUser()->getEmail();?></label>
                    </div>
                </li>
                <li>
                    <div class="formL">
                        <label>当前密码：</label>
                    </div>
                    <div class="formR">
                        <input type="password" class="text" name=<?php echo  Html::getInputName($model,'passwd')?>"  id="<?php echo Html::getInputId($model, 'passwd') ?>"
                                   data-validation-engine="validate[required,minSize[6],maxSize[20],custom[onlyLetterNumber]]">
                        <?php echo frontend\components\CHtmlExt::validationEngineError($model, 'passwd')?>
                    </div>
                </li>
                <li>
                    <div class="formL">
                        <label>新邮箱：</label>
                    </div>
                    <div class="formR">
                        <input type="text" class="text" name=<?php echo  Html::getInputName($model,'afterEmail')?>"
                                data-validation-engine="validate[required,custom[email],ajax[ajaxEmailCall]]">
                    </div>
                </li>
                <li>
                    <div class="formL">
                        <label></label>
                    </div>
                    <div class="formR">
                    	<button  class="bg_red_d w120 save">保&nbsp;&nbsp;存</button>
                    </div>
                </li>

            </ul>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
</div>

<?php
use common\models\sanhai\SeDateDictionary;
use frontend\components\CHtmlExt;
use common\components\WebDataCache;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = "个人设置-基本信息";
$backend_asset = BH_CDN_RES.'/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->blocks['requireModule']='app/teacher/teacher_home';
?>
<?php $form = ActiveForm::begin(array(
    'enableClientScript' => false,
    'id' => "basic_information_form",
    'method' => 'post'
)) ?>
<div class="cont24">
    <div class="grid24 main">
        <!--主体-->
        <div class="grid_19 main_r">
            <div class="main_cont userSetup upload_Pic">
                <div class="tab">
                    <?php echo $this->render("//publicView/setting/_set_href") ?>
                    <div class="tabCont">
                        <div class="form_list stuMessages">

                            <div class="form_left">姓名:</div>
                            <div class="form_right"><?php echo $model -> trueName;?></div>
                            <br/>
                            <div class="form_left">手机号:</div>
                            <div class="form_right"><?php echo $model -> bindphone;?></div>
                            <br/>
                            <div class="form_left">登录名:</div>
                            <div class="form_right"><?php echo $model -> phoneReg;?></div>
                            <br/>
                            <div class="form_left">性别:</div>
                            <div id="sex_input" class=" form_right">
                                <label>
                                    <input type="radio" name="<?php echo Html::getInputName($model, 'sex') ?>" value="1" <?php echo $model->sex == 1 ? 'checked' : ''?> >
                                    <span>男</span>
                                </label>
                                <label>
                                    <input type="radio" name="<?php echo Html::getInputName($model, 'sex') ?>" value="2" style="margin-left:30px" <?php echo $model->sex == 2 ? 'checked' : ''?> >
                                    <span>女</span>
                                </label>
                            </div>
                            <br/>
                            <div class="form_left">任教学科:</div>
                            <div class="form_right">
                                <?php echo CHtmlExt::dropDownListAjax(Html::getInputName($model, 'department'), $model->department, $departmentArray, array(
                                    'prompt' => '学部',
                                    'data-validation-engine' => 'validate[required]',
                                    'data-errormessage-value-missing' => '请选择学部',
                                    'data-prompt-target' => 'department_prompt',
                                    'data-prompt-position' =>  'topLeft',
                                    'id' => Html::getInputId($model, 'department'),
                                    'ajax' => [
                                        'url' => Yii::$app->urlManager->createUrl('ajax/get-subject'),
                                        'data' => array('schoolLevel' => new \yii\web\JsExpression('this.value')),
                                        'success' => 'function(html){jQuery("#' . Html::getInputId($model, 'subjectID') . '").html(html).change();}'
                                    ],
                                )) ?>
                                <?php echo CHtmlExt::validationEngineError($model, 'department') ?>

                                <?php echo CHtmlExt::dropDownListAjax(Html::getInputName($model, 'subjectID'), $model->subjectID, $subjectArray, array(
                                    'prompt' => '科目',
                                    'data-validation-engine' => 'validate[required]',
                                    'data-prompt-target' => 'grade_prompt',
                                    'data-errormessage-value-missing' => '请选择科目',
                                    'data-prompt-position' => 'topLeft',
                                    'id' => Html::getInputId($model, 'subjectID'),
                                    'ajax' => [
                                        'url' => Yii::$app->urlManager->createUrl('ajax/get-versions'),
                                        'data' => ['subject' => new \yii\web\JsExpression('this.value'),'department'=> new \yii\web\JsExpression( 'jQuery("#'.Html::getInputId($model, "department").'").val()')],
                                        'success' => 'function(html){jQuery("#' . Html::getInputId($model, "textbookVersion") . '").html(html).change();}'
                                    ]
                                )) ?>
                                <?php echo CHtmlExt::validationEngineError($model, 'subjectID') ?>
                                &nbsp;&nbsp;
                                <?php echo CHtmlExt::dropDownListAjax(Html::getInputName($model, 'textbookVersion'), $model ->textbookVersion, $versionArray, array(
                                    'data-validation-engine' => 'validate[required]',
                                    'prompt' => '版本',
                                    'id' => Html::getInputId($model, 'textbookVersion'),
                                    'data-prompt-target' => 'textbookVersion_prompt',
                                    'data-errormessage-value-missing' => '请选择教材版本',
                                    'data-prompt-position' => 'topLeft',
                                )) ?>
                                <?php echo CHtmlExt::validationEngineError($model, 'textbookVersion') ?>
                            </div>
                            <br/>
                            <button id="save" class="save">保存</button>
                            <a href="<?php echo url('teacher/setting/basic-information') ?>" class="btn_reset">取消</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!--主体end-->
<?php
/**
 *
 * @var MakepaperController $this
 */
use frontend\components\CHtmlExt;
use frontend\components\helper\AreaHelper;
use common\models\dicmodels\GradeModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
$this->title = "试卷标题";
$backend_asset = BH_CDN_RES.'/pub';
$this->registerJsFile($backend_asset . '/js/json2.js' . RESOURCES_VER);
$this->registerJsFile($backend_asset . '/js/pubjs.js' . RESOURCES_VER,[ 'position'=> View::POS_HEAD] );

/**  @var MakePaperForm $model */

?>
<div class="grid_19 main_r ">

    <div class="main_cont  make_testpaper">
        <div class="title">
            <h4>试卷标题</h4>
        </div>

        <ul class="stepList clearfix">
            <li class="step_ac"><span>试卷标题</span><i></i></li>
            <li><span>试卷结构</span><i></i></li>
            <li><span>筛选题目</span><i></i></li>
            <li class="step_end"><span>设定分值</span><i></i></li>
        </ul>
        <br>
        <?php echo Html::beginForm('', 'post', ['id' => "makePaper"]) ?>
        <div class="form_list">
            <div class="row">
                <div class="formL">
                    <label><i>*</i>试卷名称：</label>
                </div>
                <div class="formR">
                    <input id="<?php echo Html::getInputId($model, 'paperName') ?>" type="text"
                           name="<?php echo Html::getInputName($model, 'paperName') ?>" class="text"
                           data-validation-engine="validate[required,maxSize[30]]"
                           data-prompt-target="paperName_prompt"
                           data-prompt-position="inline"
                           value="<?php echo $model->paperName; ?>">
                    <span id="paperName_prompt" class="errorTxt" style="left:200px"></span>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label><i>*</i>所在地区：</label>
                </div>
                <div class="formR">

                    <?php
                    echo CHtmlExt::dropDownListAjax(Html::getInputName($model, "provience"), $model->provience, ArrayHelper::map(AreaHelper::getProvinceList(), 'AreaID', 'AreaName'),
                        array(
                            "defaultValue" => false, "prompt" => "请选择",
                            'ajax' => array(
                                'url' => Yii::$app->urlManager->createUrl('ajax/get-area'),
                                'data' => array('id' => new \yii\web\JsExpression('this.value')),
                                'success' => 'function(html){jQuery("#' . Html::getInputId($model, "city") . '").html(html).change();}'
                            ),
                            "id" => Html::getInputId($model, "provience"),

                        ));
                    ?>
                    <?php
                    echo CHtmlExt::dropDownListAjax(Html::getInputName($model, "city"), $model->city, ArrayHelper::map(AreaHelper::getCityList($model->provience), 'AreaID', 'AreaName'), array(
                        "defaultValue" => false, "prompt" => "请选择", "id" => Html::getInputId($model, "city"),
                        'ajax' => array(
                            'url' => Yii::$app->urlManager->createUrl('ajax/get-area'),
                            'data' => array('id' => new \yii\web\JsExpression('this.value')),
                            'success' => 'function(html){jQuery("#' . Html::getInputId($model, "county") . '").html(html).change();}'
                        ),
                    ));
                    ?>
                    <?php
                    echo CHtmlExt::dropDownListAjax(Html::getInputName($model, "county"), $model->county, ArrayHelper::map(AreaHelper::getRegionList($model->city), 'AreaID', 'AreaName'),
                        array(
                            'data-validation-engine' => 'validate[required]', "defaultValue" => false, "prompt" => "请选择", "id" => Html::getInputId($model, "county"),
                            'data-prompt-target' => "county_prompt",
                            'data-prompt-position' => "inline",
                            'data-errormessage-value-missing' => "所在地不能为空",
                        )); ?>
                    <span id="county_prompt" class="errorTxt" style="left:380px"></span>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label><i>*</i>年级：</label>
                </div>
                <div class="formR">
                    <?php
                    echo CHtmlExt::activeDropDownListAjax($model, "gradeId", GradeModel::model()->getListData(),
                        array(
                            'class'=>"gradeId",
                            'data-validation-engine' => 'validate[required]', "defaultValue" => false, "prompt" => "请选择",
                            'data-prompt-target' => "grade_prompt",
                            'data-prompt-position' => "inline",
                            'data-errormessage-value-missing' => "年级不能为空",
                            'ajax' => array(
                                'url' => Yii::$app->urlManager->createUrl('ajax/get-item-for-grade'),
                                'data' => array('id' => new \yii\web\JsExpression('this.value')),
                                'success' => 'function(html){jQuery("#' . Html::getInputId($model, 'subject') . '").html(html).change();}'
                            ),
                        )); ?>
                    <span id="grade_prompt" class="errorTxt" style="left:130px"></span>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label><i>*</i>科目：</label>
                </div>
                <div class="formR">
                    <?php echo CHtmlExt::activeDropDownListAjax($model, 'subject', ArrayHelper::map(SubjectModel::getSubByGrade($model->gradeId), 'secondCode', 'secondCodeValue'),
                        [
                            'class' => 'mySel',
                            'data-validation-engine' => 'validate[required]', "defaultValue" => false,
                            "prompt" => "请选择",
                            'data-prompt-target' => "subject_prompt",
                            'data-prompt-position' => "inline",
                            'data-errormessage-value-missing' => "科目不能为空",
                            'ajax' => array(
                                'url' => Yii::$app->urlManager->createUrl('ajax/get-version'),
                                'data' => ['subject' => new JsExpression('this.value'),'prompt' => true, 'grade' => new \yii\web\JsExpression("$('#makepaperform-gradeid').val()")],
                                'success' => 'function(html){jQuery("#' . Html::getInputId($model, "version") . '").html(html).change(); $("#' . Html::getInputId($model, 'knowledgePointId') . '").val("");jQuery(".labelList.clearfix").html("")}'
                            )

                        ]) ?>

                    <span id="subject_prompt" class="errorTxt" style="left:130px"></span>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label><i>*</i>版本：</label>
                </div>
                <div class="formR">

                    <?php echo Html::activeDropDownList($model, 'version', LoadTextbookVersionModel::model($model->subject)->getListData(),
                        [
                            'data-validation-engine' => 'validate[required]', "defaultValue" => false,
                            "prompt" => "请选择",
                            'data-prompt-target' => "textbookVersion_prompt",
                            'data-prompt-position' => "inline",
                            'data-errormessage-value-missing' => "版本不能为空",
                        ]
                    );
                    ?>
                    <span id="textbookVersion_prompt" class="errorTxt" style="left:130px"></span>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label><i></i>涉及的知识点：</label>
                </div>
                <div class="formR">
                    <?php
                    echo  frontend\widgets\extree\XTree::widget(array(
                        'model' => $model,
                        'attribute' => 'knowledgePointId',
                        'options' => array(
                            'htmlOptions' => array()
                        ))) ?>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label>试卷作者：</label>
                </div>
                <div class="formR">
                    <?php echo Html::activeDropDownList($model,
                        'author',
                        ['0' => "学校", '1' => "老师"],
                        ["class" => "mySel", "defaultValue" => false, "prompt" => "请选择"]) ?>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label>试卷简介：</label>
                </div>
                <div class="formR">
                    <?php echo Html::activeTextArea($model, 'paperDescribe', ['style' => 'width:700px;', 'id' => 'paperDescribe']) ?>
                </div>
            </div>
            <div class="row">
                <div class="formL">
                    <label></label>
                </div>
                <div class="formR submitBtnBar">
                    <button type="submit" class="bg_blue btn40 w120" onclick="return checkKnowledge();">下一步</button>
                </div>
                <?php echo Html::endForm() ?>
            </div>
        </div>
    </div>
</div>

<!--知识树-->
<script>

    formValidationIni("#makePaper");
    function checkKnowledge() {
        if ($("#paperDescribe").val().length > 500) {
            popBox.errorBox('试卷简介长度不能大于500');
            return false;
        }
        return true;
    }

    var zNodes = [];

    $('.addPointBtn').live('click',function () {
        var subjectId = $("#<?php echo  Html::getInputId($model,'subject') ?>").val();
        var grade = $("#<?php echo  Html::getInputId($model,'gradeId') ?>").val();
        var url = "/ajaxteacher/get-knowledge";
        $this = $(this);
        $.post(url, {'subjectID': subjectId, 'grade': grade}, function (msg) {
            if (msg.success) {
                zNodes = msg.data;

            } else {
                zNodes = [];
            }

            popBox.pointTree(zNodes, $this);

        });
    })
</script>

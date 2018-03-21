<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/27
 * Time: 11:48
 */

/**
 *
 * @var ManagepaperController $this
 */
use frontend\components\CHtmlExt;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\GradeModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */  $this->title='上传试卷';
$backend_asset = BH_CDN_RES.'/static';

$this->registerCssFile($backend_asset . '/css/teacher_Upload_testPaper.css');
$this->registerCssFile($backend_asset . '/css/sUI.css');
$this->blocks['requireModule'] = 'app/teacher/teacher_home_upload';
?>
<script>
    $(function () {
        var zNodes = [];
        $('.addPointBtn').click(function () {
            var subjectId = $("#<?php echo  Html::getInputId($model,'subjectID') ?>").val();
            if(subjectId ==""){
                require(['popBox'],function(popBox) {
                    popBox.alertBox('科目不能为空！');
                });
                return false;
            }
            var grade = $("#paperform-gradeid").val();
            if(grade ==""){
                require(['popBox'],function(popBox) {
                    popBox.alertBox('年级不能为空！');
                });
                return false;
            }
            var url = "/ajaxteacher/get-knowledge";
            $this = $(this);
            $.post(url, {'subjectID': subjectId, 'grade': grade}, function (msg) {
                if (msg.success) {
                    zNodes = msg.data;

                } else {
                    zNodes = [];
                }
                require(['popBox'],function(popBox) {
                    popBox.pointTree(zNodes, $this);
                });
            });
        });
        $('#PaperForm_subjectID,#PaperForm_gradeID').change(function(){
            $('.clsTreeBox').empty();
            $('.labelList').empty();
        });
    });

</script>

<div id="main" class="main">
    <h3 id="main_top" class="tc bg_fff main_top"><a href="javascript:;" onclick="window.history.go(-1);" class="btn fl icoBtn_back btn"><i></i>返回</a><span style="display: inline-block;margin-left:-75px;">上传试卷</span></h3>
    <div id="main_bottom" class="bg_fff form_list main_bottom">

        <?php $form =\yii\widgets\ActiveForm::begin( array(
            'enableClientScript' => false,
            'id' => 'form1'
        ))?>
        <div class="row clearfix">
            <div class="formL">
                <label><i class="red">*</i>试卷名称：</label>
            </div>
            <div class="formR" style="position:relative">
                <input type="text" class="text inputbox-success" placeholder="请输入试卷名称" style="width:518px;"
                       data-prompt-target="department_prompt"
                       id="<?php echo Html::getInputId($model, 'paperName')?>"
                       name="<?php echo Html::getInputName($model, 'paperName')?>"
                       data-validation-engine="validate[required,maxSize[30]]"
                />
                <span id="department_prompt" style="left: 610px" class="errorTxt fr"></span>
                <?php echo frontend\components\CHtmlExt::validationEngineError($model, 'paperName') ?>
                <span class="gray">(30字以内)</span>
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label><i class="red">*</i>年级：</label>
            </div>
            <div class="formR" style="position:relative;">
                <?php echo CHtmlExt::dropDownListAjax(Html::getInputName($model, 'gradeID'), $model->gradeID, GradeModel::model()->getListData(), array(
                    'prompt' => '请选择', 'data-validation-engine' => 'validate[required]',
                    'id' => Html::getInputId($model, 'gradeID'),
                    'class' => 'mg_t',
                    'ajax' => [
                        'url' => Yii::$app->urlManager->createUrl('ajax/get-item-for-grade'),
                        'data' => ['id' => new \yii\web\JsExpression('this.value')],
                        'success' => 'function(html){jQuery("#' . Html::getInputId($model, 'subjectID') . '").html(html).change();}'
                    ],

                ))?>
                <?php echo frontend\components\CHtmlExt::validationEngineError($model, 'gradeID') ?>
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label><i class="red">*</i>科目：</label>
            </div>
            <div class="formR" style="position: relative">
                <?php echo CHtmlExt::dropDownListAjax(Html::getInputName($model, 'subjectID'), $model->subjectID, SubjectModel::model()->getListData(), array(
                    'prompt' => '请选择', 'data-validation-engine' => 'validate[required]',
                    'id' => Html::getInputId($model, 'subjectID'),
                    'ajax' => [
                        'url' => Yii::$app->urlManager->createUrl('ajax/get-version'),
                        'data' => ['subject' => new \yii\web\JsExpression('this.value'),'prompt' => true,
                            'grade' => new \yii\web\JsExpression("$('#paperform-gradeid').val()")],
                        'success' => 'function(html){jQuery("#' . Html::getInputId($model, "versionID") . '").html(html).change();}'
                    ]
                ))?>
                <?php echo frontend\components\CHtmlExt::validationEngineError($model, 'subjectID') ?>
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label><i class="red">*</i>教材版本：</label>
            </div>
            <div class="formR"style="position: relative">
                <?php echo CHtmlExt::dropDownListAjax(Html::getInputName($model, 'versionID'), $model->versionID, EditionModel::model()->getListData(), array(
                    'prompt' => '请选择',
                    'data-validation-engine' => 'validate[required]',
                    'id' => Html::getInputId($model, 'versionID')
                ))?>
                <?php echo frontend\components\CHtmlExt::validationEngineError($model, 'versionID') ?>
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label>选择知识点：</label>
            </div>
            <div class="formR">
                <div id="tree_0" class="treeParent">
                    <?php echo  frontend\widgets\extree\XTree::widget([
                        'model' => $model,
                        'attribute' => 'knowledgePoint',
                        'options' => [
                            'htmlOptions' => []
                        ]]);?>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label><i class="red">*</i>上传试卷：</label>
                <span class="add_pic">最多可添加6张图片,每张图片最大4M，图片格式为：jpg,png</span>
            </div>
            <div class="formR imgsup">
                <div class="imgFile">
                    <ul class="up_test_list clearfix">
                            <li class="more disabled" style="position:relative;">
                                <label for="fileupload"><span id="label_fileupload" class="label_fileupload">添加图片</span></label></li>
                        <?php
                        $t1 = new frontend\widgets\xupload\models\XUploadForm;
                        echo  \frontend\widgets\xupload\XUploadRequire::widget( array(
                            'url' => Yii::$app->urlManager->createUrl("upload/pic"),
                            'model' => $t1,
                            'attribute' => 'file',
                            'autoUpload' => true,
                            'multiple' => true,
                            'options' => array(
                                'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png)$/i'),
                                'maxFileSize' => 4*1024*1024,
                                "done" => new \yii\web\JsExpression('done'),
                                "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}}')
                            ),
                            'htmlOptions' => array(
                                'id' => 'fileupload',
                            )
                        ));
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="formL">
                <label>试卷介绍：</label>
            </div>
            <div class="formR" style="position: relative">

                    <textarea name="<?php echo Html::getInputName($model, 'summary') ?>"
                              data-validation-engine="validate[maxSize[100]]"
                              data-prompt-target="describe_prompt"
                              data-prompt-position="inline"
                              style="width: 700px;;"
                    ></textarea>
                <span id="describe_prompt" class="errorTxt" style="left: 715px;top: 65px;"></span>
            </div>
        </div>
        <div class="row">
            <div class="formL">
                <label></label>
            </div>
            <div class=" submitBtnBar">
                <button type="submit" class="bg_blue btn40" >确定</button>
            </div>
        </div>
        <?php \yii\widgets\ActiveForm::end()?>

    </div>
</div>

<script>
    done = function(e, data) {
        $.each(data.result, function (index, file) {

            if(file.error){
                require(['popBox'],function(popBox) {
                    popBox.errorBox(file.error);
                });
                return false;
            }
            var liSize=$('.imgFile').find('.pic_list').size();
            if(liSize>=6){
                require(['popBox'],function(popBox){
                    popBox.errorBox('最多上传6张图片');
                });
                return false;
            }
            $('<li class="pic_list"><input type="hidden" class="imgUrl" name="picurls[]" value="' + file.url + '" /> <img src="' + file.url + '" alt=""><span class="delBtn"></span></li>').insertBefore(".more");
            var liSize=$('.imgFile').find('.pic_list').size();
            if(liSize>=6){
                $('.more').hide();
            }
        });
        require(['app/teacher/teacher_home_upload'],function(teacher_home_upload){
            teacher_home_upload.leftPicCal();
        });
    };



</script>
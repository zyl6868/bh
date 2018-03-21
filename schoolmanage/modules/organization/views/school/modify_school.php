<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/9/27
 * Time: 17:06
 */

use yii\helpers\Url;

$this->title = "组织管理-学校编辑";
$this->registerCssFile(BH_CDN_RES.'/static/css/class_mag.css'.RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES.'/static/css/sch_introduction_edit.css'.RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/require.js'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES.'/static/js/jquery.js'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
?>
<?php $form =\yii\widgets\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id'=>'schoolbrief']]) ?>
<div class="cont24" style="min-height: 780px;">
    <div class="info">
        <div class="sch_logo clearfix" id="logoUrl">
            <?= $form->field($seSchoolInfoModel, 'logoUrl')->fileInput() ?>
            <?php
            if(!empty($logoUrl)) {

                ?>
            <div class="img_logo">
                <img class="sch_logo" src="<?php echo $logoUrl ?>" alt="">
            </div>
            <?php }; ?>
        </div>
    </div>
    <div class="info">
        <div class="editinfobox clearfix">
            <div class="formL">
                <label>学校介绍：</label>
            </div>
            <div class="textareaBox" style="width:1085px;height: auto;"> <?php
                echo \schoolmanage\widgets\ueditor\MiniUEditor::widget(
                    array(
                        'id' => 'editor',
                        'model' => $seSchoolSummaryModel,
                        'attribute' => 'brief',
                        'UEDITOR_CONFIG' => array(
                        ),

                    ));
                ?>
            </div>
        </div>
        <div class="btns clearfix popBox">
            <button type="button" class="save okBtn edit_info_btn" id="BtnSa">保存</button>
            <a href="<?= Url::to(['index']) ?>" class="cancle cancelBtn" id="BtnCan">取消</a>
        </div>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>

<script>
    require(['popBox','jquery_sanhai','jqueryUI'], function (popBox) {
        $('#BtnSa').click(function(){
            var count = UE.getEditor('editor').getContentLength(true);
            if(count>10000){
                popBox.errorBox("你输入的字符个数已经超出最大允许值！");
                return;
            }
            var brief=$('[name="SeSchoolSummary[brief]"]').val();
            if($.trim(brief)==''){
                popBox.errorBox('学校介绍不许为空！');
                return false;
            }else{
                setTimeout(function(){
                    $form = $('#schoolbrief');
                    $form.attr('method', 'post').attr("action", "<?php echo app()->request->url?>").submit();
                },1000);
                popBox.successBox('学校介绍保存成功，请等待审核！');
            }
        });
    });
</script>








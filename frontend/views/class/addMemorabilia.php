<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/5
 * Time: 14:24
 */
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile(publicResources().'/static/js/lib/My97DatePicker/WdatePicker.js');
$this->title='新建大事记';
$this->blocks['requireModule']='app/classes/classes_memorabilia_modify';
?>
<div class="main col1200 add_memorabilia clearfix" id="requireModule" rel="app/classes/classes_memorabilia_modify">

    <div class="container">
       <a id="addmemor_btn"  class="btn bg_gray icoBtn_back  return_btn" href="<?php echo url::to(['/class/memorabilia','classId'=>$classId])?>"><i></i>返回</a>
        <?php $form =\yii\widgets\ActiveForm::begin( array(
            'enableClientScript' => false,
            'id' => "event_form",
            'method'=>'post'
        )) ?>
        <div class="pd25">
            <div class="new_tch_group add_memor_popbox">

                    <div class="sUI_formList">
                        <div class="row">
                            <div class="form_l">
                                <b>*</b>事记标题:
                            </div>
                            <div class="form_r">
                                <input id="memor_name" type="text" name="<?php echo Html::getInputName($eventModel, 'name') ?>"  class="text validate[required,maxSize[30]]" data-prompt-position="topLeft"  style="width:75%">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form_l">
                                <b>*</b>时间:
                            </div>
                            <div class="form_r">
                                <input type="text" type="text"  value="<?=date('Y-m-d')?>" name="<?php echo Html::getInputName($eventModel, 'time') ?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'<?php echo date('Y-m-d h:i:s',time())?>'})"  class="text validate[required]" data-prompt-position="topLeft"   >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form_l">
                                事记描述:
                            </div>
                            <div class="form_r">
                                <textarea style="width:75%; height:120px"  class="text validate[maxSize[1000]]"  name="SeClassEvent[briefOfEvent]" ></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form_l">
                                添加图片:
                            </div>
                            <div class="form_r">

                                <h5 class="fl add_pic">最多可添加20张图片,每张图片最大4兆，图片格式为：jpg,png</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form_l"></div>
                            <div class="form_r">
                                <div class="upImgFile">
                                    <ul class="clearfix picList">
                                        <li class="uploadFile disabled"><a href="javascript:;" class="uploadFileBtn">
                                                <i></i>
                                                还可以添加<span></span>张图片

                                                <?php
                                                $t1 = new frontend\widgets\xupload\models\XUploadForm;
                                                /** @var $this BaseController */
                                                echo  \frontend\widgets\xupload\XUploadRequire::widget( array(
                                                    'url' => Yii::$app->urlManager->createUrl("upload/pic"),
                                                    'model' => $t1,
                                                    'attribute' => 'file',
                                                    'autoUpload' => true,
                                                    'multiple' => true,
                                                    'options' => array(
                                                        'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
                                                        'maxFileSize' => 4*1024*1024,
                                                        "done" => new \yii\web\JsExpression('done'),
                                                        "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}}')
                                                    ),
                                                    'htmlOptions' => array(
                                                        'id' => 'fileupload',
                                                    )
                                                ));
                                                ?>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="popBtnArea add_popBtnArea">
                <input  class="btn okBtn bg_blue" type="submit" style=" width:80px" value="确定">

            </div>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
</div>
<script>
    done = function(e, data) {
        $.each(data.result, function (index, file) {
            if(file.error){
                require(['popBox'],function(popBox){
                    popBox.errorBox(file.error);
                });
                return ;
            }
            var liSize=$('.upImgFile').find('li').size();
            if(liSize>=21){
                require(['popBox'],function(popBox){
                    popBox.errorBox('最多传20张图片');
                });
                return false;
            }
            $('<li class="addImg"><input type="hidden" name="SeClassEvent[image][]" value="'+file.url+'"><img src="'+file.url+'" alt=""><span class="delBtn"></span></li>').insertBefore('.uploadFile');

        });
       require(['app/classes/classes_memorabilia_modify'],function(classes_modify){
           classes_modify.leftPicCal();
       });

    };
    window.onbeforeunload=function (){
       event.returnValue = "";
    }

</script>

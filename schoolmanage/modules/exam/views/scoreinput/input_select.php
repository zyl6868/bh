<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/16
 * Time: 10:17
 */
use frontend\components\BaseController;
use yii\helpers\Url;

/** @var $this yii\web\View */
$this->title = '考务管理-成绩录入';
$this->blocks['requireModule']='app/sch_mag/sch_mag_input_select';
?>
<div class="main col1200 clearfix sch_mag_input" id="requireModule" rel="app/sch_mag/sch_mag_input_select">
    <div class="container testTitle">
        <?php echo $this->render('_public_title',['examName'=>$examName,'department'=>$department]);?>
    </div>
    <div class="container input_banner"><img src="<?=BH_CDN_RES;?>/static/images/school_banner.jpg"></div>
    <div class="container">
        <div class="pd25">
            <ul id="classes_list" class="classes_list">
                <?php foreach($examClass as $v):
                    $class = 'undo';
                    $ac = '';
                    if($v[2] == $classId){$ac = 'ac';}
                    if($v[1] == 0){$class = 'undo';}elseif($v[1] == 1){$class = 'half';}elseif($v[1] == 2){$class = 'finish';}
                    ?>
                    <li><a class="<?php echo $class,' ',$ac;?>" href="<?php echo Url::to(['check-class','classId'=> $v[2],'examId'=>$schoolExamId])?>" ><?php echo $v[0]?><i></i></a></li>
                <?php endforeach;?>
            </ul>

            <?php echo  $this->render('_public_score')?>
            <hr>
            <div id="editCont" class="edit_input show_btnBar editCont">
                <?php echo  $this->render('_teacher_link',['schoolExamId'=>$schoolExamId,'classId'=>$classId,'subjectList'=>$subjectList,'schoolId'=>$schoolId,'classExamId'=>$classExamId])?>
                <div class="btnBar tc">
                    <a id="manualBtn" href="<?php echo Url::to(['manual-input','examId'=>$schoolExamId,'classId'=>$classId])?>" class="btn bg_white manualBtn">手动录入成绩</a><a id="uploadExcelBtn" href="javascript:;" class="btn bg_white uploadBtn">录入成绩文件</a>

                        <a id="uploadFileBtn" href="javascript:;" class="uploadFileBtn">
                            <?php
                            $t1 = new schoolmanage\widgets\xupload\models\XUploadForm;

                            echo  \schoolmanage\widgets\xupload\XUploadRequire::widget( array(
                                'url' => Yii::$app->urlManager->createUrl("upload/excel"),
                                'model' => $t1,
                                'attribute' => 'file',
                                'autoUpload' => true,
                                'multiple' => false,
                                'options' => array(
                                    'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(xlsx|xls)$/i'),
                                    'maxFileSize' => 4*1024*1024,
                                    "done" => new \yii\web\JsExpression('done'),
                                    "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}}')
                                ),
                                'htmlOptions' => array(
                                    'id' => 'fileupload',
                                )
                            ));
                            ?>
                        </a>
                    </div>
                    <!-- 表格区-->

                <br>
                <div class="tc" style="padding:20px 0 10px">
                    <span class="tab_text gray_l"><i></i>横向切换键：tab或enter键</span> <i class="ico_excel"></i> 下载Excel成绩导入模板 <a href="<?=url('template/template.xlsx')?>" >点此下载</a>
                </div>
            </div>

        </div>


    </div>
</div>


<!--弹框-->
<div id="importExcelBox" class="popBox importExcelBox hide" title="导入成绩" >
    <div class="popCont tc ">
        <!--    add_error 上传错误的时候添加    -->
        <h5><i></i> 上传成功,请添加成绩</h5>
        <p class="gray_l"><i class="ico_excel"></i> <span id="excel_truename"></span></p>
        <p class="red up_error_text">表内的格式不对，请参照模板格式填写</p>
        <p class="tc" style="margin-top: 10px">

            <button type="button" class="bg_blue btn40 excel_add_btn" data-url="" data-classid="<?= app()->request->get('classId')?>" data-examid="<?= app()->request->get('examId')?>">添加</button>
            <a href="javascript:;" class="reUploadFileBtn">
                重新上传
                <?php
                $t1 = new schoolmanage\widgets\xupload\models\XUploadForm;

                echo  \schoolmanage\widgets\xupload\XUploadRequire::widget( array(
                    'url' => Yii::$app->urlManager->createUrl("upload/excel"),
                    'model' => $t1,
                    'attribute' => 'file',
                    'autoUpload' => true,
                    'multiple' => false,
                    'options' => array(
                        'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(xlsx|xls)$/i'),
                        'maxFileSize' => 4*1024*1024,
                        "done" => new \yii\web\JsExpression('done'),
                        "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}}')
                    ),
                    'htmlOptions' => array(
                        'id' => 'fileupload2',
                    )
                ));
                ?>
            </a>
        </p>
    </div>
    <div class="popBtnArea">
        <span class="gray_l"><i class="ico_alert"></i> 上传的成绩表单，需按照模板的格式填写！没有模板？点击这里 <a style="color:#10ade5" href="<?=url('template/template.xlsx')?>" >下载模板</a></span>
    </div>
</div>


<!--添加错误弹框-->
<div id="importExcelBoxError" class="popBox importExcelBox hide" title="导入成绩" >
    <div class="popCont tc add_error">
        <!--    add_error 上传错误的时候添加    -->
        <h5><i></i> 添加失败,请重新上传</h5>
        <p class="gray_l"><i class="ico_excel"></i> <span id="excel_truename"></span></p>
        <p class="red up_error_text" id="up_error_text">表内的格式不对，请参照模板格式填写</p>
        <p class="tc" style="margin-top: 10px">
            <a href="javascript:;" class="reUploadFileBtn">
                重新上传
                <?php
                $t1 = new schoolmanage\widgets\xupload\models\XUploadForm;

                echo  \schoolmanage\widgets\xupload\XUploadRequire::widget( array(
                    'url' => Yii::$app->urlManager->createUrl("upload/excel"),
                    'model' => $t1,
                    'attribute' => 'file',
                    'autoUpload' => true,
                    'multiple' => false,
                    'options' => array(
                        'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(xlsx|xls)$/i'),
                        'maxFileSize' => 4*1024*1024,
                        "done" => new \yii\web\JsExpression('done'),
                        "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}}')
                    ),
                    'htmlOptions' => array(
                        'id' => 'fileupload3',
                    )
                ));
                ?>
            </a>
        </p>
    </div>
    <div class="popBtnArea">
        <span class="gray_l"><i class="ico_alert"></i> 上传的成绩表单，需按照模板的格式填写！没有模板？点击这里 <a style="color:#10ade5" href="<?=url('template/template.xlsx')?>" >下载模板</a></span>
    </div>
</div>
<script type="text/javascript">
    done= function (e, data) {
        $.each(data.result, function (index, file) {
            if(file.error){
                popBox.alertBox(file.error);
                return false;
            }

            $('#excel_truename').text(file.name);
            $('.excel_add_btn').attr('data-url',file.url);
            $('#importExcelBoxError').dialog('close');
            $('#importExcelBox').dialog('open');

        });
    };

</script>
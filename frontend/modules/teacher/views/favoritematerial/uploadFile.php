<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/7/29
 * Time: 14:19
 */
use frontend\components\helper\TreeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '上传课件';
$this->blocks['requireModule'] = 'app/teacher/main_video_upload';
$this->registerCssFile(BH_CDN_RES.'/static'.'/css/video_upload.min.css');
?>
<div class="cont24 clearfix" >
<div class="grid24 main">
<div class="mag_title">
    <a  href="javascript:history.back(-1);" class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
    <h4>上传课件</h4>
</div>
<div class="main_center">
<div class="main_cont">
<a class="bg_blue btn50 w180 iconBtn a_button clearfix"
   style="position:relative; overflow: hidden"></i>
<!--    <input type="hidden" name="XUploadForm[file]" value="">-->
<!--    <input type="file" id="fileupload" class=" file" name="XUploadForm[file]">-->
    <?php
    $t1 = new frontend\widgets\xupload\models\XUploadForm;
    /** @var $this BaseController */
    echo  \frontend\widgets\xupload\XUploadRequire::widget( array(
        'url' => Yii::$app->urlManager->createUrl("upload/prepare"),
        'model' => $t1,
        'attribute' => 'file',
        'autoUpload' => true,
        'multiple' => true,
        'options' => array(
            'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(pdf|doc|docx|ppt|pptx|zip|rar|jpg|png)$/i'),
            'maxFileSize' => 4*1024*1024,
            "done" => new \yii\web\JsExpression('done'),
            "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {  require(["popBox"],function(popBox){popBox.errorBox(file.error); });}}')
        ),
        'htmlOptions' => array(
            'id' => 'fileupload',
        )
    ));
    ?>
    选择我的文件</a>
<!--<button type="button" class="bg_green btn50 w180 iconBtn"></i>选择我的文件</button>-->
<dl class="attentionTxt clearfix">
    <dt>上传须知：</dt>
    <dd class="gray_d">
        <p>1.您可以上传日常积累和撰写的备课资料，每个文件大小不超过4M；支持多种文件类型pdf，doc（docx），ppt（pptx），jpg，png。</p>
        <p>2.上传时可设置文件为私有或共享权限，设置为共享的文件经过班海网审核通过后，任何人将可以浏览或下载。</a></p>
        <p>3.上传涉及侵权或违法内容的文档将会被移除。</p>
    </dd>
</dl>
<div class="upld">
    <h4 class="upld_tl">上传内容</h4>
    <ul class="upld_detail clearfix">
        <li id="delBtnP" class="clearfix">

        </li>
    </ul>
</div>
<div class="upld">

    <h4 class="upld_tl">选择文件位置</h4>
    <lable>学部：</lable>
    <?php
    echo Html::dropDownList("", $department
        ,
        $departmentArray,
        array(
            'class'=>'div mr',
            "id" => "department",
            'data-validation-engine' => 'validate[required]',
            'data-prompt-target' => "version_prompt",
            'data-prompt-position' => "inline",
            'data-errormessage-value-missing' => "版本不能为空",
        ));
    ?>
    <lable>科目：</lable>
    <?php
    echo Html::dropDownList("", $subjectID
        ,
        $subjectArray,
        array(
            'class'=>'edi mr',
            "id" => "subject",
            'data-validation-engine' => 'validate[required]',
            'data-prompt-target' => "version_prompt",
            'data-prompt-position' => "inline",
            'data-errormessage-value-missing' => "版本不能为空",
        ));
    ?>
    <lable>版本：</lable>
    <?php
    echo Html::dropDownList("", ''
        ,
        $versionArray,
        array(
            'class'=>'edi mr',
            "id" => "version",
            'data-validation-engine' => 'validate[required]',
            'data-prompt-target' => "version_prompt",
            'data-prompt-position' => "inline",
            'data-errormessage-value-missing' => "版本不能为空",
        ));
    ?>
    <lable>分册：</lable>
    <?php
    echo Html::dropDownList("", ''
        ,
        $chapterTomeArray,
        array(
            'class'=>'fas',
            "id" => "tome",
            'data-validation-engine' => 'validate[required]',
            'data-prompt-target' => "version_prompt",
            'data-prompt-position' => "inline",
            'data-errormessage-value-missing' => "版本不能为空",
        ));
    ?>
</div>
<div id="chapter" class="chapter">
    <div id="alert_header">章节
        <div id="alert_remove" id="alert_remove"></div>
    </div>
    <div id="alert_main" class="alert_main">
        <div id="add_parent" class="clearfix add_parent">
            <div class="cha_box cha_l leftTree">
                <?php  echo TreeHelper::streefun($chapterTree,[],'tree pointTree')?>
            </div>
            <div class="cha_box cha_c">
                <br><br>
                <button id="add_custom_btn" type="button" class="bg_blue">添加</button>
                <br><br>
                <button id="del_custom_btn" type="button" class="">删除</button>
            </div>
            <div class="cha_box cha_r">
                <ul id="custom_sel_list" class="custom_sel_list">

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="classify">
    <h4>分类</h4>
    <ul class="resultList clearfix">
        <li class="ac" data="7"><a href="javascript:;">教学计划</a></li>
        <li data="1"><a href="javascript:;">教案</a></li>
        <li data="8"><a href="javascript:;">课件</a></li>
        <li data="6"><a href="javascript:;">素材</a></li>
        <li data="99"><a href="javascript:;">其他</a></li>
    </ul>
</div>
<div class="upld">
    <h4 class="upld_tl">设置权限</h4>
    <p class="inprad">
        <input type="radio" class="hide" id="raido3" name="limit" checked="checked" value="1"><label
            for="raido3"
            class="radioLabel radioLabel_ac">分享<span
                class="gray">（选择分享后，在个人中心课件可以共享到班级）</span></label>
    </p>

    <p class="inprad">
        <input type="radio" class="hide" id="raido4" name="limit" value="2">
        <label for="raido4" class="radioLabel">私有</label>
    </p>
</div>
<br>
<div class="submitBtnBar">
    <button style="margin-right:20px" class="btn40 bg_blue w120 upload">确认上传</button>
</div>
</div>
</div>
</div>
</div>
<script>
    var name="";
    done = function (e, data) {
        $.each(data.result, function (index, file) {
            if (file.error) {
                popBox.errorBox(file.error);
                return;
            }
            url = file.url;
            name = file.name;
            $('.upld_detail li ').html('<p><input type="hidden" class="url" value="'+url+'" />'+name+' <i class="icon delBtn"></i></p>');
        });
    };
//    学部改变
    $('#department').change(function(){
        $('#custom_sel_list').html('');
         department = $(this).val();
//        科目跟着联动
        $.post('<?=Url::to(["/ajax/get-subject-by-department"])?>',{department:department},function(result){
            $('#subject').html(result);
            var subjectID = $('#subject').val();
//            版本跟着联动
            $.get('<?=Url::to(["/ajax/get-versions"])?>',{subject:subjectID,department:department,prompt:0},function(result){
                    $('#version').html(result);
                var version = $('#version').val();
//                分册跟着联动
                $.post('<?=Url::to(["/ajax/get-chapter-tome"])?>',{subjectID:subjectID,department:department,version:version},function(result){
                    $('#tome').html(result);
                   var chapterId = $('#tome').val();
                    $.post('<?=Url::to(["/ajax/get-chapter-tree"])?>',{subjectID:subjectID,department:department,version:version,chapterId:chapterId},function(result){
                        $('.leftTree').html(result);
                        $(".tree").tree();

                    })
                })
            })
        })
    });
//    科目改变
    $('#subject').change(function(){
        $('#custom_sel_list').html('');
     var    department=$('#department').val();
        var subjectID = $(this).val();
//            版本跟着联动
        $.get('<?=Url::to(["/ajax/get-versions"])?>',{subject:subjectID,department:department,prompt:0},function(result){
            $('#version').html(result);
            var version = $('#version').val();
//                分册跟着联动
            $.post('<?=Url::to(["/ajax/get-chapter-tome"])?>',{subjectID:subjectID,department:department,version:version},function(result){
                $('#tome').html(result);
                var chapterId = $('#tome').val();
                $.post('<?=Url::to(["/ajax/get-chapter-tree"])?>',{subjectID:subjectID,department:department,version:version,chapterId:chapterId},function(result){
                    $('.leftTree').html(result);
                    $(".tree").tree();

                })
            })
        })

    });
//    改变版本
    $('#version').change(function(){
        $('#custom_sel_list').html('');
        var    department=$('#department').val();
        var subjectID = $('#subject').val();
            var version = $('#version').val();
//                分册跟着联动
            $.post('<?=Url::to(["/ajax/get-chapter-tome"])?>',{subjectID:subjectID,department:department,version:version},function(result){
                $('#tome').html(result);
                var chapterId = $('#tome').val();
//                章节树跟着联动
                $.post('<?=Url::to(["/ajax/get-chapter-tree"])?>',{subjectID:subjectID,department:department,version:version,chapterId:chapterId},function(result){
                    $('.leftTree').html(result);
                    $(".tree").tree();

                })
            })

    });
//    改变分册
    $('#tome').change(function(){
        $('#custom_sel_list').html('');
        var    department=$('#department').val();
        var subjectID = $('#subject').val();
        var version = $('#version').val();
        var chapterId = $('#tome').val();
        //                章节树跟着联动
        $.post('<?=Url::to(["/ajax/get-chapter-tree"])?>',{subjectID:subjectID,department:department,version:version,chapterId:chapterId},function(result){
            $('.leftTree').html(result);
            $(".tree").tree();

        })
    })
    $('.upload').click(function(){
        var department=$('#department').val();
        var subjectID=$('#subject').val();
        var version=$('#version').val();
        var chapterId=$('#custom_sel_list .ac').attr('id');
        var chapterList = $('#custom_sel_list').find('li');
        var matType =$('.resultList .ac').attr('data');
        var  access = $("[name='limit']:checked").val();
        var url=$('.url').val();
       if(url==null){
           require(['popBox'],function(popBox){
               popBox.errorBox('请上传文件');
           });
           return false;
       }
        if(chapterList.size()>0) {
            chapterList.each(function (index, el) {
                if (index == 0) {
                    chapterId = $(el).attr('id');
                }
            });
        }else{
            require(['popBox'],function(popBox){
                popBox.errorBox('请选择章节');
            });
            return false;
        }


        $.post("<?=url::to(['ajax-upload'])?>", {
           department:department,

            subjectID: subjectID,

            version: version,

            matType: matType,

            name: name,

            url: url,

            access: access,

            chapKids: chapterId

        }, function (result) {

            if (result.success) {

                require(['popBox'],function(popBox){

                    popBox.successBox('上传成功');
                });
                setTimeout(function(){
                    location.href = "<?=url('teacher/favoritematerial/index-create')?>"
                },1800)

            }
        })

    })
</script>
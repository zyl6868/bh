<?php
/**
 * Created by 王
 * User: Administrator
 * Date: 14-9-11
 * Time: 下午3:54
 */
?>
<!--弹出框----上传头像-->
<div id="uploadPic" class="popBox uploadPic hide" title="上传图片">
	<span class="fileinput-button uploading">
    	<span class="id_btn Continue">选择文件</span>
        <?php
        $t1 = new frontend\widgets\xupload\models\XUploadForm;
        /** @var $this BaseController */
        echo  \frontend\widgets\xupload\XUploadSimple::widget( array(
            'url' => \Yii::$app->urlManager->createUrl("upload/header"),
            'model' => $t1,
            'attribute' => 'file',
            'autoUpload' => true,
            'multiple' => false,
            'options' => array(
                'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                'maxFileSize' => 2000000,
                "done" => new \yii\web\JsExpression('done'),
                "processfail" => new \yii\web\JsExpression('function (e, data) {var index = data.index,file = data.files[index]; if (file.error) {alert(file.error);}}')
            ),
            'htmlOptions' => array(
                'id' => 't1',
            )
        ));
        ?>
    </span>

    <div class="zxxWrap" style="display:none;">
        <hr>
        <h5>裁剪头像</h5>
        <h6>最终头像:</h6>

        <div class="zxx_main_con">
            <div class="zxx_test_list pr">

                <img id="xuwanting" src="../images/head.jpg"/>
                <span id="preview_box230" class="crop_preview230">
                    <img id="crop_preview230" src="../images/head.jpg"/>
                </span>
                <span id="preview_box110" class="crop_preview110">
                    <img id="crop_preview110" src="../images/head.jpg"/>
                </span>
                <span id="preview_box70" class="crop_preview70">
                    <img id="crop_preview70" src="../images/head.jpg"/>
                </span>
                <span id="preview_box40" class="crop_preview40">
                    <img id="crop_preview40" src="../images/head.jpg"/>
                </span>
            </div>
        </div>
        <input type="hidden" id="jcrop_x1">
        <input type="hidden" id="jcrop_y1">
        <input type="hidden" id="jcrop_x2">
        <input type="hidden" id="jcrop_y2">
        <input type="hidden" id="jcrop_w">
        <input type="hidden" id="jcrop_h">
    </div>
</div>
<script>

    $('#uploadPic').dialog({
        width: 880,
        autoOpen: false,
        zIndex: 10000,
        modal: true,
        resizable: false,
        buttons: [
            {
                text: "确定",
                click: function () {

                    var url = '<?php echo url("ajax/image")?>';
                    var x = $('#jcrop_x1').val();
                    var y = $('#jcrop_y1').val();
                    var width = $('#jcrop_w').val();
                    var height = $('#jcrop_h').val();

                    //没有裁剪
                    if (x == 0) {
                        x = 0;
                    }
                    if (y == 0) {
                        y = 0;
                    }
                    if (width == 0) {
                        width = 500;
                    }
                    if (height == 0) {
                        height = 500;
                    }
                    $.post(url, {name: img.url, x: x, y: y, width: width, height: height}, function (data) {
                        $('#face-img').attr('src',"").attr('src',data);
                        $('.faceIcon').val(data);
                    });
                    $("#save").show();
                    $(this).dialog("close");
                }
            },
            {
                text: "取消",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    $(function () {
        $('#uploadPicBtn').click(function () {
            $('#uploadPic').dialog('open');

        });
    });


    //    上传图片完成后的处理
    done = function (e, data) {

        $.each(data.result, function (index, file) {
            if (file.error) {
                popBox.alertBox(file.error);
                return;
            }
            img = file;
            //给隐藏表单赋值
            $('.faceIcon').val(file.url);
            $('.jcrop-holder').find('img').attr('src', file.url);
            $("#xuwanting").attr("src", file.url);
            $("#crop_preview230").attr("src", file.url);
            $("#crop_preview110").attr("src", file.url);
            $("#crop_preview70").attr("src", file.url);
            $("#crop_preview40").attr("src", file.url);
            $(".zxxWrap").show();
            popBox.uploadPic();
            $(".jcrop-holder").show();

        })
    };
    var Jcrop = function () {

    }


</script>
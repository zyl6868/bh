<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/7/27
 * Time: 16:46
 */
use yii\helpers\Html;
use yii\web\View;


$this->title = '修改通知';
$this->blocks['requireModule'] = 'app/teacher/teacher_seed_message';
$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_seed_message.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
?>

<div id="main" class="main">
    <h4 id="main_head" class="bg_fff main_head"><a href="javascript:;" onclick="javascript:history.back(-1)"
                                         class="btn icoBtn_back" ;><i></i>返回</a>发布通知</h4>

    <div class="bg_fff" style="padding-top:18px;">
        <div class="gap" id="gap">
            <span class="width_left" name="HomeContactForm[title]"><i class="red">*</i>通知标题:</span>

            <div class="write_pen"><input id="title_txt" class="title_txt" data-msgid="<?php echo $modelList->id; ?>" maxlength="30"
                                          value="<?php echo Html::encode($modelList->title); ?>"></div>
            <div class="memor_nameformError parentFormevent_form formError"
                 style="opacity: 0.87;position: absolute;top: 1px;left: 200px;margin-top: -34px;display:none;">
                <div class="formErrorContent">此处不可空白<br></div>
                <div class="formErrorArrow">
                    <div class="line10"><!-- --></div>
                    <div class="line9"><!-- --></div>
                    <div class="line8"><!-- --></div>
                    <div class="line7"><!-- --></div>
                    <div class="line6"><!-- --></div>
                    <div class="line5"><!-- --></div>
                    <div class="line4"><!-- --></div>
                    <div class="line3"><!-- --></div>
                    <div class="line2"><!-- --></div>
                    <div class="line1"><!-- --></div>
                </div>
            </div>
        </div>
        <!-- 收件人 -->
        <div id="consignee" class="gap consignee">
            <span class="width_left"><i class="red">*</i>收件人:</span>

            <div id="save_message">
                <?php foreach ($schoolClass as $class) { ?>
                    <ul class="ul_1">

                        <li class="border__" id="<?php echo $class->classID; ?>">
                            <span><label><input name="grade_class"
                                                type="radio" <?php if ($class->classID == $modelList->classId) {
                                        echo 'checked';
                                    } ?>/><?php echo $class->className; ?></label></span>
                        </li>

                        <li class="user_hide">
                            <select class="choose" name="HomeContactForm[scope]">
                                <option value="1" <?php if ($modelList->scope == 1 && $class->classID == $modelList->classId) {
                                    echo 'selected';
                                } ?> >全部学生
                                </option>
                                <option value="0" <?php if ($modelList->scope == 0 && $class->classID == $modelList->classId) {
                                    echo 'selected';
                                } ?> >部分学生
                                </option>
                            </select>
                        </li>
                        <li class="hide user_hide">
                            <button>选择学生</button>
                        </li>
                        <ul class="choose_stu">

                        </ul>
                    </ul>
                    <ul class="ul_2">
                        <?php if ($modelList->scope == 0 && $class->classID == $modelList->classId) { ?>
                            <?php foreach ($receivers as $receiver) { ?>
                                <?php if ($receiver->type == 0) { ?>
                                    <li class="bg_blue_"
                                        data-userid= <?php echo $receiver->receiverId; ?>><?php echo $receiver->receiverName; ?></li>
                                <?php }
                            } ?>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
        <!-- 收件人身份 -->
        <div class="gap">
            <span class="width_left"><i class="red">*</i>收件人身份:</span>
            <label><input name="receiverType" value="1" type="checkbox" <?php if ($son == 1) {
                    echo 'checked';
                } ?> id="stu">学生</label>&nbsp;&nbsp;
            <label><input name="receiverType" value="2" type="checkbox" <?php if ($parent == 2) {
                    echo 'checked';
                } ?> id="parents">家长</label>
        </div>
        <!-- 通知内容 -->
        <div style="position:relative">
            <span class="width_left"><i class="red">*</i>通知内容:</span><textarea
                                                                               name="HomeContactForm[addContent]"><?php echo $modelList->addContent ?></textarea>

            <div class="memor_nameformError parentFormevent_form formError"
                 style="opacity: 0.87;position: absolute;top: 1px;left: 200px;margin-top: -34px;display:none;">
                <div class="formErrorContent">此处不可空白<br></div>
                <div class="formErrorArrow">
                    <div class="line10"><!-- --></div>
                    <div class="line9"><!-- --></div>
                    <div class="line8"><!-- --></div>
                    <div class="line7"><!-- --></div>
                    <div class="line6"><!-- --></div>
                    <div class="line5"><!-- --></div>
                    <div class="line4"><!-- --></div>
                    <div class="line3"><!-- --></div>
                    <div class="line2"><!-- --></div>
                    <div class="line1"><!-- --></div>
                </div>
            </div>
                <span
                    id="max_length_txt" class="max_length_txt">0/1000</span><span id="max_length_textarea"></span>
        </div>
        <!-- 添加图片 -->
        <div id="addImg" class="addImg">
            <span class="width_left fl">添加图片:</span>

            <div class="inline_block">

                <span class="red inline_block" style="line-height:24px;">最多可添加6张图片</span>
            </div>
            <div class="row">
                <div class="form_l"></div>
                <div class="form_r">
                    <div class="upImgFile">
                        <ul class="clearfix picList img_add" id="img_add">
                            <?php
                            if (!empty($url)) {

                                foreach ($url as $v) {
                                    ?>
                                    <li>
                                        <input type="hidden" value="<?php echo $v ?>" name="SeClassEvent[image][]">
                                        <img alt="" src="<?php echo resCdn($v) ?>">
                                        <span class="delBtn"></span>
                                    </li>
                                <?php }
                            }
                            ?>
                            <li class="uploadFile disabled"><a href="javascript:;" class="uploadFileBtn">
                                    <i></i>
                                    还可以添加<span></span>张图片

                                    <?php
                                    $t1 = new frontend\widgets\xupload\models\XUploadForm;
                                    /** @var $this BaseController */
                                    echo \frontend\widgets\xupload\XUploadRequire::widget(array(
                                        'url' => Yii::$app->urlManager->createUrl("upload/paper"),
                                        'model' => $t1,
                                        'attribute' => 'file',
                                        'autoUpload' => true,
                                        'multiple' => true,
                                        'options' => array(
                                            'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(jpg|png|jpeg)$/i'),
                                            'maxFileSize' => 4 * 1024 * 1024,
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
        <div class="btn_class">
            <button type="button" class="btn send_" id="send_" value="send_">立即发送</button>
            <button type="button" class="btn save_" id="save_" value="save_">保存</button>
        </div>
    </div>
</div>
<script>
    done = function (e, data) {
        $.each(data.result, function (index, file) {
            if (file.error) {
                require(['popBox'], function (popBox) {
                    popBox.errorBox(file.error);
                });
                return;
            }
            var liSize = $('.upImgFile').find('li').size();
            if (liSize >= 7) {
                require(['popBox'], function (popBox) {
                    popBox.errorBox('最多传6张图片');
                });
                return;
            }
            $('<li><input type="hidden" name="XUploadForm[file]" value="' + file.url + '"><img src="' + file.url + '" alt=""><span class="delBtn"></span></li>').insertBefore('.uploadFile');

        });
        require(['app/teacher/teacher_seed_message'], function (classes_modify) {
            classes_modify.leftPicCal();
        });

    };

</script>

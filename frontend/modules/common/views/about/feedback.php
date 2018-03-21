<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-9-6
 * Time: 下午16:01
 */
$this->title="反馈意见";

?>
<!--主体-->
<div class="cont24">
    <div class="grid24 main">
        <div class="grid_5 main_l">
            <div class="item l_asideMenu">
                <ul class="setupMenu noneMenu">
                    <li><a class="lisC" href="<?= Url::to(['/common/about/index']) ?>">关于我们</a>
                    </li>
                    <li class="ac"><a class="lisD" href="javascript:;">反馈意见</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid_19 main_r">
            <div class="main_cont test">
                <div class="title">
                    <h4>反馈意见</h4>
                </div>
                <?php /* @var  $this CActiveForm */
                $form =\yii\widgets\ActiveForm::begin( array(
                    //'enableClientScript' => false,
                    'id' => 'form_id'
                )) ?>
                <div class="date_feedback">
                    <dl class="report_cont">
                        <dt>
                            如果您有话要对我们说，无论褒贬，都可以通过反馈意见发给我们，您的建议是我们进步的力量。
                        <dd>
                        </dd>
                    </dl>
                        <dl class="report_cont">
                            <dt>
                                <span class="text-col">&nbsp;反馈内容</span></dt>
                            <dd>
                                <div class="textareaBox textareacon textareacte">
                                <textarea id="content" name="<?php echo Html::getInputName($suggestion, 'content') ?>" class="textarea" data-errormessage-value-missing="内容必填！"  data-prompt-position="inline" data-prompt-target="contentError"  data-validation-engine="validate[required,maxSize[500]]"></textarea>
                                    <span id="contentError" class="errorTxt" style="border: none;margin-left: 220px"></span>
                                <div class="btnArea"><em class="txtCount">不得超过<b class="num">500</b> 字</em>
                                </div>
                            </div>
                            </dd>
                        </dl>
                        <dl class="btnbox">
                            <dt>&nbsp;
                                </dt>
                            <dd>
                                <button type="submit" id="sub" class="btn btn40 bg_blue w140">
                                    提交</button>
                            </dd>
                        </dl>
                    </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
                <div class="off_wechat">
                <img style="width: 100px;height: 100px" src="<?= BH_CDN_RES.'/pub'.'/images/two-dimension_code.jpg' ?>" alt="">
                <span class="offwx">官方微信</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--提交弹出层-->
<div id="popBox1" class="popBox popBox_hand hide" title="系统提示">
    <div class="popCont">
        <div class="">
            <form>
                <div class="form_list">
                    <div class="row clearfix">
                        <div class="formL formL_face">
                            <label class="face_pic"><img src="<?= BH_CDN_RES.'/pub/images/face_pic.png'?>" alt=""></label>
                        </div>
                        <div class="formR formR_text">
                            您的意见已经成功反馈给班海，我们会尽快跟您联系！<br>
                            感谢您的反馈，您的支持是我们最大的动力！
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--主体end-->
    <script type="text/javascript">

        $(function() {
            $('#popBox1').dialog({
                autoOpen: false,
                width: 720,
                modal: true,
                resizable: false,

                buttons: [{
                    text: "确定",
                    click: function() {
                        $(this).dialog("close")
                    }
                }
                ]
            });
        });

    </script>

<?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
    <script type="text/javascript">
        $(function(){
            $("#popBox1").dialog("open");
        })
    </script>
<?php } ?>

<?php
use common\models\sanhai\SeDateDictionary;
use frontend\components\CHtmlExt;
use common\components\WebDataCache;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = "个人设置-基本信息";
$backend_asset = BH_CDN_RES.'/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$userModel = loginUser();
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
                            <div class="form_right"><?php echo $userModel -> trueName;?></div>
                            <br/>
                            <div class="form_left">手机号:</div>
                            <div class="form_right"><?php echo $userModel -> bindphone;?></div>
                            <br/>
                            <div class="form_left">登录名:</div>
                            <div class="form_right"><?php echo $userModel -> phoneReg;?></div>
                            <br/>
                            <div class="form_left">性别:</div>
                            <div id="sex_input" class=" form_right">
                                <label>
                                    <input type="radio" name="sex" value="1" <?php echo $userModel->sex == 1 ? 'checked' : ''?> >
                                    <span>男</span>
                                </label>
                                <label>
                                    <input type="radio" name="sex" value="2" style="margin-left:30px" <?php echo $userModel->sex == 2 ? 'checked' : ''?> >
                                    <span>女</span>
                                </label>
                            </div>
                            <br/>
                            <?php if($parentAccount){ ?>
                                <div class="form_left">家长帐号:</div>
                                <div class="form_right">
                                    <?php echo $parentAccount; ?>
                                </div>
                                <br/>
                            <?php } ?>
                            <button id="save" class="save">保存</button>
                            <a href="<?php echo url('student/setting/basic-information') ?>" class="btn_reset">取消</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!--主体end-->
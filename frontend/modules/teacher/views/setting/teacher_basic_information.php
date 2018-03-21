<?php
use common\models\sanhai\SeDateDictionary;
use common\components\WebDataCache;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SchoolLevelModel;
use yii\web\View;

$this->title = "个人设置-基本信息";
$backend_asset = BH_CDN_RES.'/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$userModel = loginUser();
?>
<div class="cont24">
    <div class="grid24 main">
        <!--主体-->
        <div class="grid_19 main_r">
            <div class="main_cont userSetup upload_Pic">
                <div class="tab">
                    <?php echo $this->render("//publicView/setting/_set_href") ?>
                    <div class="tabCont">
                        <div class="form_list stu_messages">
                            <a href="<?php echo url('teacher/setting/teacher-edit-basic-information') ?>" id="compile" class="stu_form_1">编辑 <i></i></a>
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
                            <div id="sex" class="stu_form_1 form_right">

                                <?php
                                if($userModel -> sex == 1){
                                    echo "男";
                                }else if($userModel -> sex == 2){
                                    echo "女";
                                }else{
                                    echo "--";
                                }
                                ?>
                            </div>
                            <br/>
                            <div class="form_left">任教学科:</div>
                            <div class="form_right">
                                <?php echo SchoolLevelModel::model()->getName($userModel -> department); ?>
                                <?php echo WebDataCache::getSubjectNameById($userModel -> subjectID);?>
                                <?php echo  EditionModel::model()->getName($userModel -> textbookVersion);?>
                            </div>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--主体end-->
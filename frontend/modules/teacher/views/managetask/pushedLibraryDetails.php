<?php
/**
 * Created by liuxing.
 * User: Administrator
 * Date: 2015/9/18
 * Time: 10:10
 */
use frontend\components\helper\AreaHelper;
use common\components\WebDataCache;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;
$this->registerCssFile(BH_CDN_RES.'/static/css/media_source.css'.RESOURCES_VER, ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile(BH_CDN_RES . '/static/css/classes.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/app/classes/media_source.js', ['position' => \yii\web\View::POS_HEAD]);


$this->title = '作业详情';
$publicResources = Yii::$app->request->baseUrl;
$this->blocks['requireModule'] = 'app/platform/platform_hmwk_veiw_ele';

?>
<!--top_end-->
<!--主体-->
<body class="platform">
<div class="main col1200 clearfix platform_hmwk_veiw_ele" id="requireModule" rel="app/platform/platform_hmwk_veiw_ele">
    <div class="container homework_title">
        <a href="javascript:history.back(-1);" class="btn return_btn">返回</a>
        <h4 title="<?php echo $homeworkData->name; ?>"><?php echo $homeworkData->name; ?></h4>
    </div>
    <div class="container homwork_info">
        <div class="pd25">
            <?php if (!empty($homeworkData->provience) && !empty($homeworkData->city) && !empty($homeworkData->country)) { ?>
                <p>地区： <span>
	                        <?php echo AreaHelper::getAreaName($homeworkData->provience); ?>
                        &nbsp;<?php echo AreaHelper::getAreaName($homeworkData->city); ?>
                        &nbsp;<?php echo AreaHelper::getAreaName($homeworkData->country); ?>
                </span></p>
            <?php }
            if (!empty($homeworkData->gradeId)) { ?>
                <p><em>年级：</em><?php echo WebDataCache::getGradeName((int)$homeworkData->gradeId) ?></p>
            <?php }
            if (!empty($homeworkData->subjectId)) { ?>
                <p><em>科目：</em><?php echo SubjectModel::model()->getName((int)$homeworkData->subjectId) ?></p>
            <?php }
            if (!empty($homeworkData->version)) { ?>
                <p><em>版本：</em><?php echo EditionModel::model()->getName($homeworkData->version) ?></p>
            <?php } ?>
            <?php if (isset($homeworkData->difficulty) && $homeworkData->difficulty >= 0) { ?>
                <p><em>难度：</em><b class="<?php if ($homeworkData->difficulty == 0) {
                        echo "";
                    } elseif ($homeworkData->difficulty == 1) {
                        echo "dif_mid";
                    } elseif ($homeworkData->difficulty == 2) {
                        echo "dif_hard";
                    } ?>"></b></p>
            <?php }
            if (!empty($homeworkData->homeworkDescribe)) { ?>
                <p><em>简介：</em><?= cut_str(Html::encode($homeworkData->homeworkDescribe), 300); ?></p>
            <?php } ?>
            <?php if ($homeworkIsExist) { ?>
                <button type="button" data-id="<?php echo $homeworkData->id ?>" class="sc disableBtn isAssigned">收藏作业
                </button>
            <?php } else { ?>
                <button type="button" id="upbtnBox" data-id="<?php echo $homeworkData->id ?>"
                        data-exist="<?php echo $homeworkIsExist ?>" class="sc">收藏作业
                </button>
            <?php } ?>
            <button type="button" id="upbtn" data-id="<?php echo $homeworkData->id ?>" class="bz">布置给学生</button>
        </div>
    </div>
    <div class="container no_bg">
        <div class="testPaper">
            <?php foreach ($homeworkResult as $item) { ?>
                <?php echo $this->render('//publicView/new_class_homework/_itemPreviewType', array('item' => $item, 'homeworkData' => $homeworkData)); ?>
            <?php } ?>
        </div>
    </div>

    <div class="container">

        <div class="tch_suggestion clearfix">
            <div class="formL">
                <p><em>您好，</em><br/>关于推送给您的作业，<br/>欢迎给我们提出宝贵的意见和使用感受！</p>
                <img src="/static/images/teacher.png" alt=""/>
            </div>
            <div class="formR">
                <div class="textareaBox">
                    <textarea class="textarea add_txt"></textarea>
                    <span class="placeholder" style="display:block;">请填写内容</span>
                    <div class="btnArea">
                        <em class="txtCount">可以输入<b class="num">300</b>字</em>
                        <button type="button" style="right:-3px" data-id="<?php echo $homeworkData->id ?>"
                                class="sendBtn btn_Submit">发送
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</body>
<!--主体end-->

<!--布置给学生弹出层-->
<div id="pop_sel_classes" class="popBox pop_sel_classes hide" title="选择班级">

</div>
<!--收藏作业弹出层-->
<div id="pop_system_msg" class="popBox pop_system_msg hide" title="系统提示">
    <div class="popCont">
        <div class="">
            <form>
                <div class="form_list">
                    <div class="row work_row clearfix">
                        <div class="formL formL_face work_face">
                            <label class="face_pic"><img src="<?= BH_CDN_RES . '/pub' ?>/images/face_pic.png"
                                                         alt=""></label>
                        </div>
                        <div class="formR formR_text">
                            已成功加入到您的作业中，<br>
                            您可以在您的作业列表中查看该作业，布置给您的学生。
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

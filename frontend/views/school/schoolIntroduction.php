<?php

use common\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataKey;
use yii\helpers\Url;

/** @var common\models\pos\SeSchoolInfo $schoolModel */
/** @var common\models\pos\SeSchoolSummary $schoolSummary */
/** @var yii\web\View $this */
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=8;IE=10;IE=11;IE=Edge">
    <title>班海-学校简介-<?=$schoolModel->schoolName?></title>
    <link href="<?php echo BH_CDN_RES.'/static' ?>/css/base.css<?= RESOURCES_VER?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BH_CDN_RES.'/static' ?>/css/school_introduction.min.css<?= RESOURCES_VER?>" rel="stylesheet" type="text/css">
    <script src="<?= BH_CDN_RES.'/static' ?>/js/jquery.js<?=RESOURCES_VER ?>" type="text/javascript"></script>
    <script data-main="<?= BH_CDN_RES.'/static' ?>/js/app/school/main_school_introduction.js<?=RESOURCES_VER ?>" src="<?= BH_CDN_RES.'/static' ?>/js/require.js<?=RESOURCES_VER ?>"></script>
</head>
<body class="personnel">
<?php if($this->beginCache(WebDataKey::WEB_SCHOOL_SUMMARY_CACHE_KEY . $schoolModel->schoolID, ['duration' => 3600])){ ?>
    <div class="hf_info">
        <div class="header"><a href="<?=Url::to('/') ?>"><img src="<?php echo BH_CDN_RES.'/static'?>/images/logo_sch.png" alt=""></a>客服热线 : 400-8986-838</div>
    </div>

    <div class="container_col910">
        <div class="pd25 clearfix">
            <?php if(!empty($schoolModel->logoUrl)){ ?>
                <div class="logoimg">
                    <img class="sch_logo" src="<?=$schoolModel->logoUrl?>" alt="">
                </div>
            <?php }
            if(empty($schoolSummary)) {
                echo ViewHelper::emptyView("本学校暂无简介，请到学校管理后台添加！");
            }else{?>
                <div class="content" id="contentImg">
                    <?php echo StringHelper::replacePath($schoolSummary->brief); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="hf_info footer">
        <div class="foot_content">
            <div class="address clearfix">
                <div class="weChat">
                    官方微信
                    <div class="weChatIcon" id="weChatIcon">
                        <div class="weChatBigIcon pop" id="weChatBigIcon" style="display: none;">
                            <h1>扫一扫 关注班海微信</h1>
                            <img src="<?php echo BH_CDN_RES.'/static'?>/images/gnn_QRCode_09.jpg">
                        </div>
                    </div>
                </div>
                <div class="copyright">北京三海教育科技有限公司 ©版权所有 <a class="icpCode" href="http://www.miibeian.gov.cn/" target="_blank">京ICP备14022510号</a>
                    <a href="http://www.beian.gov.cn/portal/index" target="_blank" style="color: #999"><img src="/pub/images/ghs.png" alt="">京公网安备 11010802023163 号</a>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endCache();
} ?>
<!--主体end-->
</body>
</html>

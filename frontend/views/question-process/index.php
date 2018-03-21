<!doctype html>
<html id="html">
<head>
<title></title>
    <link href="<?php echo BH_CDN_RES.'/static' ?>/css/base.css<?= RESOURCES_VER?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BH_CDN_RES.'/static' ?>/css/platform.css<?= RESOURCES_VER?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BH_CDN_RES.'/static' ?>/css/sUI.css<?= RESOURCES_VER?>" rel="stylesheet" type="text/css">
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/5
 * Time: 18:22
 */

use yii\helpers\Html;
use frontend\components\helper\ViewHelper;

?>

<div class="main col1200 clearfix" >
    <div class="content">
        <div class="container  classify no_bg topic_list">
            <div class="testPaper">
                <?php  if(!empty($testQuestion)){
                    echo  str_replace('show_aswerBtn','show_aswerBtn icoBtn_close',str_replace('class="quest"','class="quest A_cont_show"',$this->render('//publicView/topic_preview/_itemPreviewType',['item'=>$testQuestion])))  ;
                 }else{
                    echo ViewHelper::emptyView("暂无此题目！");
                }?>
            </div>
        </div>
    </div>
</div>
</body>


</html>
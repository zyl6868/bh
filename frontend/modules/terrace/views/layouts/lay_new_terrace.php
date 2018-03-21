<?php
/**
 * Created by yangjie
 * User: Administrator
 * Date: 15-4-13
 * Time: 上午9:48
 */

/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main.php');
$this->blocks['bodyclass'] = "platform";
$this->registerCssFile(BH_CDN_RES.'/pub/css/platform.css'.RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES.'/pub/js/ztree/zTreeStyle/zTreeStyle.css'.RESOURCES_VER);

$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine.min.js'.RESOURCES_VER,[ 'position'=>\yii\web\View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine-zh_CN.js'.RESOURCES_VER,[ 'position'=>\yii\web\View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/ztree/jquery.ztree.all-3.5.min.js'.RESOURCES_VER,[ 'position'=>\yii\web\View::POS_HEAD] );

?>

<div class="cont24">
    <div class="grid24 main">
        <?php echo $content ?>
    </div>
</div>
<?php $this->endContent() ?>

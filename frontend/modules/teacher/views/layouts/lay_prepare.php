<?php
/**
 * Created by yangjie
 * User: Administrator
 * Date: 15-4-13
 * Time: 上午9:48
 */
use yii\web\View;

/** @var $this yii\web\view/ */
$this->beginContent('@app/views/layouts/main.php');
$this->blocks['bodyclass'] = "teacher";
$this->registerCssFile(BH_CDN_RES.'/pub/css/teacher.css'.RESOURCES_VER);

$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine.min.js'.RESOURCES_VER,[ 'position'=> View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/jquery.validationEngine-zh_CN.js'.RESOURCES_VER,[ 'position'=> View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/ztree/jquery.ztree.all-3.5.min.js'.RESOURCES_VER,[ 'position'=> View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/tree_fixed.js'.RESOURCES_VER,[ 'position'=>View::POS_HEAD] );
?>

<div class="cont24">
    <div class="grid24 main_r">
        <?php echo $content ?>
    </div>
</div>
<?php $this->endContent() ?>



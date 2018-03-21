<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/24
 * Time: 10:34
 */

/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main_v2.php');
$this->blocks['bodyclass'] = "platform";
$this->registerCssFile(BH_CDN_RES.'/static/css/platform.css'.RESOURCES_VER);
$this->registerJsFile(publicResources().'/pub/js/My97DatePicker/WdatePicker.js'.RESOURCES_VER);


?>
<?php echo $content ?>

<?php $this->endContent() ?>

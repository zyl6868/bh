<?php
/**
 * Created by yangjie
 * User: Administrator
 * Date: 14-9-19
 * Time: 上午9:56
 */
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/lay_class_has_image_header.php');
$this->registerCssFile(BH_CDN_RES.'/static/css/statistic.css'.RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/echarts/echarts.js' );

?>
<?php echo $content ?>

<?php $this->endContent() ?>

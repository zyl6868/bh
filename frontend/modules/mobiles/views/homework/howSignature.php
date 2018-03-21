<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-6-24
 * Time: 下午6:40
 */
use yii\web\View;

$this->title = '家长如何签字';
/* @var $this yii\web\View */
$this->registerCssFile(BH_CDN_RES . '/static/css/weChat.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static' . '/js/app/homework/flexible.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);


?>
<div class="wc_header">
    <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_01.jpg" alt="">
</div>
<div class="wc_content">
    <div class="clear_float">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_02.png" alt="" class="patriarch_02">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_03.jpg" alt="" class="patriarch_03">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_04.png" alt="" class="patriarch_04">

        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_05.jpg" alt="" class="patriarch_05">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_06.jpg" alt="" class="patriarch_06">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_07.jpg" alt="" class="patriarch_07">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_08.jpg" alt="" class="patriarch_08">

        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_09.jpg" alt="" class="patriarch_09">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_10.jpg" alt="" class="patriarch_10">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_11.jpg" alt="" class="patriarch_11">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_12.png" alt="" class="patriarch_12">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_13.jpg" alt="" class="patriarch_13">
    </div>
</div>
<div class="wc_footer">
    <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_14.jpg" alt="" class="patriarch_14">
    <div>
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_15.jpg" alt="" class="patriarch_15">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_16.jpg" alt="" class="patriarch_16">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_17.jpg" alt="" class="patriarch_17">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/patriarch_18.jpg" alt="" class="patriarch_18">
    </div>
</div>


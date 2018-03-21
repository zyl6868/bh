<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-7
 * Time: am 10:30
 */
use yii\web\View;

$this->registerCssFile(BH_CDN_RES . '/static/css/zhouzhoutong.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
?>
<img src="<?=BH_CDN_RES;?>/static/images/zhouzhou.png" alt="">
<div class="center">
    <table cellspacing="0">
        <thead>
        <tr>
            <td>周周通会员</td>
            <td>周周通会员(VIP)</td>
            <td>额外学米</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>体验会员</td>
            <td>普通会员</td>
            <td>10</td>
        </tr>
        <tr>
            <td>体验会员</td>
            <td>银质会员</td>
            <td>10</td>
        </tr>
        <tr>
            <td>体验会员</td>
            <td>金质会员</td>
            <td>10</td>
        </tr>
        <tr class="noBorder">
            <td>正式会员</td>
            <td>钻石会员</td>
            <td>100</td>
        </tr>
        </tbody>
    </table>
    <footer>
        <p>在您使用过程中有任何问题，您可以联系我们</p>
        <p>服务热线：<strong>400-8986-838</strong></p>
    </footer>
</div>
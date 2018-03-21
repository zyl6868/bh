<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-14
 * Time: 上午10:46
 */
use yii\helpers\Url;

?>


<div class="nav">
    <a href="javascript:;" class="back" id="back">
        <img src="<?php BH_CDN_RES ?>/static/img/back.png">
    </a>
</div>
<div class="headerTitle clearfix">
    <div id="myErrWork">
        <a style="color: #000" href="<?= Url::to(['/web/weakness/error-questions/question-list', 'date' => $date]); ?>"><p id="myErrP">我的错题</p></a>
        <img src="<?php BH_CDN_RES ?>/static/img/selected.png" id="myErrImg">
    </div>
    <div id="weakSpot">
        <a href="<?= Url::to(['/web/weakness/weakness-kids/kids-list', 'date' => $date]); ?>"><p class="noSelected" id="weakP">薄弱知识点</p></a>
        <img src="<?php BH_CDN_RES ?>/static/img/selected.png" class="noShow" id="weakImg">
    </div>
</div>


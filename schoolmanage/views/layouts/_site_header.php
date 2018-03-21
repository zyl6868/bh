<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/30
 * Time: 14:12
 */
?>
<div class="headWrap">
    <div class="col1200">
        <div class="head">
            <h1>学校后台管理中心</h1>
            <div class="userCenter">
                <div class="userChannel">
                    <?php if (!user()->isGuest) {?>
                    <?= loginUser()->username ?><a class="logoff" href="<?= url('site/logout') ?>">退出</a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
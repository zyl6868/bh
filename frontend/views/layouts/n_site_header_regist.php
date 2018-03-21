<?php if($this->context->isLogin()) {?>
    <div class="head reg_head">
        <div class="cont24">
            <a href="#"><h1>班海</h1></a>
            <div class="userCenter">
                <a class="userName" href="javascript:;"><i></i><?= loginUser()->getTrueName() ?></a><a href="<?= url('site/logout') ?>" class="logOff">退出</a>
            </div>
        </div>
    </div>
<?php }else{?>
    <div class="cont24">
        <div class="grid_19 push_3">
            <div class="top">
                <div class="topRight gray_d font12"> 我已注册,现在就 <a class="gray_hd" href="<?=url('site/login');?>">登录</a> </div>
            </div>
        </div>
    </div>
<?php }?>
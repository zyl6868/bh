<?php

$this->title="注册成功";
?>
<div class="gnn_container">
    <div class="content">
        <p class="congratulations">恭喜你！账号注册成功！</p>
        <p class="account">你的登录账号为：<span class="account"><?php echo $phoneReg;?></span></p>
        <a href="<?php echo url(['/site/login','username'=>$phoneReg])?>"  id="login" class="login">去登陆</a>
    </div>
</div>

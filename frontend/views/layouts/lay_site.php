<!doctype html>
<html id="html">
<head>
    <meta charset="utf-8">
    <link href="<?php echo publicResources() ?>/css/register.css" rel="stylesheet" type="text/css">
    <link href="<?php echo publicResources() ?>/css/base.css" rel="stylesheet" type="text/css">
    <script src="<?php echo publicResources() ?>/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo publicResources() ?>/js/base.js"></script>
    <script src="<?php echo publicResources() ?>/js/main.js"></script>
    <title><?php echo $this->getPageTitle(); ?></title>
</head>

<body style="background-color:#f4f4f4;">
<!--top----------------------->
<?php
echo $this->render('//layouts/_site_header');
?>
<!--topEnd------------------------------------------->

<!--main--------------------------------------------->
<?php echo $content; ?>
<!--mainEnd-->

<!--footer-->
<div>
    <?php
    echo $this->render('//layouts/_site_footer');
    ?>
</div>

<!--footEnd-->

<!--登录框-->
<div class="popBox loginBox hide">
    <h3>用户登录</h3>
    <span class="close">×</span>

    <form>
        <p class="userName">
            <input class="text" type="text" value="请输入用户名">
            <span class="altText"><i></i>用户名已存在</span></p>

        <p class="pwd">
            <input class="text" type="password">
            <span class="altText"><i></i>密码错误！！</span></p>

        <p class="code">
            <input class="text" value="请输入验证码" type="text">
            <img src="<?php echo publicResources() ?>/images/code.png"> <span>看不清？ <b>换一张</b></span> <span class="altText"><i></i> </span></p>

        <p>
            <input class="submit" type="submit" value="登录">
            <a href="#">忘记密码</a> | <a href="#">注册</a></p>
    </form>
</div>

<!--返回顶部-->
<div class="r_fixBox"><a href="javascript:" title="回到顶部" class="backTop">回到顶部</a></div>
</body>
</html>

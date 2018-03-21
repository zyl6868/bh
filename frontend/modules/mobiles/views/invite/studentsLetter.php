<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-5-3
 * Time: 下午6:02
 */

use yii\web\View;

$this->title = '邀请学生';
/* @var $this yii\web\View */
$this->registerCssFile(BH_CDN_RES . '/static/css/appStudentsLetter.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/clipboard.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);


?>
<div id="page">
    <img src="<?= BH_CDN_RES . '/static' ?>/images/letterBg.jpg" alt="" id="letterBg">
    <div id="main" class="clearfix">
        <h3 class="fBlue">
            hi，同学们：
        </h3>
        <p class="fBlue">我在班海布置了精品作业！快来和同学们一起加入班级共同进步吧！</p>
        <p class="fBlue">进班步骤：</p>
        <p class="fBlue">1.下载班海APP，注册学生账号；</p>
        <p class="fBlue">2.填写班级加入码  <u style="color: #fd5846"><?php echo $classInviteCode ?></u>  加入班级。</p>
        <div class="clearfix">
            <div class="classInviteCode"><?php echo $classInviteCode ?></div>
            <div id="copy" class="invite-code" data-clipboard-text="<?php echo $classInviteCode ?>">复制加入码</div>
        </div>
        <p class="fBlue" id="teacher"><?php echo $subjectName; ?>老师: <?php echo $trueName; ?></p>
        <div id="download">
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.sanhai.psdapp">下载注册班海APP</a>
        </div>
    </div>
    <div id="hint">成功复制到粘贴板</div>
</div>
<script>

    var clipboard = new Clipboard('.invite-code');
    var hint = document.getElementById('hint');
    clipboard.on('success', function (e) {
        hint.style.display = 'block';
        setTimeout(function () {
            hint.style.display = 'none'
        }, 1000)
    })
    clipboard.on('error', function (e) {
        hint.style.display = 'block';
        hint.innerHTML = '浏览器暂不支持，请手动复制';
        setTimeout(function () {
            hint.style.display = 'none'
        }, 1000)
    })
</script>
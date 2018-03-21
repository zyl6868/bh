<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-5-3
 * Time: 下午6:02
 */
use yii\captcha\Captcha;
use yii\web\View;
$this->title = '邀请老师';
/* @var $this yii\web\View */
$this->registerCssFile(BH_CDN_RES . '/static/css/inviteTeacher.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
$this->registerJsFile(BH_CDN_RES . '/static/js/clipboard.min.js' . RESOURCES_VER, ['position' => View::POS_HEAD]);
?>
<div class="wrapper">
    <div class="top">
        <img src="<?= BH_CDN_RES . '/static' ?>/images/topBg.png">
    </div>

    <div class="dsc">
        <div class="person clearfix">
            <img src="<?php echo $userImg ?>" onerror="userDefImg(this);">
            <div class="personInfo">
                <h5>我是<?php echo $trueName ?></h5>
                <p>我在使用班海，学生成绩提高了，批改作业也简单了，你也一起来吧~</p>
            </div>
        </div>

        <p class="dscBh">班海平台会为你提供免费海量教学资源，品类丰富的教学工具，为教师量身打造的交流平台，更有丰富礼品等你拿！</p>
    </div>

    <div class="btn">
        <span>1</span><p>使用真实的姓名和手机号注册教师账号，“<u>注册邀请码</u>” 填写下方邀请码。</p>
        <div class="inviteCode">
            <div class="codeTitle">
                注册邀请码
            </div>
            <p class="code" id="code"><?php echo $inviteCode ?></p>
            <a href="javascript:;" class="copyBtn" data-clipboard-text="<?php echo $inviteCode ?>">复制</a>
        </div>
        <span>2</span><p>点击下方按钮下载 <u>班海教师APP</u>，进入教师注册。</p>
        <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.sanhai.teacher" class="uploadBtn">下载班海教师APP</a>

    </div>
</div>
<div id="hint">成功复制到粘贴板</div>


<script type="text/javascript">
    var clipboard = new Clipboard('.copyBtn');
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

    function userDefImg(image) {
        image.src = '/pub/images/tx.jpg';
        image.onerror = null;
    }
</script>
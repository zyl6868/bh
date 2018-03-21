<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-6-24
 * Time: 下午3:40
 */
$this->title = '作业提醒';
?>
<style>
    body {
        background: #0575f4;
    }

    body, div {
        margin: 0;
    }

    .tc {
        text-align: center;
    }

    #homeWork {
        box-sizing: border-box;
        padding: 0 1em;
        background: white;
        width: 90%;
        border-radius: .7em;
        margin: 4em auto 0;
    }

    #teacher img {
        position: absolute;
        width: 3.6em;
        height: 3.6em;
        margin-left: -1.8em;
        margin-top: -1.8em;
        border-radius: 50%;
    }

    #teacher p {
        padding-top: 2em;
    }

    .homeWorkContent a {
        margin-left: .5em;
        display: inline-block;
        text-decoration: none;
        color: #0575f4;
        line-height: 1.5em;
        margin-top: .5em;
    }

    #requirements {
        padding: 2em 0 2em .5em;
    }

    #logo {
        padding-bottom: 1em;
    }

    #logo img {
        height: 2em;
    }

    #zhouzhou {
        margin-top: 2em;
        display: block;
        width: 100%;
    }

    #btn {
        width: 100%;
    }

    #btn img {
        width: 90%;
        margin: 0 auto;
        display: block;
    }
</style>
<div id="homeWork">
    <div id="teacher" class="tc">
        <img src="<?php echo $creatorHeadImgUrl?>" alt="">
        <p><?php echo $creatorName?>老师</p>
    </div>
    <div class="homeWorkContent">
        <div class="title">布置了作业:</div>
        <a href="javascript:;"><?php echo $homeworkName?></a>
        <div id="requirements">要求: 完成后家长签字</div>
        <div id="logo" class="tc">
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.sanhai.psdapp"><img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/logo.png" alt=""></a>
        </div>
    </div>
</div>
<a href="http://a.eqxiu.com/s/LRKPznxu" ><img id="zhouzhou" src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/zhouzhou.png" alt=""></a>
<a href="<?php echo \yii\helpers\Url::to('/mobiles/homework/how-signature')?>" id="btn">
    <img src="<?= BH_CDN_RES . '/static' ?>/images/homeworkSignature/btn.png" alt="">
</a>

<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-4-21
 * Time: 上午11:55
 */
use yii\helpers\StringHelper;

?>
<style>
    * {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    html {
        font-size: 0.31rem;
    }

    .good-main {
        float: left;
        text-align: center;
        margin: auto;
    }

    .good-content {
        float: left;
        margin: .7rem 0.15rem 1rem 0.15rem;
        display: block;
    }

    .good-show {
        float: left;
        width: 4.95rem;
        margin: 0rem 0.14rem 0.97rem 0.14rem;
    }

    .good-img {
        position: relative;
        width: 4.95rem;
        height: 3.28rem;
        margin-bottom: 0.66rem;
        display: block;
    }

    .good-img .VIPLogo {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 27%;
    }

    .good-img .imgList {
        width: 4.95rem;
        height: 3.28rem;
        font-size: 0.53rem;
        line-height: 3.28rem;
    }

    .good-text {
        width: 4.95rem;
        display: block;
    }

    .good-text p {
        font-size: 0.53rem;
    }

    .good-button {
        height: 0.6rem;
        font-size: 0.57rem;
        color: #0099ff;
    }

    #scoresWarn {
        text-align: left;
        color: #666;
        font-size: 0.6rem;
        margin: 0.7rem 0.3rem 0 0.3rem;
        line-height: 0.9rem;
    }

    #scoresWarn p {
        text-align: right;
    }

    .imgIco {
        font-size: 0.3rem;
        top: 0.2rem;
        left: 0.01rem;
        width: 3.5rem;
        height: 0.7rem;
        line-height: 0.7rem;
        color: white;
        background: rgb(253, 178, 20);
        position: absolute;
    }

    .imgIco:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        display: inline-block;
        height: 0;
        width: 0;
        border-right: 0.2rem solid rgba(0, 128, 0, 0);
        border-top: 0.7rem solid white;
    }

    .imgIco:after {
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        display: inline-block;
        height: 0;
        width: 0;
        border-right: 0.2rem solid rgb(206, 140, 0);
        border-top: 0.7rem solid rgba(0, 128, 0, 0);
    }

    .goodsName {
        font-size: 0.7rem;
        line-height: 0.8rem;
        height: 1.6rem;
        overflow: hidden;
        -ms-text-overflow: ellipsis;
        text-overflow: ellipsis;
        margin-bottom: 0.3rem;
        color: black;
    }
</style>
<script>
    window.onresize = window.onload = function () {
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 16 + 'px';
    };
</script>
<div class="good-main" style="text-align: center;width: 100%;">
    <div class="good-content" style="width: 100%">
        <?php if ($type == 1){?>

            <p style="font-size: 25px;text-align: center;margin-top: 200px" >学米商城升级中,敬请期待</p>

        <?php }else {
            if (count($goods) !== 0) { ?>

            <?php foreach ($goods as $key => $val) { ?>
                <div class="good-show">
                    <span class="good-img">
                        <?php if ($val->isShowAmount === 1) { ?>
                            <div class="imgIco">可兑换:<?php echo $val->amount ?></div>
                        <?php } ?>
                        <img class="imgList" src="<?php echo $val->image; ?>" title="<?php echo $val->name ?>">
                        <?php if ($val->isPrivilege === 1) { ?>
                            <img class="VIPLogo" src="<?php echo BH_CDN_RES . '/static/images/vipLogo.jpg'; ?>"
                                 alt="VIPLogo">
                        <?php } ?>
                    </span>

                    <span class="good-text">
                        <div class="goodsName"><?php echo StringHelper::truncate($val->name, 12,'...','utf-8') ?></div>
                        <p>所需学米：<span style="color: #fe7c2e"><?php echo $val->xueMi; ?></span></p>
                        <p style="margin:0.3rem 0;">已有<span
                                    style="color: #0099ff"><?php echo $val->exchangeNum; ?></span>人兑换</p>
                    </span>
                    <span>
                        <p class="good-button">请到电脑端兑换</p>
                    </span>
                </div>
            <?php }
            }
        } ?>
    </div>
</div>

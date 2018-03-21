<?php
/* @var $this yii\web\View */
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

//新添加两个js
$this->registerJsFile(BH_CDN_RES.'/pub/js/jwplayer/jwplayer.js'.RESOURCES_VER,[ 'position'=>\yii\web\View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/pub/js/jwplayer/jwplayer.html5.js'.RESOURCES_VER,[ 'position'=>\yii\web\View::POS_HEAD] );
$this->title="视频详情";
/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-8-19
 * Time: 下午6:01
 */
?>
    <!--主体-->
    <div class="cont24">
        <div class="grid24 main">
            <div class="video_topics">
                <div class="title">
                    <a href="<?= Url::to(array_merge(['/terrace/videopaper/video'],['paperId'=>$paperId])); ?>" class="txtBtn backBtn larrow"></a>
                    <h4>
                        视频详情</h4>
                </div>
                <div class="video_topics_con">
                    <?php if(!empty($videosResource)) : ?>
                    <div class="form_list video_detail_form">
                        <div class="formL">
                            <div id="sh_video">Loading the player...</div>
                        </div>
                        <div class="formR">
                            <h5> 目录</h5>
                            <ul id="videoList"  class="menu clearfix">
                                <?php foreach($videosResource as $key => $videoResource) : ?>
                                <li <?php echo $key == 0 ? 'class="play"' : '' ?> src="http://www.banhai.com/res<?= $videoResource->resFileUri ?>" >
                                    <i></i>
                                    <span><?= $key+1 ?></span>
                                    <em title="<?= $videoResource->title ?>">
                                        <?= \frontend\components\helper\StringHelper::cutStr($videoResource->title,15);?>
                                    </em>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php else : ?>
                        <?php ViewHelper::emptyView('此处暂无视频！') ?>
                    <?php endif; ?>
                    <div class="paper clearfix">
                        <span class="asnumber blue">01:</span>
                        <?php if(!empty($questionDetails)) : ?>
                        <p>
                            <span class="blue">【题文】</span><?= $questionDetails->content ?>
                            <br>
                        </p>
                        <?php else : ?>
                            <?php ViewHelper::emptyView() ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--主体end-->

<script>
    $(function() {
        jwplayer("sh_video").setup({
            flashplayer:"/pub/js/jwplayer/jwplayer.swf",
            width:870,
            height:640,
            file: "http://www.banhai.com/res<?=empty($videosResource)?'': $videosResource[0]->resFileUri?>",
            image: "/pub/js/jwplayer/player.jpg"
        });
        $('#videoList li').click(function(){
            $(this).addClass('play').siblings().removeClass('play');
            var video_src=$(this).attr('src');
            jwplayer("sh_video").setup({
                flashplayer:"/pub/js/jwplayer/jwplayer.swf",
                width:870,
                height:640,
                file:video_src,
                events: {
                    onReady:function() {this.play()}
                }
            })
        })
    });
</script>
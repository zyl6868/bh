<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/19
 * Time: 13:58
 */
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;

/* @var $this yii\web\View */
$this->title="视频库-详情";
//视频加载JS
$this->registerJsFile(BH_CDN_RES.'/static/js/jwplayer/jwplayer.js'.RESOURCES_VER);
$this->blocks['requireModule']='app/classes/tch_hmwk_veiw_ele';
?>
<div class="main col1200 clearfix platform_video_detail" id="requireModule" rel="app/classes/tch_hmwk_veiw_ele">
    <div class="container platform_detail_con">
        <a href="javascript:history.back(-1);" class="btn return_btn">返回</a>
        <div class="pd25">
            <div class="video_topics">
                <div class="video_topics_con">
                    <?php if(!empty($videoArray)){?>
                        <div class="form_list clearfix video_detail_form">
                            <div class="formL">
                                <div id="sh_video">Loading the player...</div>
                            </div>
                            <div class="formR">
                                <h5> 目录</h5>
                                <ul id="videoList" class="menu clearfix">
                                    <?php foreach($videoArray as $key=>$val){?>
                                        <li <?= $key == 0 ? 'class="play"' : '' ?> src="http://www.banhai.com/res<?= $val->resFileUri ?>" >
                                            <i></i>
                                            <span><?= $key+1 ?></span>
                                            <em title="<?= $val->title ?>"><?=StringHelper::cutStr($val->title,15) ?></em>
                                        </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    <?php }else{?>
                        <?php ViewHelper::emptyView(); ?>
                    <?php }?>
                    <div class="paper clearfix">
                       <?php if(!empty($question)){?>
                           <p><?=$question->processContent()?><br></p>
                       <?php }else{?>
                           <?php ViewHelper::emptyView(); ?>
                       <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        jwplayer("sh_video").setup({
            flashplayer:"/static/js/jwplayer/jwplayer.swf",
            width:870,
            height:640,
            file: "http://www.banhai.com/res<?=empty($videoArray)?'': $videoArray[0]->resFileUri?>",
            image: "/static/js/jwplayer/player.jpg"
        });
        $('#videoList li').click(function(){
            $(this).addClass('play').siblings().removeClass('play');
            var video_src=$(this).attr('src');
            jwplayer("sh_video").setup({
                flashplayer:"/static/js/jwplayer/jwplayer.swf",
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
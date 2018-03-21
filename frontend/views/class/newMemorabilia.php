<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/12/29
 * Time: 13:52
 */
use yii\helpers\Url;
use yii\web\View;

$this->title='大事记';
$this->blocks['requireModule']='app/classes/classes_memorabilia';
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.easing.1.3.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.galleryview-3.0-dev.js', [ 'position' => View::POS_HEAD] );
$this->registerJsFile(BH_CDN_RES.'/static/js/lib/GalleryView/jquery.timers-1.2.js', [ 'position' => View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/css/GalleryView/jquery.galleryview-3.0-dev.css', [ 'position' => View::POS_HEAD] );
?>
<div class="main clearfix classes_memorabilia col1200" id="requireModule" rel="app/classes/classes_memorabilia">
    <input id="classID" type="hidden" value="<?php echo $classID?>">
<div class="container alpha omega">
    <div class="sUI_pannel tab_pannel">
        <div class="pannel_l">
            <div class="sUI_tab">
                <ul class="tabList clearfix">
                    <li><a href="javascript:;" class="ac">时间轴模式</a></li>
                    <li><a href="<?php echo url::to(['/class/memorabilia-album','classId'=>$classID])?>">相册模式</a></li>
                </ul>
            </div>
        </div>
        <div class="pannel_r"><span><a id="addmemor_btn" type="button" class="btn btn40 bg_white" href="<?php echo url::to(['class/add-memorabilia','classId'=>$classID])?>">添加大事记</a></span></div>
    </div>
</div>
<div class="aside col340 alpha">
    <div id="timeLine" class="timeLine">
        <a href="javascript:;" class="time_gotoTop" id="time_gotoTop" >点击返回到顶部 <i></i></a>
        <div class="ulWrap" id="ulWrap">
            <ul id="time_line_list">
                <li style="visibility: hidden; height: 1px; overflow: hidden">
                    <a class="timeLine_year"></a>
                    <dl>
                        <dt class="timeLine_month"></dt>

                    </dl>
                </li>
            </ul>
        </div>
        <a id="time_addMore" class="time_addMore" href="javascript:;">点击查看更多 <i></i></a>
    </div>


</div>
<div class="container col830 omega memorabilia_detail">
    <?php  echo $this->render('_event_details',['eventDetail'=>empty($eventResult)?null:$eventResult[0]]) ?>
</div>
</div>


<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/8
 * Time: 11:57
 */
use yii\helpers\Url;

$this->title='大事记';
$this->registerCssFile(BH_CDN_RES.'/static/js/lib/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->blocks['requireModule']='app/classes/classes_memorabilia_album';
?>
<div class="main clearfix classes_album classes_memorabilia col1200" id="requireModule" rel="app/classes/classes_memorabilia_album">
    <input id="classID" type="hidden" value="<?php echo $classId?>">
    <div class="container alpha omega">
        <div class="sUI_pannel tab_pannel">
            <div class="pannel_l">
                <div class="sUI_tab">
                    <ul class="tabList clearfix">
                        <li><a href="<?php echo url::to(['/class/memorabilia','classId'=>$classId])?>">时间轴模式</a></li>
                        <li><a href="javascript:;" class="ac">相册模式</a></li>
                    </ul>
                </div>
            </div>
            <div class="pannel_r"><span><a id="addmemor_btn"  class="btn btn40 bg_white" href="<?php echo url::to(['/class/add-memorabilia','classId'=>$classId])?>">添加大事记</a></span></div>
        </div>
    </div>
    <div class="container album_year">
        <div class="pd25">
            <div id="timeLine" class="timeLine">
            <ul id="time_line_list">
                <li>
                    <a class="timeLine_year"></a>
                    <dl>
                        <dt class="timeLine_month"></dt>
                    </dl>
                </li>
                </ul>
                <a id="time_addMore" class="time_addMore" href="javascript:;">点击查看更多 <i></i></a>
                </div>
        </div>
    </div>
</div>

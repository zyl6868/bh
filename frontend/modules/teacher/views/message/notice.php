<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 14-12-11
 * Time: 下午6:59
 */
use yii\web\View;

/* @var $this yii\web\View */  $this->title="教师-系统消息";

$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_MyMessage.css'.RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_remind_message.css'.RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/teacher_remind_message';

?>

<div id="main" class="clearfix main" style="min-height:700px;"  >
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <?php echo $this->render('_message_nav')?>
    </div>
    <div id="main_right" class="main_right">
            <ul id="message" class="tab_sub">
                <li class="select"  data-messageType="507009">班海消息</li>
            </ul>
        <div class="tab_1 notice main_h4" id="notice">
            <?php echo $this->render('_notice_list',array('model'=>$model,'pages' => $pages));?>
        </div>

    </div>
</div>


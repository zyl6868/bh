<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/7/26
 * Time: 10:42
 */
use yii\helpers\Url;
use yii\web\View;
$this->title='教师-通知';
$this->registerJsFile(BH_CDN_RES.'/static/js/app/teacher/main_teacher_MyMessage.js'.RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES.'/static/css/teacher_MyMessage.css'.RESOURCES_VER,[ 'position'=> View::POS_HEAD] );
$this->registerCssFile(BH_CDN_RES.'/static/js/lib/fancyBox/jquery.fancybox.css'.RESOURCES_VER,[ 'position'=> View::POS_HEAD] );
?>

<!-- 主体 -->
<div id="main" class="clearfix main">
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <?php
        echo $this->render("_message_nav");
        ?>
    </div>
    <!-- 主题右侧 -->
    <div id="main_right" class="main_right" style="width:910px;">
        <!-- 右侧选项卡 -->
        <div id="tab" class="tab_sub">
            <ul>
                <li class="<?=$category==2?'select':''?>"><a href="<?=url::to(['/teacher/message/receiver','category'=>2])?>">我收到的</a></li>
                <li class="<?=$category==1?'select':''?>"><a href="<?=url::to(['/teacher/message/msg-contact','category'=>1])?>">我发出的</a></li>
                <li class="<?=$category==0?'select':''?>"><a href="<?=url::to(['/teacher/message/msg-contact','category'=>0])?>">未发送的</a></li>
            </ul>
            <a href="<?=url::to(['/teacher/message/add-contact-view'])?>" class="b_t">发布通知</a>
        </div>

        <?php if($category == 2){?>
            <div id="listDate" style="min-height:650px;">
                <?php echo $this->render('_new_list_view', array('modelList' => $modelList, 'pages' => $pages, 'category' => $category)); ?>
            </div>
        <?php }else{ ?>
            <div id="conDate" style="min-height:650px;">
                <?php echo $this->render('msg_contact', array('modelList' => $modelList, 'pages' => $pages, 'category' => $category)); ?>
            </div>
        <?php }?>
    </div>
</div>

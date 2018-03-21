<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/10/23
 * Time: 11:37
 */

use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\ViewHelper;
use common\components\WebDataKey;
use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var common\models\pos\SeClass $classModel */
$this->title = "班级主页";
$this->registerCssFile(BH_CDN_RES.'/static/js/lib/fancyBox/jquery.fancybox.css' . RESOURCES_VER);
$this->blocks['bodycss'] = 'classes';
$classId = $classModel->classID;
?>


<div class="container alpha omega">
    <div class="classes_cont">
        <?php
            echo $this->render('_class_index_statistics', ['classModel' => $classModel, 'isInClass' => $isInClass]);
        ?>
    </div>
</div>


<div class="container alpha clearfix">
    <div class="title_pannel sUI_pannel">
        <div class="pannel_l">
            <h4>班级新鲜事</h4></div>
        <div class="pannel_r"> <a href="javascript:;" class="blue_d" id="changeBrand" data-classId="<?php echo $classId;?>">换一换</a> </div>
    </div>
    <div class="pd25" id="attentionBrand">
        <?php echo $this->render('_class_index_something_new', ['homeworkInfoRel' => $homeworkInfoRel, 'answerInfo' => $answerInfo, 'classId' => $classId, 'classEventInfo' => $classEventInfo, 'isInClass' => $isInClass]); ?>
    </div>
</div>

<div class="container">
    <div class="title_pannel sUI_pannel">
        <div class="pannel_l">
            <h4>班级大事记</h4>
        </div>

        <div class="pannel_r">
            <a href="<?php echo Url::to(['class/memorabilia', 'classId' => $classId]) ?>"
               class="gray_d">●●●</a>
        </div>
    </div>

    <div class="big_events pd25">
        <div class="slider-box">

            <?php
            $eventPicDate = [];
            $eventIDs = [];
            foreach ($classEventList as $item) {
                $eventIDs[] = $item->eventID;
            }
            $eventPicDate = \common\models\pos\SeClassEventPic::eventPic($eventIDs);
            if (empty($eventPicDate)) {
                ViewHelper::emptyView('暂无班级大事记图片！');
            }else{ ?>

                <a class="btn_all prev" href="javascript:void(0);"></a>

                <div class="bd">
                    <ul class="image-row">
                        <?php
                            foreach($eventPicDate as $item){
                                ?>
                                <li>
                                    <a class="fancybox" href="<?php echo resCdn($item['picUrl']); ?>"
                                       data-fancybox-group="gallery">
                                        <img width="180" height="120"
                                             src="<?php echo ImagePathHelper::imgThumbnail($item['picUrl'],180,120); ?>"
                                             alt="">
                                    </a>

                                </li>
                            <?php
                        }?>
                    </ul>
                </div>
                <a class="btn_all next" href="javascript:void(0);"></a>
            <?php }?>
        </div>
    </div>
</div>

<div class="container">
    <div class="title_pannel sUI_pannel">
        <div class="pannel_l">
            <h4>班级成员</h4>
        </div>
        <div class="pannel_r">
            <a href="<?php echo Url::to(['class/member-manage', 'classId' => $classId]) ?>" class="gray_d">●●●</a>
        </div>
    </div>
    <?php
        echo $this->render('_class_index_member_list', ['classModel' => $classModel]);
    ?>
</div>


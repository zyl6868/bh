<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/5/15
 * Time: 10:09
 */

use common\helper\DateTimeHelper;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\StringHelper;
use yii\helpers\Html;

if (!isset($no)) {
    $no = '';
}
?>


        <li class="make_testpaperli">
            <div class="test_tite clearfix">
                <h4 class="fl " data-id='<?php echo $val->aqID;?>' nub="<?php echo $no; ?>">问题 <?php echo $no; ?>：</h4>
                <em class="fr"><?php echo date("Y-m-d H:i", DateTimeHelper::timestampDiv1000($val->createTime)); ?></em>
            </div>

            <div class="testpaperBox">
                <p><?php echo Html::encode($val->aqName); ?></p>
                <div class="gray_d"><?php echo StringHelper::htmlPurifier($val->aqDetail); ?></div>
                <?php
                //分离图片
                $img = ImagePathHelper::getPicUrlArray($val->imgUri);
                foreach($img as $k=>$imgSrc) {
                    ?>
                <a class="fancybox" href="<?php  echo $imgSrc; ?>" data-fancybox-group="gallery_<?= $val->aqID; ?>"><img class="lazy" width="120" height="90" data-original="<?=ImagePathHelper::imgThumbnail($imgSrc,120,90) ?>" alt=""></a>
                <?php  } ?>
            </div>
            <div class="test_BoxBtn clearfix" id="come_from<?php echo $val->aqID?>">
<!--	            来自头像-->
               <?php echo $this->render('//publicView/answer/_come_from',['val'=>$val])?>

            </div>
            <div class="test_BoxBtn clearfix" id="nav_list<?php echo $val->aqID?>">
<!--	           选择按钮-->
				<?php echo $this->render('//publicView/answer/_nav_list',['val'=>$val]);?>
            </div>
            <div class="answerBigBox answerBigBox<?php echo $val->aqID; ?> ">
                <div class="answerBox answerM ">
                    <em class="arrow" style="left:28px;"></em>
                    <div class="editor">
                        <textarea style="width: 740px;" class="textarea textarea_js<?php echo $val->aqID;?>"></textarea>
                        <p class="BtnBox" style="margin-top: 10px; margin-bottom: 10px;">
                            <a href="javascript:;" class="a_button bg_blue w80 rep_btn red_btn_js2" val="<?php echo $val->aqID;?>">回答</a>
                            <a class="a_button bg_blue_l w80 cancel_btn area_closeJs">取消</a>
                        </p>
                    </div>
                </div>
                <div class="answerBox answerW ">
                    <em class="arrow" style="left:128px;"></em>
                    <div class="answerBox_list" id="reply_list<?php echo $val->aqID;?>">
                    </div>
                </div>
            </div>

        </li>


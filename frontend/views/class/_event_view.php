<div class="cl_box clearfix">
<?php use frontend\components\helper\ImagePathHelper;

if($history->historyEvent ==0){?>
    <div class="clt clearfix"><span class="timer">
            <?php $str = str_replace('-', '年', $history->createTime);
            echo substr_replace($str, '月', 9);
            ?>
            </span>

        <p><?php echo cut_str($history->eventName,16); ?></p>
        <i class="time"><?php echo cut_str($history->createTime,10,'');?></i>
    </div>
    <div class="describe">
        <p><i>描述：</i><?php echo cut_str($history->briefOfEvent,65); ?></p>
        <ul class="desc_list clearfix">
            <?php
            foreach (ImagePathHelper::getPicUrlArray($history->url) as $img) {
                ?>
                <li style="width: 70px;height: 70px;"><img src="<?php echo resCdn() . $img; ?>" style="height: 70px;width: 70px;"></li>
            <?php
            }
            ?>
        </ul>
    </div>
<?php }elseif($history->historyEvent ==1){?>

    <div class="clt clearfix"><span class="timer">
             <?php $str = str_replace('-', '年', $history->eventINfo[0]->createTime);
             echo substr_replace($str, '月', 9);?></span>
    <?php foreach($history->eventINfo as $key=>$item){?>
        <p><?php echo cut_str($item->eventName,16); ?></p><i class="time"><?php echo cut_str($item->createTime,10,'');?></i>

    <?php } ?>
    </div>



<?php }?>
</div>


<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/10/23
 * Time: 10:09
 */
?>
<div class="business_card ">
    <div class="head_portrait">
        <div class="headPic">
            <div class="mkPic"><img src="http://f.kehai.com/file/userFace/<?=$data->userId?>.r"></div>
            <h4 class="names"><?=$data->nickName?></h4>
        </div>
    </div>
    <div class="card_con">
        <div class="mark"> <i></i>大学生 </div>
        <div class="address"> <i></i>
            <p title="<?=$data->school?>">就读于&nbsp;&nbsp;<?=$data->school?></p>
            <?php foreach($data->list as $v){?>
            <p title="<?=$v->schoolName?>">毕业于&nbsp;&nbsp;<?=$v->schoolName?></p>
            <?php }?>
        </div>
    </div>
    <i class="triangle"></i> </div>
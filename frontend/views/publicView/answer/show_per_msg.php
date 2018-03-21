<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/10/22
 * Time: 13:55
 */
use common\components\WebDataCache;

?>
<div class="business_card userCard" id="userCard" >
    <div class="head_portrait">
        <div class="headPic">
            <div class="mkPic"><img  onerror="userDefImg(this);" src="<?=WebDataCache::getFaceIconUserId($userID)?>"></div>
            <h4 class="names"><?=$data->trueName?></h4>
        </div>
    </div>
    <div class="card_con">
        <?php if($data->type==1){
           $subjectName= WebDataCache::getDictionaryName($data->subjectID)
            ?>
        <div class="mark"> <i></i>老师 <span class="objClip"> <em class="<?=\frontend\components\helper\PinYinHelper::firstChineseToPin($subjectName)?>"><?php echo mb_substr($subjectName,0,1,'utf-8');?></em> </span>
        </div>
        <?php }else{?>
            <div class="mark"> <i></i>学生
            </div>
        <?php }?>
        <div class="address"> <i></i>
           <?php $schoolName=WebDataCache::getSchoolNameBySchoolId($data->schoolID)?>
            <p title="<?=$schoolName?>">就<?=$data->type==1?'职':'读'?>于&nbsp;&nbsp;<?=$schoolName?></p>
        </div>
    </div>
    <i class="triangle"></i> </div>
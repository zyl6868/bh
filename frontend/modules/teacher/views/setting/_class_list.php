<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2015/7/1
 * Time: 16:40
 */
?>
<div class="popCont">
    <div class="new_tch_group">
        <div class="subTitleBar_box">
            <ul class="resultList clearfix">
                <?php foreach($userClass as $val){?>
                <li   data-id="<?=$val->classID?>"><?=$val->className ?></li>
                <?php }?>
            </ul>
        </div>
    </div>
</div>

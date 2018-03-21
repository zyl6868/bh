<?php
?>
<div class="myScores main_h4">
    <h4 class="title_pannel sUI_pannel" style="padding:0;">
        <i></i><span>我的学米</span>
    </h4>
    <div class="scores pd25">
        <ul class="">
            <li><span><?php echo !empty($todayAccount) ? $todayAccount :0;?></span>今日学米</li>
            <li><span><?php echo !empty($myAccount) ? $myAccount :0;?></span>我的学米</li>
        </ul>
    </div>
</div>


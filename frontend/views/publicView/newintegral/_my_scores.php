<?php
/**
 * @var array $model
 * @var integer $todayPoints
 * @var integer $totalPoints
 * @var object $gradePoints
 */
?>
<div class="myScores main_h4">
    <h4 class="title_pannel sUI_pannel" style="padding:0;">
        <i></i><span>我的积分</span>
    </h4>
    <div class="scores pd25">
        <ul class="score">
            <li><span><?= !empty($todayPoints)?$todayPoints:0;?></span>今日积分</li>
            <li><span></span></li>
            <li><span><?= !empty($totalPoints)?$totalPoints:0;?></span>我的积分</li>
            <i class="scoreArrow"></i>
        </ul>
            <p>等级：<a href="javascript:;"><?php echo $gradePoints->gradeName;?></a></p>
            <div class="percent">
                <?php $endPoints = $gradePoints->endPoints <= 99999 ? $gradePoints->endPoints : 99999 ;?>
                <div class="percentRate" style="width:<?php echo ceil(($totalPoints/$endPoints)*100)?>%;">
                    <div class="percentNumWhite"><em><?= $totalPoints;?></em><em>/</em><em><?php echo $endPoints;?></em></div>
                </div>
                <div class="percentNumBlue"><em><?= $totalPoints;?></em><em>/</em><em><?php echo $endPoints;?></em></div>
            </div>
    </div>
</div>


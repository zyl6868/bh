<?php
$this->title='学米收入明细';
$this->registerCssFile(BH_CDN_RES.'/static' .'/css/teacher_treasure.css'.RESOURCES_VER);
$this->blocks['requireModule']='app/teacher/teacher_treasure';
?>

<div id="main" class="clearfix main" style="min-height: 750px">
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <!-- 选项卡 -->
        <ul class="main_tab bg_fff">
            <?php if($user->type==1){?>
                <li id="select" class="select_income"><a href="<?=Url(['/teacher/mytreasure/treasure-details'])?>">学米明细</a></li>
            <?php }else{?>
                <li ><a href="<?=Url(['/student/mytreasure/my-treasure'])?>">我的学米</a></li>
                <li id="select" class="select_income"><a href="<?=Url(['/student/mytreasure/treasure-details'])?>">学米明细</a></li>
            <?php } ?>
        </ul>
        <!-- 收入明细 -->
        <div id="tab_1" class="tab_class bg_fff class_fff">
            <p id="convertXM"><span class="convertName">我的学米: </span>
                <span class="convertNum"><?php echo $myAccount;?></span>
                <a href="javascript:void();" class="expend">请在手机兑换奖品 </a>
            </p>
            <div class="conversion">
                <a href="<?php if($user->type==1){echo Url(['/teacher/mytreasure/rules']);}else{echo Url(['/student/mytreasure/rules']);}?>">查看学米规则</a>
                <i class="whyIcon"></i>
            </div>
            <div id="update" class="update">
                <?php  echo $this->render("_treasure_details",['user'=>$user,'model'=>$model,'pages'=>$pages]); ?>
            </div>
        </div>
    </div>

    <!-- 主题右侧 我的积分 -->
    <div id="main_right" class="main_right">
        <?php echo $this->render("_my_treasure",['user'=>$user,'myAccount'=>$myAccount,'todayAccount'=>$todayAccount]);?>
    </div>
</div>
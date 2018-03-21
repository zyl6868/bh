<?php
/**
 * @var object $user
 * @var object $model
 * @var integer $todayPoints
 * @var integer $totalPoints
 * @var integer $points
 * @var object $gradePoints
 */
$this->title='积分收入明细';
$this->registerCssFile(BH_CDN_RES.'/static' .'/css/teacher_integral.css'.RESOURCES_VER);
$this->blocks['requireModule']='app/teacher/teacher_integral';
?>

<div id="main" class="clearfix main" style="min-height: 750px">
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <!-- 选项卡 -->
        <ul class="main_tab bg_fff">
            <?php if($user->type==1){?>
                <li ><a href="<?=Url(['/teacher/integral/my-ranking'])?>">我的积分</a></li>
                <li id="select" class="select_income"><a href="<?=Url(['/teacher/integral/income-details'])?>">积分明细</a></li>

            <?php }else{?>
                <li ><a href="<?=Url(['/student/integral/my-ranking'])?>">我的积分</a></li>
                <li id="select" class="select_income"><a href="<?=Url(['/student/integral/income-details'])?>">积分明细</a></li>

            <?php } ?>
        </ul>
        <!-- 收入明细 -->
        <div id="tab_1" class="tab_class bg_fff class_fff tchIntegral">
            <div class="integralDetail">
                <?php if($user->type==1){?>
                    <a class="" href="<?=Url(['/teacher/integral/rules'])?>">查看积分规则</a><span></span>
                <?php }else{?>
                    <a class="" href="<?=Url(['/student/integral/rules'])?>">查看积分规则</a><span></span>
                <?php } ?>
            </div>
            <div id="update" class="update">
                <?php  echo $this->render("_income_list", array("pages" => $pages, 'model' => $model)); ?>
            </div>
        </div>
    </div>
    <!-- 主题右侧 我的积分 -->
    <div id="main_right" class="main_right">
        <?php echo $this->render("_my_scores",['totalPoints'=>$totalPoints,'todayPoints'=>$todayPoints,'gradePoints'=>$gradePoints]);?>
    </div>
</div>
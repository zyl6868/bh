<?php
/**
 * @var array $model
 */
$this->title='我的学米';
$this->registerCssFile(BH_CDN_RES.'/static' .'/css/teacher_treasure.css'.RESOURCES_VER);
$this->blocks['requireModule']='app/teacher/teacher_treasure';
?>

<div id="main" class="clearfix main" style="min-height: 750px">
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <!-- 选项卡 -->
        <ul class="main_tab bg_fff">
            <li id="select" class="select_income"><a href="<?=Url(['/student/mytreasure/my-treasure'])?>">我的学米</a></li>
            <li ><a href="<?=Url(['/student/mytreasure/treasure-details'])?>">学米明细</a></li>
        </ul>
        <!-- 学米明细 -->
        <div id="tab_1" class="tab_class bg_fff class_fff">
            <div class="ranking">
                <span class="order select" rankVal=1 >全国排名</span>
                <span class="order" rankVal=2>本校排名</span>
                <span class="order" rankVal=3>本班排名</span>
            </div>
            <div id="update" class="update">
                <?php  echo $this->render("_treasure_list",['user'=>$user,'xuemiRankingResult'=>$xuemiRankingResult]) ?>
            </div>
        </div>
    </div>

    <!-- 主题右侧 我的学米 -->
    <div id="main_right" class="main_right">
        <?php echo $this->render("_my_treasure",['user'=>$user,'myAccount'=>$myAccount,'todayAccount'=>$todayAccount]);?>
    </div>
</div>
<script>
    $(function () {
        $('.order').click(function () {
            $('.order').removeClass('select');
            $(this).addClass('select');
            var rankVal = $(this).attr('rankVal');
            $.get('<?php Url(['/student/mytreasure/my-treasure'])?>',{rankVal:rankVal},function (result) {
                $(".update").html(result);
            })


        })
    })
</script>
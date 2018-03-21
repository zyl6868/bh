<?php
/**
 * @var array $dataList
 * @var integer $todayPoints
 * @var integer $totalPoints
 * @var integer $points
 * @var object $gradePoints
 * @var integer $category
 * @var object $user
 */
$this->title = '我的等级';
$this->registerCssFile(BH_CDN_RES . '/static' . '/css/teacher_integral.css'.RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/teacher_integral'; ?>
<div id="main" class="clearfix main">
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <!-- 选项卡 -->
        <ul class="main_tab bg_fff">
            <?php if ($user->type == 1) { ?>
                <li id="select" class="select_income"><a href="<?= Url(['/teacher/integral/my-ranking']) ?>">我的积分</a>
                </li>
                <li><a href="<?= Url(['/teacher/integral/income-details']) ?>">积分明细</a></li>
            <?php } else { ?>
                <li id="select" class="select_income"><a href="<?= Url(['/student/integral/my-ranking']) ?>">我的积分</a>
                </li>
                <li><a href="<?= Url(['/student/integral/income-details']) ?>">积分明细</a></li>
            <?php } ?>
        </ul>

        <div id="center">
            <ul class="integralLists clearfix">
                <li><a href="javascript:;" class="order none ac" category=1>全国排名</a></li>
                <li><a href="javascript:;" class="order none" category=2>本校排名</a></li>

                <?php if ($user->type == 0) { ?>
                    <li><a href="javascript:;" class="order none" category=3>本班排名</a></li>
                <?php } ?>
            </ul>
            <div id="update" class="update">
                <p>正在加载……</p>
            </div>
        </div>
    </div>

    <!-- 主题右侧 我的积分 -->
    <div id="main_right" class="main_right">
        <?php echo $this->render("_my_scores", ['totalPoints' => $totalPoints, 'todayPoints' => $todayPoints, 'gradePoints' => $gradePoints]); ?>
    </div>
</div>
<script>

    (function () {

        var category = 1;
        getRanking(category);
        <?php
        if ($user->type == 1) {
            $url = Url(['/teacher/integral/my-ranking']);
        } else {
            $url = Url(['/student/integral/my-ranking']);
        }
        ?>
        function getRanking(category) {
            $.get('<?php echo $url;?>', {category: category}, function (result) {
                $(".update").html(result);
            })
        }

        $('.order').click(function () {
            $('.order').removeClass('ac');
            $(this).addClass('ac');
            var category = $(this).attr('category');
            getRanking(category);
        })

    })()
</script>



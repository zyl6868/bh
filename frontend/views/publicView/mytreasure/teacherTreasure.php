<?php
/**
 * @var array $model
 */
use frontend\components\helper\ViewHelper;

$this->title = '我的学米';
$this->registerCssFile(BH_CDN_RES . '/static' . '/css/teacher_treasure.css'.RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/teacher_treasure';
?>

<div id="main" class="clearfix main" style="min-height: 750px">
    <!-- 主体左侧 -->
    <div id="main_left" class="main_left">
        <!-- 选项卡 -->
        <ul class="main_tab bg_fff">
            <li id="select" class="select_income"><a
                        href="<?= Url(['/teacher/mytreasure/teacher-treasure']) ?>">我的学米</a></li>
            <li><a href="<?= Url(['/teacher/mytreasure/treasure-details']) ?>">学米明细</a></li>
        </ul>
        <!-- 学米明细 -->
        <div id="tab_1" class="tab_class bg_fff class_fff">
            <p id="convertXM"><span class="convertName">结转学米: </span><span class="convertNum"><?php echo $convertXuemiCount;?></span> <a href="<?= Url(['/teacher/mytreasure/treasure-exchange','accountType'=>1])?>" class="expend">兑换</a></p>
            <ul id="xuemi">

            </ul>
            <p id="addMore">点击加载更多 <span>↓</span></p>
        </div>
    </div>

    <!-- 主题右侧 我的学米 -->
    <div id="main_right" class="main_right">
        <?php echo $this->render("_my_treasure", ['user' => $user, 'myAccount' => $myAccount, 'todayAccount' => $todayAccount]); ?>
    </div>
</div>
<script>


    (function () {

        function addYear(year) {
            return '<li class="clearfloat">' +
                '<div class="year fl"><span>' + year + '</span>年</div>';
        }

        function addMonth(month, total,year,monthAccountId) {
            return '<li class="month clearfloat">' +
                '<div class="fl">' + +month + '月</div>' +
                '<p class="fl">' +
                '<span class="count1">' + +month + '月份余额</span>' +
                '<span class="count2">' + total + '</span>' +
                '<a href="/teacher/mytreasure/treasure-exchange?year='+year+'&month='+month+'" class="expend">兑换</a>' +
                '<a href="javascript:;" monthAccountId="'+monthAccountId+'" class="convert">结转</a>' +
                '</p>' +
                '</li>' +
                '<li class="line"></li>'
        }

        /**
         * 创建学米流水DOM
         * @returns {string}
         */
        function createDom() {
            var thisYear = 0;
            var domText = '';
            $.each(xuemiArr, function (item, value) {
                var time = value.time.split('-');
                var year = time[0];
                var month = time[1];
                var monthAccountId = value.monthAccountId;
                if (year !== thisYear) {
                    thisYear = year;
                    if (item !== 0) {
                        domText += '</ul></li>';
                    }
                    domText += addYear(thisYear);
                    domText += '<ul class="fl list"><li class="start"><img src="<?= BH_CDN_RES . '/static' ?>/images/dot.png" alt=""></li><li class="line"></li>';
                }
                domText += addMonth(month, value.incomeTotal - value.costTotal,year,monthAccountId);
            });
            return domText;
        }

        var page = 1; // 当前页码
        var xuemiArr = []; // 存储数据
        xuemiDOM();
        function xuemiDOM() {
            $.get('<?php echo Url(['/teacher/mytreasure/get-month-list'])?>', {page: page}, function (result) {
                var pageCount = result.pageCount;
                xuemiArr = xuemiArr.concat(result.list);
                // 如果最后一页隐藏加载更多
                if (page * 3 >= pageCount) {
                    $('#addMore').hide();
                }
                if(xuemiArr==''){
                    return $('#xuemi').html("<?php ViewHelper::emptyView();?>");
                }
                // 更新DOM
                $('#xuemi').html(createDom());
                page++;
            });
        }

        $('#addMore').click(xuemiDOM);

    })()


</script>

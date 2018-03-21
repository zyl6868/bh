<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 13:40
 */
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

?>

<div class="testPaper">

    <?php if (!empty($dataList)) {
        foreach ($dataList as $item) {
            echo $this->render('_itemPreviewType', ['item' => $item]);
        }
    } else {
        ViewHelper::emptyViewByPage($pages);
    }?>
</div>

<div class="page">
    <?php
    echo \frontend\components\CLinkPagerExt::widget(
        array(
            'pagination' => $pages,
            'updateId' => '.content',
            'maxButtonCount' => 8,
            'showjump'=>true
        )
    )
    ?>
</div>

<script>
    require(['app/platform/platform_common'], function (platform_question_point) {
        platform_question_point.answerShowAndHide();
    });

    $(function () {
        var questionIDArray = [];
        $('.quest').each(function (index, el) {
            var questionID = $(el).attr('data-content-id');
            questionIDArray.push(questionID);
        });
        //添加选题篮
        $('.join_basket_btn').click(function () {
            var _this = $(this);
            var pa = _this.parents('.quest');
            var cartId = $('.ico_basket').attr('cartId');
            var questionID = $(this).parents('.quest').attr('data-content-id');
            if (!pa.hasClass('join_basket')) {

                if ($('.ico_basket').next('.q_num').html() < 50) {
                    $.post('<?=Url::to(['/basket/add-cart-questions'])?>', {
                        cartId: cartId,
                        questionID: questionID
                    }, function (result) {
                        var numDom = $('.q_num');
                        var num = parseInt(numDom.html()) + 1;
                        numDom.html(num);
                        pa.addClass('join_basket');
                    })
                } else {
                    require(['popBox'], function (popBox) {
                        popBox.errorBox('选题篮中最多放50道题');
                    });
                }
            } else {
                $.post('<?=Url::to(["/basket/del-question"])?>', {
                    cartId: cartId,
                    questionID: questionID
                }, function (result) {
                    var numDom = $('.q_num');
                    var num = parseInt(numDom.html()) - 1;
                    numDom.html(num);
                    pa.removeClass('join_basket');
                })
            }

        });

        var department = $('#quest_basket').attr('department');
        var subject = $('#quest_basket').attr('subject');
//        判断选题篮是否存在，不存在生成选题篮
        $.post("<?=Url::to(['/basket/get-question-cart'])?>", {
            department: department,
            subject: subject
        }, function (result) {
            $('#quest_basket').find('i').attr('cartId', result.data.cartId);
            $('#quest_basket').find('em').html(result.data.num);
        });
//        加载整个页面判断题目是否已经加入选题篮
        $.post("<?=Url::to(['/basket/if-in-cart'])?>", {
            department: department,
            subject: subject,
            questionIDArray: questionIDArray
        }, function (result) {
            var questionIDArray = result.data;
            $('.quest').each(function (index, el) {
                if ($.inArray($(el).attr('data-content-id'), questionIDArray) > -1) {
                    $(el).addClass('join_basket');
                }
            });
        });


    });

    jumpUrl = function () {
        var cartId = $('.ico_basket').attr('cartId');
        if ($('.ico_basket').next('.q_num').html() > 0) {
            window.location.href = "<?=Url::to(['/basket/index'])?>" + "?cartId=" + cartId
        } else {
            require(['popBox'], function (popBox) {
                popBox.errorBox('当前选题篮是空的');
            });
        }
    };


</script>
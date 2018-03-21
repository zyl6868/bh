<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 10:49
 */
use common\components\WebDataCache;

/** @var common\models\search\Es_testQuestion $item */
/* @var $this \yii\web\View */


?>

<div class="quest" data-content-id="<?= $item->id ?>">
    <div class="sUI_pannel quest_title <?php if($item->isNewQuestion()){echo 'news';} ?>">
        <div class="pannel_l">
                <span class="Q_t_info"><input class="oneCheck" name="Check" value="<?php echo $item->id ?>" type="checkbox"/><em>试题编号：<?php echo $item->id ?></em><em><?= WebDataCache::getDictionaryName($item->tqtid) ?></em>
                    <?php if ($item->year != null) { ?>
                        <em><?php echo $item->year ?>年</em>
                    <?php } ?>
                    <em class="Q_difficulty">难度：<i
                            class="<?= \common\models\dicmodels\DegreeModel::model()->getIcon($item->complexity) ?>"></i></em></span>
        </div>
        <div class="pannel_r"><span><a href="javascript:;" class="join_basket_btn"></a></span></div>
    </div>

  <?php echo  $this->render('//publicView/topic_preview/_itemPreviewDetail',['item'=>$item]) ?>

</div>

<script>
    //选题统计数目
    $(".allCheck").prop("checked",false);
    $(".oneCheck").prop("checked",false);

    $.fn.extend({
        checkAll:function(arr){
            return this.each(function(){
                var _this = $(this);
                var num = 0;
                _this.click(function(){
                    if(_this.is(":checked")){
                        arr.prop("checked",true);
                        num = arr.length;
                    }else{
                        arr.prop("checked",false);
                        num = 0;
                    }
                });
                arr.each(function(){
                    $(this).click(function(){
                        if($(this).is(":checked")){
                            num++;
                        }else{
                            num--;
                        }
                        if(num == arr.length){
                            _this.prop("checked",true);
                        }else{
                            _this.prop("checked",false);
                        }
                    })
                })
            })
        }
    });
    $(".allCheck").checkAll($(".oneCheck"));

    //统计选中题数
    $('#questionNum').html(0);
    $('.allCheck').click(function(){
        var questionNum = $('.oneCheck:checked').length;
        $('#questionNum').html(questionNum);
    });
    $('.oneCheck').click(function(){
        var questionNum = $('.oneCheck:checked').length;
        $('#questionNum').html(questionNum);
    });
</script>

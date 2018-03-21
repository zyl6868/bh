<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-11-4
 * Time: 下午5:12
 */
use frontend\components\helper\ViewHelper;


/* @var MakepaperController $this */
/* @var  Pagination $pages */
?>
<div class="schResult">
    <div class="testPaperView pr">
        <div class="paperArea">

            <?php foreach ($list as $key => $item) {
                echo $this->render('_itemProblem', array('item' => $item));
            } ?>
        </div>
    </div>
</div>
<?php  ViewHelper::emptyViewByPage($pages); ?>
  <?php
     echo \frontend\components\CLinkPagerNormalExt::widget( array(
            'firstPageLabel'=>false,
            'lastPageLabel'=>false,
           'pagination'=>$pages,
            'updateId' => '#uploadId',
            'maxButtonCount' => 8
        )
    );
    ?>
<script type="text/javascript">

    $('.paperItemConts li[val]').each(function () {
        $id = $(this).attr('val');
        $('.paper button[id=' + $id + ']').each(function () {
            $(this).removeClass('addBtn').addClass('del_btn').text('删除');
        });
    });

    //查看答案与解析
    $('.openAnswerBtn').unbind('click').bind('click',function(){
        $(this).children('i').toggleClass('close');
        $(this).parents('.paper').find('.answerArea').toggle();
    });
</script>

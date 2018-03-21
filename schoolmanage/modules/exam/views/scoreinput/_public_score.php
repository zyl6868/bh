<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2016/2/23
 * Time: 14:29
 */
?>
<div class="sUI_pannel">
    <?php if(empty($status)):?>
    <div class="pannel_r">
        <span class="gray_l">所有班级的成绩录入完了  <button class="bg_blue publish_score" data-id="<?= app()->request->get('examId')?>">发布成绩</button></span>
    </div>
    <?php endif;?>
</div>

<script type="text/javascript">

    require(['popBox','jqueryUI','jquery_sanhai'],function(popBox){
        $('.publish_score').click(function(){
            var _this = $(this);
            popBox.confirmBox("确定要发布吗",function(){
                var examId = _this.attr('data-id');
                $.get('<?= \yii\helpers\Url::to(['publish-score'])?>' , {examId:examId} , function(data){
                    popBox.alertBox(data.data.message);
                });
            });
        });
    })

</script>
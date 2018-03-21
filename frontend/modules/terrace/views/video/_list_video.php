<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-18
 * Time: 上午11:01
 */
use frontend\components\helper\ViewHelper;

?>
<script type="text/javascript">
    $(function(){
        $('.showVideo').click(function(){
            var id = $(this).attr('datatype');
            location.href="<?= url('/terrace/video/video-details');?>"+"?id="+id;
        });
    })

</script>
<ul class="videoList clearfix">
    <?php if($model):?>
    <?php foreach($model as $val){?>
    <li>
        <h5><?= $val->title?></h5>
        <img src="/pub/images/video.jpg">
        <button type="button" class="w80 bg_blue_l showVideo" datatype="<?=$val->id?>">观看</button>
    </li>
    <?php }
    else:
        ViewHelper::emptyView();
    endif;
    ?>
</ul>
<br>


    <?php
     echo \frontend\components\CLinkPagerExt::widget( array(
           'pagination'=>$pages,
            'updateId' => '#video',
            'maxButtonCount' => 5
        )
    );
    ?>

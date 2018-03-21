<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-18
 * Time: 下午3:26
 */
use frontend\components\helper\ImagePathHelper;

?>
<script type="text/javascript">
    $(function () {
        $('.lookBtn').bind('click',function () {
            var $_this = $(this);
            var id = $_this.attr('collectID');
            var type = $_this.attr('typeId');
            var action = $_this.attr('action');

            $.post("<?php echo url('ku/material/add-material')?>", {id: id,type:type,action:action}, function (data) {
                if (data.success) {
                    if (action==1){
                        $_this.attr('action',0).text('取消收藏');
                    }
                    else {
                        $_this.attr('action',1).text('收藏');
                    }

                } else {
                    popBox.alertBox(data.message);

                }
            });
        });

        $('.conserveSearch').html('找到符合条件的结果约<?php echo  $pages->getItemCount() ?>条');
    })

</script>

<ul class="database_bottom_list clearfix">
    <?php foreach($model as $key=>$item){
        ?>
        <li class="clearfix">
            <img src="<?php echo  ImagePathHelper::getPicUrl($item->url) ?>" alt=" " />
            <h4>
                [<i><?php if($item->matType==1){?>
                       教案
                  <?php  }elseif($item->matType==2){?>
                       讲义
                   <?php }  ?>
                </i>]

                <a href="<?php echo url('ku/material/details',array('id'=>$item->id));?>"> <?php echo cut_str($item->name,10);?> </a>
            </h4>
            <p>简介：<?php echo cut_str($item->matDescribe,30);?></p>
            <a href="<?php echo url('ku/material/details',array('id'=>$item->id));?>">  <button class="lookBtn" type="button">
                预览</button></a>
            <?php if($item->isCollected ==0){?>
                <button class="lookBtn rem" action="1" type="button" collectID="<?php echo $item->id;?>" typeId="<?php echo $item->matType;?>">收藏</button>
           <?php }else{?>
                <button class="lookBtn rem" action="0" type="button" collectID="<?php echo $item->id;?>" typeId="<?php echo $item->matType;?>">取消收藏</button>
          <?php  }?>

        </li>
    <?php  }?>
</ul>

    <?php
     echo \frontend\components\CLinkPagerExt::widget( array(
           'pagination'=>$pages,
            'updateId' => '#material',
            'maxButtonCount' => 5
        )
    );
    ?>

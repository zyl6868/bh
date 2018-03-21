<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-8
 * Time: 下午3:09
 */
?>
<script type="text/javascript">

    $(function(){
        $('.Bookmark').bind('click', function () {
            var $_this = $(this);
            var id = $_this.attr('collectID');
            var action =$_this.attr('action');
            var type =$_this.attr('typeId');
            $.post("<?php echo url('teacher/default/add-material')?>", {id: id,type:type,action:action}, function (data) {
                if (data.success) {
                    if(action==1){
                        $_this.attr('action',0).text('取消收藏');
                    }else{
                        $_this.attr('action',1).text('收藏');
                    }
                } else {
                    popBox.alertBox(data.message);

                }
            });
        });
    })
</script>

<div class="item Ta_fav">
    <ul class="item_subList">
        <?php foreach($model as $key=>$item){
?>

                <li>
                    <img src="<?php echo publicResources();?>/images/iocPic2.png" alt="" />
                    <h5><?php if($item->favoriteType==1){?>
                            <a href="<?php echo url('teacher/default/detail',array('id'=>$item->favoriteId,'teacherId'=>$teacherId));?>"><em>
                                    [教案]</em><?php echo $item->headLine;?></a>
                        <?php   }elseif($item->favoriteType==2){?>
                            <a href="<?php echo url('teacher/default/detail',array('id'=>$item->favoriteId,'teacherId'=>$teacherId));?>"><em>[讲义]</em><?php echo $item->headLine;?></a>
                        <?php   }elseif($item->favoriteType==3){?>

                            <a href="<?php echo url('teacher/default/video-detail',array('id'=>$item->favoriteId,'teacherId'=>$teacherId));?>"><em>
                                    [视频]</em><?php echo $item->headLine;?></a>
                        <?php  } ?>
                    </h5>
                    <h6>简介：</h6>
                    <p><?php echo cut_str($item->brief,60);?></p>
                    <p> <?php if($item->favoriteType==3){?>
                            <a href="<?php echo url('teacher/default/video-detail',array('id'=>$item->favoriteId,'teacherId'=>$teacherId));?>" class="a_button bg_green preview" > 观看</a>
                        <?php  }else{?>
                            <a href="<?php echo url('teacher/default/detail',array('id'=>$item->favoriteId,'teacherId'=>$teacherId));?>"  class="a_button bg_green preview">   预览 </a>
                        <?php  } ?>
                        <?php if($item->isCollected==1){ ?>
                           <button  type="button" class="bg_orenge Bookmark"   action="0" collectID="<?php echo $item->favoriteId;?>" typeId="<?php echo $item->favoriteType;?>">取消收藏</button>
                        <?php  }else{ ?>
                           <button  type="button" class="bg_gray Bookmark"  action="1" collectID="<?php echo $item->favoriteId;?>"  typeId="<?php echo $item->favoriteType;?>">收藏</button>
                        <?php  }?>

                    </p>
                </li>

        <?php  }?>
    </ul>
</div>

    <?php
     echo \frontend\components\CLinkPagerExt::widget( array(
           'pagination'=>$pages,
            'updateId'=>'#collection',
            'maxButtonCount' => 5
        )
    );
    ?>
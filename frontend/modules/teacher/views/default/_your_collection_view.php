<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-8
 * Time: 下午3:08
 */
?>

<div class="item Ta_fav">
    <ul class="item_subList">
        <?php foreach($model as $key=>$item){
            ?>
                <li>
                    <img src="<?php echo publicResources();?>/images/iocPic2.png" alt="" />
                    <h5><?php if($item->favoriteType==1){?>
                            <a href="<?php echo url('teacher/collection/lesson-plan-detail',array('id'=>$item->favoriteId));?>"><em>
                                    [教案]</em><?php echo $item->headLine;?></a>
                        <?php   }elseif($item->favoriteType==2){?>
                            <a href="<?php echo url('teacher/collection/lesson-plan-detail',array('id'=>$item->favoriteId));?>"><em>[讲义]</em><?php echo $item->headLine;?></a>
                        <?php   }elseif($item->favoriteType==3){?>

                            <a href="<?php echo url('teacher/collection/video-detail',array('id'=>$item->favoriteId));?>"><em>
                                    [视频]</em><?php echo $item->headLine;?></a>
                        <?php  } ?>
                    </h5>
                    <h6>简介:</h6>
                    <p><?php echo cut_str($item->brief,60);?></p>
                    <p><?php if($item->favoriteType==3){?>
                            <a href="<?php echo url('teacher/collection/video-detail',array('id'=>$item->favoriteId));?>" class="a_button bg_green preview">观看</a>
                        <?php  }else{?>
                            <a href="<?php echo url('teacher/collection/lesson-plan-detail',array('id'=>$item->favoriteId));?>" class="a_button bg_green preview"> 预览</a>
                        <?php  } ?>
                        <button  type="button" class="bg_gray del" style="display: inline-block; line-height: 20px;" collectID="<?php echo $item->collectID;?>" typeId="<?php echo $item->favoriteType;?>">取消收藏</button>
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
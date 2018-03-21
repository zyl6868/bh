<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-10
 * Time: 上午11:26
 */
use frontend\components\helper\ImagePathHelper;
use common\models\dicmodels\QueryHasFavoriteModel;

?>
<?php
foreach($lessonPlan as $key=>$val){
     if($teacherId ==user()->id){

    ?>
    <li>
        <img src="<?php echo  ImagePathHelper::getPicUrl($val->url) ?>" style="width: 110px;height: 110px;">
        <a href="<?php echo url('teacher/briefcase/detail', array('id' => $val->id)); ?>"><?php echo $val->name; ?></a>
        <h6>简介:<span><?php echo strip_tags(cut_str($val->matDescribe,60)); ?></span></h6>
        <p><a class="a_button bg_blue_l" href="<?php echo url('teacher/briefcase/detail', array('id' => $val->id)); ?>">预览</a>
            </p>
    </li>
<?php     }else{ ?>
         <li>
             <img src="<?php echo  ImagePathHelper::getPicUrl($val->url) ?>" style="width: 110px;height: 110px;">
                 <a href="<?php echo url('teacher/default/detail', array('id' => $val->infoId,'teacherId'=>$teacherId)); ?>"><?php echo $val->name; ?></a>
             <h6>简介:<span><?php echo strip_tags(cut_str($val->brief,60)); ?></span></h6>
             <p></p>
             <p><a class="a_button bg_blue_l" href="<?php echo url('teacher/default/detail', array('id' => $val->infoId,'teacherId'=>$teacherId)); ?>">预览</a>
                 
                 <?php   $queryModel= QueryHasFavoriteModel::queryHasFavorite($val->infoId,$val->detailType,user()->id );
                 ?>
                 <?php if ($queryModel->isCollected==0) { ?>
                     <button class="bg_orenge lessonPlans"  type="button" action="1" collectID="<?php echo $val->infoId;?>" typeId="<?php echo $val->detailType;?>">收藏</button>
                 <?php } else { ?>
                     <button class="bg_gray lessonPlans" type="button" action="0" collectID="<?php echo $val->infoId;?>" typeId="<?php echo $val->detailType;?>">取消收藏</button>
                 <?php } ?>
             </p>
         </li>
   <?php  }
}?>
<script type="text/javascript">
    $(function(){
        $('.lessonPlans').bind('click', function () {
            var $_this = $(this);
            var id = $_this.attr('collectID');
            var type =$_this.attr('typeId');
            var action = $_this.attr('action');
            $.post("<?php echo url('teacher/default/add-material')?>", {id: id,type:type,action:action}, function (data) {
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
    })

</script>


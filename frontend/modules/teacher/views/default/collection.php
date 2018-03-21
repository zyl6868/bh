<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-30
 * Time: 上午11:59
 */
/* @var $this yii\web\View */  $this->title="教师设置-收藏列表";
?>
<?php if(user()->id ==$teacherId){ ?>
    <?php  echo $this->render('_your_collection', array('model'=>$model,'pages'=>$pages,'teacherId'=>$teacherId));?>
<?php }else{ ?>
    <?php  echo $this->render('_other_collection', array('model'=>$model,'pages'=>$pages,'teacherId'=>$teacherId));?>
<?php } ?>
<!--主体内容结束-->

<script type="text/javascript">

    $(function(){
        $('#type').change(function(){
            var type = $('#type').val();

            $.post('<?php echo app()->request->url;?>',{type:type},function(data){
                $('#collection').html(data);
            })
        });
    })

</script>
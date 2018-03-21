<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-30
 * Time: 下午12:17
 */



?>
<?php if($teacherId == user()->id){ ?>
    <?php  echo $this->render('_your_collection_view', array('model'=>$model,'pages'=>$pages,'teacherId'=>$teacherId));?>
<?php }else{ ?>
    <?php  echo $this->render('_other_collection_view', array('model'=>$model,'pages'=>$pages,'teacherId'=>$teacherId));?>
<?php }?>
<script type="text/javascript">
    $(function(){

        $('.del').bind('click',function(){
            var $_this = $(this);
            var id = $_this.attr('collectID');
            $.post("<?php echo url('teacher/default/del-material')?>",{id:id},function(data){
                if (data.success) {
                    $_this.parent().parent('li').remove();
                } else {
                    popBox.alertBox(data.message);

                }
            });
        });
    })

</script>
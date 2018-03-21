<?php
/* @var $this yii\web\View */
/* @var $error array */

$this->title = '授权失败';
?>

<div class="content" style="min-height:500px;margin-top: 250px;text-align: center;">
    <?php if(!empty($message)){ ?>
        <h1><?php echo $message;?></h1>
    <?php  }else{  ?>
        <h1>很抱歉，您所在的学校等信息与班海网站不符<span>...</span></h1>
        <h3>学校只能是 小学 / 初中 / 高中</h3>
    <?php }?>
</div>
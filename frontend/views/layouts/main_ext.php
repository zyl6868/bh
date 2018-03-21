<?php
/* @var $this yii\web\View */
$this->beginContent('@app/views/layouts/main.php');

?>
<?php echo $this->blocks['head_html']; ?>
<?php echo $this->blocks['head_html_ext'] ?>
<?php echo $this->render('//layouts/_site_header'); ?>
<!--top_end-->
<!--主体-->
<?php echo $content ?>
<!--主体end-->
<?php echo $this->render('//layouts/_site_footer'); ?>
<?php echo $this->blocks['foot_html'] ?>
<?php $this->endContent(); ?>
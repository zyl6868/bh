<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-11-4
 * Time: 下午5:12
 */


/* @var MakepaperController $this */
/* @var  Pagination $pages */
?>
<?php foreach ($list as $key => $item) {?>
<div class="paper">
    <?php echo $this->render('//publicView/paperReview/_itemProblemType', array('item' => $item)); ?>
</div>
<?php } ?>

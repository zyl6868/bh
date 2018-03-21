<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/11
 * Time: 19:08
 */
?>
<?php  if (!empty($smallQuestion)) { ?>
    <div class="quest sub_quest">
        <?php
        foreach ($smallQuestion as $key => $i) {
            echo $this->render('//publicView/questionInterface/_itemSmallQuestion', ['item' => $i, 'no' => $key + 1]);
        }
        ?>
    </div>
<?php } ?>
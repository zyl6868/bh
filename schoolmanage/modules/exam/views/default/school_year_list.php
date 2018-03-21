<?php
/**
 * Created by wagnchunlei.
 * User: Administrator
 * Date: 2016/2/16
 * Time: 19:01
 */
?>


<?php foreach($yearArray as $k=>$v){?>
<label>
    <input type="radio" class="radio  validate[required]" name="schoolYear" value="<?=$v?>" data-errormessage-value-missing="请选择学年"><?=$v?></label>
    <?php  if(($k+1)%3==0){?>
        <br>
<?php } }?>

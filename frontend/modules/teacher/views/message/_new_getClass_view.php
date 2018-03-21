<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-22
 * Time: 下午6:16
 */
?>
<span></span>
<?php foreach ($studentList as $student){?>
    <li data-userId="<?php echo $student->userID;?>"><?php echo $student->memName;?></li>
<?php }?>

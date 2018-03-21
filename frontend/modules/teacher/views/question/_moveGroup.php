<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/2
 * Time: 18:13
 */

use yii\helpers\Url;

/** @var common\models\pos\SeQuestionGroup $groupIds */
/** @var int $subjectId */
/** @var int $groupId */
/** @var int $collectGroupId */
?>
<ul>
    <?php if($groupId != $collectGroupId){ ?>
    <li class="group">
        <a class="checkMove ellipsis" title="我的收藏" data-groupId=<?=$collectGroupId?> ><i></i>我的收藏</a>
    </li>
    <?php } ?>
    <?php
    foreach($groupIds as $item){
        if ($item['groupId'] != $groupId) {
        ?>
    <li class="group">
        <a class="checkMove ellipsis" title="<?=$item['groupName'];?>" data-groupId=<?=$item['groupId']?> ><i></i><?php echo $item['groupName']; ?></a>
    </li>
<?php  } }?>
</ul>

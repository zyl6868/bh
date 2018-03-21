<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/2
 * Time: 18:13
 */

use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var common\models\pos\SeQuestionGroup $groupIds */
/** @var integer $subjectId */
/** @var integer $groupId */
?>


    <?php
    foreach($groupIds as $item){?>
    <li class="group collect_list" group="<?php echo $item['groupId']?>">
        <a class="ellipsis groupNameOld<?php echo $item['groupId']?>  <?php echo $groupId == $item['groupId'] ? 'ac' : ''; ?>" data-groupNameOld="<?=$item['groupName']?>" title="<?=$item['groupName'];?>" href="<?= Url::to(['index', 'department'=>$department,'subjectId'=>$subjectId,'groupId' => $item['groupId']]); ?>"><i></i><?php echo $item['groupName']; ?></a><span><em><?=$item['QuestionNum'];?></em>份</span>
    </li>
<?php   }?>

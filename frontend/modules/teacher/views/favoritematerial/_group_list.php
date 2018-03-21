<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13
 * Time: 16:35
 */
use common\models\pos\SeFavoriteMaterial;
use common\models\sanhai\SrMaterial;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<ul class="custom_groups">
    <li class="custom">
        <span><i></i>自定义分组</span>
        <?php if ($groupType == 0) { ?>
            <a class="addGroup" href="javascript:;"><i></i>新建组</a>
        <?php } ?>
    </li>
    <?php if ($groupType == 0) { ?>
        <?php  if(!empty($defaultGroupId)){?>
        <li class="collection">
            <a href="<?php echo Url::to(['/teacher/favoritematerial/index', 'department' => $department, 'subjectId' => $subjectId, 'groupId' => $defaultGroupId]) ?>" class="<?php echo $groupId == $defaultGroupId ? 'ac' : ''; ?>">
                <i></i>我的收藏
            </a>
            <span><?php echo $groupDefaultArray['collectNumber'] ?>份</span>
        </li>
        <?php }else{?>
            <li class="collection">
                <a href="<?php echo Url::to(['/teacher/favoritematerial/index', 'department' => $department, 'subjectId' => $subjectId]) ?>" class="<?php echo $groupId == '' ? 'ac' : ''; ?>">
                    <i></i>我的收藏
                </a>
                <span>0份</span>
            </li>
            <?php }?>
    <?php } ?>
    <?php if ($groupType == 2) { ?>
        <li class="establish">
            <a href="javascript:;" class="ac">
                <i></i>我的上传
            </a>
            <span>
                <?php echo SrMaterial::getCreateMaterialCount(user()->id, $department, $subjectId) ?>份
            </span>
        </li>
    <?php }else{ ?>
    <?php
    /** @var  $customGroupArray  common\models\pos\SeFavoriteMaterialGroup */
    foreach ($customGroupArray as $collectGroup) {
        ?>
        <li class="collect_list <?php echo $collectGroup['groupType'] == 0 ? 'collection' : 'group' ?>">
            <a class="ellipsis <?php echo $collectGroup['groupId'] == $groupId ? 'ac' : '' ?>"
               title="<?= Html::encode($collectGroup['groupName']) ?>"
               href="<?php echo Url::to(['/teacher/favoritematerial/index', 'department' => $department, 'subjectId' => $subjectId, 'groupId' => $collectGroup['groupId']]) ?>">
                <i></i><?= Html::encode($collectGroup['groupName']) ?>
            </a>
            <span><?php echo $collectGroup['collectNumber'] ?>份</span>
        </li>
    <?php } }?>

</ul>
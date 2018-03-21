<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/3
 * Time: 18:05
 */
use common\models\dicmodels\FileModel;
use yii\helpers\Url;

$arr = array(
    'department' => $department,
    'subjectId' => $subjectId,
    'groupType' => $groupType,
    'groupId' => $groupId
);
?>
<div class="pd25">
    <div class="sUI_formList sUI_formList_min classes_file_list">
        <div id="classes_sel_list" class="row">
            <div class="form_l tl">
                <a class="<?php echo '' == $matType ? 'sel_ac' : ''; ?> select_mattype" data-sel-item  href="javascript:;" data-url="<?= Url::to(array_merge([''], $arr, array('matType' => ''))) ?>">全部类型</a>
            </div>
            <div class="form_r">
                <ul>
                    <?php
                    $file = FileModel::model()->getList();
                    foreach ($file as $val) {
                        ?>
                        <li>
                            <a data-sel-item class="<?php echo $matType == $val->secondCode ? 'sel_ac' : ''; ?> select_mattype"  href="javascript:;" data-url="<?= Url::to(array_merge([''], $arr, ['matType' => $val->secondCode])) ?>">
                                <?= $val->secondCodeValue ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

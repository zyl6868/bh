<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/20
 * Time: 14:43
 */
use yii\helpers\Url;

?>

<div class="form_l tl"><a class="<?php echo '' == $type ? 'sel_ac' : ''; ?> select_mattype" data-sel-item

                          href="<?= Url::to(array_merge([''], $searchArr, array('groupId'=>$groupId, 'type' => ''))) ?>">全部题型</a>
</div>
<div class="form_r">
    <ul>
        <?php
        foreach ($result as $val) {
            ?>
            <li>
                <a data-sel-item
                   class="<?php echo $type == $val->paperQuesTypeId ? 'sel_ac' : ''; ?> select_mattype"

                   href="<?= Url::to(array_merge([''], $searchArr, ['groupId'=>$groupId, 'type' => $val->paperQuesTypeId])) ?>"><?= $val->paperQuesType ?></a>
            </li>
        <?php } ?>
    </ul>
</div>
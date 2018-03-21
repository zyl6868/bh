<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/20
 * Time: 14:43
 */
use yii\helpers\Url;

?>
<div class="form_l tl"><a onclick="return getContent(this)"
                          href="<?= Url::to(array_merge([''], $searchArr, ['type' => null])); ?>"
                          class="<?php echo app()->request->getParam('type', '') == null ? 'sel_ac' : ''; ?>"
                          data-sel-item>全部题型</a></div>
<div class="form_r">
    <ul>
        <?php foreach ($result as $item) { ?>
            <li>
                <a onclick="return getContent(this)"
                   class="<?php echo app()->request->getParam('type', '') == $item->paperQuesTypeId ? 'sel_ac' : ''; ?>"
                   data-sel-item
                   href="<?= Url::to(array_merge([''], $searchArr, ['type' => $item->paperQuesTypeId])); ?>"><?php echo $item->paperQuesType; ?></a>
            </li>
        <?php } ?>
    </ul>
</div>
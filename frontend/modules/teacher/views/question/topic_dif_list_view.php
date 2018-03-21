<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/20
 * Time: 14:48
 */
use common\models\dicmodels\DegreeModel;
use yii\helpers\Url;

?>

<div class="form_l tl"><a class="<?php echo '' == $complexity ? 'sel_ac' : ''; ?> select_mattype" data-sel-item

                          href="<?= Url::to(array_merge([''], $searchArr, array('groupId'=>$groupId, 'complexity' => ''))) ?>">全部难度</a>
</div>
<div class="form_r">
    <ul>
        <?php  foreach(DegreeModel::model()->getListData() as $k=>$v){

            ?>
            <li>
                <a data-sel-item
                   class="<?php echo $complexity == $k ? 'sel_ac' : ''; ?> select_mattype"

                   href="<?= Url::to(array_merge([''], $searchArr, ['groupId'=>$groupId, 'complexity' => $k])); ?>"><?php echo $v; ?><i class="dif_state <?=DegreeModel::model()->getIcon($k)?>"></i></a></li>
        <?php }
        ?>
    </ul>
</div>
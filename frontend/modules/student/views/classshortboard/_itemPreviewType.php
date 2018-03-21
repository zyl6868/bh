<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 2016/10/11
 * Time: 10:10
 */
use common\components\WebDataCache;
/** @var common\models\search\Es_testQuestion $item */
/* @var $this \yii\web\View */
?>

<div class="quest" data-content-id="<?= $item->id ?>">
    <div class="sUI_pannel quest_title">
        <div class="pannel_l">
                <span
                    class="Q_t_info"><em>试题编号：<?php echo $item->id ?></em><em><?= WebDataCache::getDictionaryName($item->tqtid) ?></em>
                    <?php if ($item->year != null) { ?>
                        <em><?php echo $item->year ?>年</em>
                    <?php } ?>
                    <em class="Q_difficulty">难度：
                        <i class="<?= \common\models\dicmodels\DegreeModel::model()->getIcon($item->complexity) ?>"></i>
                    </em>
                </span>
        </div>
        <div class="pannel_r"></div>
    </div>

  <?php echo  $this->render('//publicView/topic_preview/_itemPreviewDetail',['item'=>$item]) ?>

</div>


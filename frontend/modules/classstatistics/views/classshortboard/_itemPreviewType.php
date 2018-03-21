<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 10:49
 */
use frontend\components\helper\ImagePathHelper;
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
                    <em class="Q_difficulty">难度：<i
                            class="<?= \common\models\dicmodels\DegreeModel::model()->getIcon($item->complexity) ?>"></i></em></span>
        </div>
        <div class="pannel_r"></div>
    </div>

  <?php echo  $this->render('//publicView/topic_preview/_itemPreviewDetail',['item'=>$item]) ?>
    <?php if (!empty($num)) { ?>
        <div class="pd25 errorPeopleNumber">
            错误人次：<b><?= $num; ?></b>
        </div>
    <?php } ?>
</div>


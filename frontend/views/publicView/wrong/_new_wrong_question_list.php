<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 2016/8/31
 * Time: 18:16
 */

use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use frontend\components\CLinkPagerExt;

/** @var   common\models\pos\SeWrongQuestionBookInfo[] $testQuestionList */


?>

<ul>
    <?php
    if (empty($wrongQuestion)){
        echo ViewHelper::emptyView("暂无错题！");
    }else {
        foreach ($wrongQuestion as $key=>$item):
            if (!empty($item->question)) {
                ?>
                <li class="spacing">
                    <div class="topic quest_title">
                        <div class="header Q_t_info Q_t_info">
                            <em>试题编号：<?php echo $item->question->id ?></em>
                            <em><?= WebDataCache::getDictionaryName($item->question->tqtid) ?></em>
                            <?php if (!empty($item->question->year)) { ?>
                                <em><?php echo $item->question->year ?>年</em>
                            <?php } ?>
                            <em class="Q_difficulty">难度：<i
                                    class="<?= \common\models\dicmodels\DegreeModel::model()->getIcon($item->question->complexity) ?>"></i></em>
                        </div>
                    </div>
                    <?php echo $this->render('//publicView/topic_preview/_itemPreviewDetail', ['item' => $item->question]) ?>
                </li>
                <?php
            }
        endforeach;
    }
    ?>
</ul>

<div class="page">
    <?php
    echo CLinkPagerExt::widget(
        array(
            'pagination' => $pages,
            'updateId' =>'.testPaper',
            'maxButtonCount' => 6,
            'showjump' => true
        )
    )
    ?>
</div>

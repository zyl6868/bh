<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/19
 * Time: 17:05
 */
use frontend\components\helper\StringHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Url;

?>
<ul class="sUI_dialog_list cls_rList clearfix">
    <?php if (!empty($videos)) { ?>
        <?php foreach ($videos as $key => $val) { ?>
            <li class="test_ques_list">
                <div class="cls_lf_list">
                    <span class="file_cls video"></span>
                    <div class="sUI_pannel sUI_pannel_min">
                        <h5><a href="<?= Url::to(array_merge(['video/list'], ['paperId' => $val->paperId])) ?>"
                               title="<?= $val->paperName ?>"><?= StringHelper::cutStr($val->paperName, 33); ?></a></h5>
                    </div>
                    <div class="sUI_pannel in_troduces">
                <span>
                    <?php if (!empty($val->department)) {
                        echo $val->department == '20202' ? '中考真题' . "&nbsp;&nbsp;|&nbsp;" : '高考真题' . "&nbsp;&nbsp;|&nbsp;";
                    } ?>
                    <?php if (!empty($val->year)) {
                        echo $val->year . '年';
                    } ?>
                </span>
                <span>
                    <?php if (!empty($val->allquestionCount)) {
                        echo '总题数:' . $val->allquestionCount;
                    } ?>
                </span>
                    </div>
                </div>
            </li>
        <?php } ?>
    <?php } else { ?>
        <?php ViewHelper::emptyView(); ?>
    <?php } ?>
</ul>
<div class="page">
    <?php
    echo \frontend\components\CLinkPagerNormalExt::widget(array(
            'pagination' => $page,
            'firstPageLabel' => false,
            'lastPageLabel' => false,
            'updateId' => '#video',
            'maxButtonCount' => 8,
        )
    );
    ?>
</div>

<?php
/**
 * Created by zyl.
 * User: zyl
 * Date: 17-03-30
 * Time: 下午6:59
 */
use common\helper\DateTimeHelper;
use frontend\components\helper\ViewHelper;
use yii\helpers\Html;

?>

<ul class="notice_list">
    <?php if($model):
        foreach($model as $val){?>
        <li>
            <h4 title="<?=Html::encode($val['name'])?>" class = "">
                <div><?php echo Html::encode($val['name']);?></div>
            </h4>
            <p>From&nbsp;:&nbsp;<span>系统</span><span><?php echo date("Y-m-d H:i:s",DateTimeHelper::timestampDiv1000($val['pushTime']));?></span>
                <a class="float_right white tc" href="<?php echo \yii\helpers\Url::to(['/teacher/managetask/pushed-library-details','homeworkID'=>$val['homeworkId']])?>">
                  去查看
                </a>
            </p>

        </li>
    <?php }
    else:
        ViewHelper::emptyView();
    endif; ?>
</ul>

<?php
    echo \frontend\components\CLinkPagerExt::widget(array(
        'pagination' => $pages,
        'updateId' => '#qualityWork',
        'maxButtonCount' => 5,
        'showjump' => true
    )
    );
?>



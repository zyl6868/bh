<?php
/** @var array $model */
use frontend\components\helper\ViewHelper;
$this->title='积分收入明细';
?>

<table>
    <?php
    if($model) { ?>
        <thead>
        <tr>
            <td>获取途径</td>
            <td>获取时间</td>
            <td>获取积分</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model as $val) { ?>

            <tr>
                <td><?= $val->memo ?></td>
                <td><?php if (!empty($val->createTime)) {
                        echo date('Y-m-d H:i', strtotime($val->createTime));
                    } ?></td>
                <td><?= $val->points ?></td>
            </tr>

        <?php } ?>
        </tbody>
    <?php }else{
            ViewHelper::emptyView();
        };
    ?>
</table>
<br>

<?php
if(isset($pages)){
    echo \frontend\components\CLinkPagerExt::widget( array(
            'pagination'=>$pages,
            'updateId' => '#update',
            'maxButtonCount' => 5,
            'showjump'=>true
        )
    );
}
?>

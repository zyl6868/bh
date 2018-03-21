<?php
/** @var array $model */
use frontend\components\helper\ViewHelper;
$this->title='我的学米';
?>

<table>
    <?php
    if($model) { ?>
        <thead>
        <tr>
            <td>获取途径</td>
            <td>获取日期</td>
            <td>获取学米</td>
            <?php if($user->type == 0){?>
                <td>我的学米</td>
            <?php }?>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($model as $val) { ?>
                <tr>
                    <td><a href="javascript:void(0);"><?php echo $val->memo?></a></td>
                    <td><?php echo $val->occurrenceTime?></td>
                    <td><?php echo $val->xueMi?></td>
                    <?php if($user->type == 0){?>
                        <td><?php echo $val->total?></td>
                    <?php }?>
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
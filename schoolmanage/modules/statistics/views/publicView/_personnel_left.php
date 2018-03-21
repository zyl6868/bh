<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/4/28
 * Time: 18:20
 */
use yii\helpers\Url;

?>
<div class="asideItem">
    <ul class="left_menu">
        <li>
            <a class="<?php echo $this->context->highLightUrl(['statistics/activate/index','statistics/activate/student','statistics/activate/home']) ? 'cur' : ''?>" href="<?php echo Url::to("/statistics/activate/index")?>">用户激活统计</a>
        </li>
        <li><a class="<?php echo $this->context->highLightUrl(['statistics/homeworkuse/index']) ? 'cur' : ''?>" href="<?php echo Url::to("/statistics/homeworkuse/index")?>">作业使用统计</a></li>
    </ul>
</div>
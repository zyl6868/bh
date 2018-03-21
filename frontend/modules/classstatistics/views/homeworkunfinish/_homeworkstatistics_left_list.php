<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/7
 * Time: 15:06
 */
use yii\helpers\Url;

?>
<div class="asideItem">
    <ul class="left_menu">
        <li>
            <a
               class="<?= $this->context->highLightUrl('classstatistics/homeworkexcellentrate/index') ? 'cur' : '' ?>"
               href="<?php echo Url::to(['/classstatistics/homeworkexcellentrate/index','classId'=>$classId])?>">
                作业优秀率统计
            </a>
        </li>
        <li>
            <a class="<?= $this->context->highLightUrl('classstatistics/homeworkunfinish/index') ? 'cur' : '' ?>"
               href="<?php echo Url::to(['/classstatistics/homeworkunfinish/index','classId'=>$classId])?>">
                作业未完成统计
            </a>
        </li>
    </ul>
</div>

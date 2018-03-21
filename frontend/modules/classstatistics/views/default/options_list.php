<?php use yii\helpers\Url;?>
<ul class="tabList clearfix" style="background: #fff">
    <li><a class="<?= $this->context->highLightUrl('classstatistics/default/overview') ? 'ac' : '' ?>" href="<?php echo Url::to(['/classstatistics/default/overview','examId'=>$examId,'classId'=>$classId])?>">概览</a></li>
    <li><a class="<?= $this->context->highLightUrl('classstatistics/default/classes-contrast') ? 'ac' : '' ?>" href="<?php echo Url::to(['/classstatistics/default/classes-contrast','examId'=>$examId,'classId'=>$classId])?>">班级对比</a></li>
    <li><a class="<?= $this->context->highLightUrl('classstatistics/onlinescore/index') ? 'ac' : '' ?>" href="<?php echo Url::to(['/classstatistics/onlinescore/index','examId'=>$examId,'classId'=>$classId])?>">上线分数</a></li>
    <li><a class="<?= $this->context->highLightUrl('classstatistics/namelist/index') ? 'ac' : '' ?>" href="<?php echo Url::to(['/classstatistics/namelist/index','examId'=>$examId,'classId'=>$classId])?>">名单</a></li>
</ul>

<?php use yii\helpers\Url;?>
<ul class="tabList clearfix" style="background: #fff">
    <li><a class="<?= $this->context->highLightUrl('statistics/default/overview') ? 'ac' : '' ?>" href="<?php echo Url::to(['/statistics/default/overview','examId'=>$examId])?>">概览</a></li>
    <li><a class="<?= $this->context->highLightUrl('statistics/default/classes-contrast') ? 'ac' : '' ?>" href="<?php echo Url::to(['/statistics/default/classes-contrast','examId'=>$examId])?>">班级对比</a></li>
    <li><a class="<?= $this->context->highLightUrl('statistics/teachercontrast/index') ? 'ac' : '' ?>" href="<?php echo Url::to(['/statistics/teachercontrast','examId'=>$examId])?>">教师对比</a></li>
    <li><a class="<?= $this->context->highLightUrl('statistics/onlinescore/index') ? 'ac' : '' ?>" href="<?php echo Url::to(['/statistics/onlinescore','examId'=>$examId])?>">上线分数</a></li>
    <!--<li><a href="javascript:;">趋势分析</a></li>
    <li><a href="javascript:;">往届对比</a></li>-->
    <li><a class="<?= $this->context->highLightUrl('statistics/namelist/index') ? 'ac' : '' ?>" href="<?php echo Url::to(['/statistics/namelist','examId'=>$examId])?>">名单</a></li>
</ul>

<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 15:29
 */
use common\components\WebDataCache;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

$searchMainArr = ['department' => $department, 'subjectId' => $subjectId];
?>
<h5><?=WebDataCache::getDictionaryName($department).SubjectModel::model()->getName((int)$subjectId)?></h5>
<button id="show_sel_classesBar_btn" type="button" class="bg_white  icoBtn_change"><i></i>更换学科</button>

<div id="sel_classesBar" class="sel_classesBar pop">
    <?php foreach($departAndSubArray as $k=>$v){?>
    <dl>
        <dt><?=WebDataCache::getDictionaryName($k)?></dt>
        <?php foreach($v as $key=>$item){?>
        <dd data-sel-item class="sel_ac">
            <a href="<?=Url::to(array_merge([''],$searchMainArr,['subjectId'=>$key,'department'=>$k]))?>"><?=$item?> </a>
        </dd>
        <?php }?>
    </dl>
    <?php }?>
</div>

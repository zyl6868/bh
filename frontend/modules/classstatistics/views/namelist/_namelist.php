<?php

use frontend\components\CLinkPagerExt;
use common\components\GridView;

/* @var  $examsList   common\models\pos\SeExamSubject[] */
/* @var  $classesList  common\models\pos\SeClass[]   */

$gridColumnsStart=[
    ['label'=>'姓名','value' => function($model){
        return  \common\components\WebDataCache::getTrueNameByuserId($model->userId);
    }],
];

$gridColumnsEnd=[
    'totalScore',
    'gradeRank' ,
    'classRank',
    ['label'=>'班级','value' => function($model){
        return  \common\components\WebDataCache::getClassesNameByClassId($model->classId);
    }],

];


$subjects=  yii\helpers\ArrayHelper::getColumn($examsList,'subjectId');

$gridColumnsSubjects=[];

foreach($subjects as $v)
{

    $gridColumnsSubjects[]='sub'.$v;
};

$columns=yii\helpers\ArrayHelper::merge($gridColumnsStart,$gridColumnsSubjects,$gridColumnsEnd);
//去除排序链接
$dataProvider->setSort(false);

?>

<style>
    .sUI_table td {text-align:center;vertical-align:middle;}
</style>

<?= GridView::widget([
    'filterPosition'=>false,
    'layout'=>'{items}',
    'options'=>['class'=>false],
    'tableOptions'=>['class' => 'sUI_table'],
    'dataProvider' => $dataProvider,
    'columns' => $columns
]); ?>


<div class="page">
    <?php
    echo CLinkPagerExt::widget(
        array(
            'pagination' => $dataProvider->getPagination(),
            'updateId' => '#viewpage',
            'maxButtonCount' => 10,
        )
    )
    ?>
</div>
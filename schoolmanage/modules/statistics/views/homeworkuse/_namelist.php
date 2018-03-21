<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/5/6
 * Time: 14:32
 */
use common\components\GridView;
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;
use frontend\components\CLinkPagerExt;
use common\components\WebDataCache;

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
    'columns' => [

        [
            'format' => 'raw',
            'label'=>'老师',
            'attribute' => 'creator',
            'value' => function ($m) {
                return WebDataCache::getTrueNameByuserId($m['creator']);
            },
        ],
        [
            'format' => 'raw',
            'label'=>'学段',
            'attribute' => 'department',
            'value' => function ($m) {
                return SchoolLevelModel::getClassDepartment((int)$m['department']);
            },
        ],
        [
            'format' => 'raw',
            'label'=>'科目',
            'attribute' => 'subjectId',
            'value' => function ($m) {
                return SubjectModel::getClassSubject($m['subjectId']);
            },
        ],
        [
            'format' => 'raw',
            'label'=>'布置作业次数',
            'attribute' => 'teacherNum',
            'value' => function ($m) {
                return empty($m['teacherNum']) ? 0 : $m['teacherNum'];
            },
        ],
        [
            'format' => 'raw',
            'label'=>'接收作业人次',
            'attribute' => 'teacherSum',
            'value' => function ($m) {
                return empty($m['teacherSum']) ? 0 : $m['teacherSum'];
            },
        ],
        [
            'format' => 'raw',
            'label'=>'提交作业人次',
            'attribute' => 'studentNum',
            'value' => function ($m) {
                return empty($m['studentNum']) ? 0 : $m['studentNum'];
            },
        ],
        [
            'format' => 'raw',
            'label'=>'批改作业人次',
            'attribute' => 'studentSum',
            'value' => function ($m) {
                return empty($m['studentSum']) ? 0 : $m['studentSum'];
            },
        ],

    ],

]); ?>
<div class="page">
    <?php
    echo CLinkPagerExt::widget(
        array(
            'pagination' => $dataProvider->getPagination(),
            'updateId' => '#viewpage',
            'maxButtonCount' => 10,
            'showjump' => true
        )
    )
    ?>
</div>

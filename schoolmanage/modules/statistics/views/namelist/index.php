<?php


use common\models\dicmodels\SubjectModel;
use yii\helpers\Url;

/* @var  $examsList   common\models\pos\SeExamSubject[] */
/* @var  $examsList   common\models\pos\SeExamSubject[] */


$this->title = '学校统计-名单';
$searchArr = array(
    'schoolLevel' => app()->request->getParam('schoolLevel'),
    'gradeId' => app()->request->getParam('gradeId'),
);

$this->blocks['requireModule']='app/statistic/name_list';
?>
<div class="main col1200 clearfix name_list" id="requireModule" rel="app/statistic/name_list">

    <div class="container  no_bg">
        <div class="item">
            <a href="<?php echo Url::to(['/statistics/default/index']) ?>"
               class="btn btn30 icoBtn_back gobackBtn"><i></i>返回</a>
            <h4 class="test_title"><?= $seExamSchoolModel->examName ?></h4>
        </div>
        <div class="item no_bg echarts_bar">
            <div class="sUI_tab">
                <?php echo $this->render("@app/modules/statistics/views/default/options_list", ['examId' => $examId]); ?>
                <div class="tabCont">

                    <div class="tabItem">
                        <div class="echarts_item">
                            <div class="sUI_pannel  title_pannel">
                                <div class="pannel_r">
                                    <?= yii\helpers\Html::DropDownList('classId', null, yii\helpers\ArrayHelper::map($classesList, 'classID', 'className'), [
                                        "prompt" => '全年级',
                                        "onchange" => "updateView();",
                                        "id"=>'classId'
                                    ]); ?>
                                    <select name="subjectId" id="subjectId" onchange="updateView();">
                                        <option value="">总成绩</option>
                                        <?php foreach ($examsList as $item) { ?>
                                            <option
                                                value="<?= $item->subjectId ?>"><?= \common\components\WebDataCache::getSubjectNameById($item->subjectId); ?></option>
                                        <?php } ?>
                                    </select>
                                    <?= yii\helpers\Html::DropDownList('levels', null, ['1' => '优良生', '2' => '不及格生', '3' => '低分生'], [
                                        "prompt" => '全部层次',
                                        "onchange" => "updateView();",
                                        "id"=>'level'
                                    ]); ?>
                                </div>
                            </div>
                            <div>
                                <div class="pd25" id="viewpage" style="overflow-x: auto">
                                    <?= $this->render("_namelist", ['classesList' => $classesList, 'examsList' => $examsList, 'dataProvider' => $dataProvider]) ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    function updateView() {

       var  examId=<?=$examId?>;
        var classId = Number($('#classId').val());
        var subjectId = Number($('#subjectId').val());
        var level = Number($('#level').val());

        $.get('<?=Url::to([""])?>', {
            examId:examId,
            classId:classId,
            subjectId: subjectId,
            level:level
    },
        function (html) {
            $('#viewpage').html(html);
        }

    )
        ;

    }

</script>
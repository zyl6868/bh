<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2016/1/19
 * Time: 11:27
 */
use frontend\components\helper\DepartAndSubHelper;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$arr = [
    'searchArr' => $searchArr,
    'materialList' => $materialList,
    'sortType' => $sortType,
    'mattype' => $mattype,
    'fileName' => $fileName,
    'edition' => $edition,
    'department' => $department,
    'subjectId' => $subjectId,
    'tome' => $tome,
    'versions' => $versions,
    'pages' => $pages,
];

$searchMainArr = ['department' => $department, 'subjectId' => $subjectId];

/** @var $this yii\web\View */
$this->title = '课件库';
$this->blocks['requireModule']='app/platform/platform_question_bank';
?>

<div class="main col1200 clearfix platform_question_bank" id="requireModule" rel="app/platform/platform_question_bank">
    <div class="aside col260 alpha no_bg">
        <div id="sel_classes" class="asideItem currency_hg sel_classes">
            <div class="pd15">
                <?php
                $departAndSubArray = DepartAndSubHelper::getTopicSubArray();
                echo $this->render('@app/modules/platform/views/publicView/depart_and_sub_menu',
                    ['departAndSubArray' => $departAndSubArray, 'searchArr' => $searchMainArr, 'department' => $department, 'subjectId' => $subjectId]);
                ?>
            </div>
        </div>
        <div class="asideItem">
            <div class="border  currency_hg1">
                <div id="sel_course" class="sUI_select" style="border-bottom: 1px solid #f5f5f5">
                    <em class="sUI_select_t"><?php echo EditionModel::model()->getName($edition) ?></em>
                    <ul class="sUI_selectList pop">
                        <?php
                        foreach ($versions as $k => $v) {
                            $ac = false;
                            if ($edition != null) {
                                if ($k == $edition) {
                                    $ac = true;
                                }
                            }
                            ?>
                            <li>
                                <a href="<?php echo Url::to(array_merge([''], $searchMainArr, array('fileName' => $fileName, 'edition' => $k))) ?>"><?php echo $v; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <i class="sUI_select_open_btn"></i>
                </div>
                <div id="sel_grade" class="sUI_select">
                    <em class="sUI_select_t"><?= ChapterInfoModel::tomeName((int)$tome) ?></em>
                    <ul class="sUI_selectList pop">
                        <?php foreach ($tomeResult as $k => $v) { ?>
                            <li>
                                <a href="<?php echo Url::to(array_merge([''], $searchMainArr, array('fileName' => $fileName, 'edition' => $edition, 'tome' => $v->id))) ?>"><?php echo $v->name; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <i class="sUI_select_open_btn"></i>
                </div>
            </div>
        </div>
        <div class="asideItem ">
            <div class="border">
                <div class="treeWrap pd15" id="problem_tree"
                     data-url="<?php echo Url::to(array_merge([''], $searchMainArr, array('fileName' => $fileName, 'edition' => $edition))) ?>">
                    <?php echo $treeData ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container col910 omega currency_hg">
        <div class="sUI_pannel tab_pannel">
            <div class="pannel_l">
                <?php $form = ActiveForm::begin(['id' => 'searchName', 'method' => 'get', 'action' => Url::to(['index', 'department' => $department, 'subjectId' => $subjectId])]); ?>
                <span class="sUI_searchBar sUI_searchBar_max">
                        <input type="text" class="text " id="mainSearch" name="fileName"
                               value="<?= \yii\helpers\Html::encode($fileName) ?>">
                        <button type="submit" class="searchBtn">搜索</button>
                    </span>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div id="classFile">
        <?php echo $this->render('_index_list', $arr) ?>
    </div>

</div>
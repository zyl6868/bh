<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-30
 * Time: 下午6:41
 */
use frontend\components\CHtmlExt;
use frontend\components\helper\AreaHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
$this->title = '搜索学校';
$this->registerCssFile(BH_CDN_RES . "/static/css/selectClass.css" . RESOURCES_VER);
$this->blocks['requireModule'] = 'app/teacher/search_class';
?>
<div id="selectClass">
    <div class="title bgWhite">
        <?php echo $this->render('_search_schoolName'); ?>
        <p>
            <span class="attr">选择地区</span>
            <?php
            echo CHtmlExt::dropDownListAjax("provience", '', ArrayHelper::map(AreaHelper::getProvinceList(), 'AreaID', 'AreaName'), array(
                "defaultValue" => false, "prompt" => "请选择",
                'ajax' => [
                    'url' => Yii::$app->urlManager->createUrl('ajax/get-area'),
                    'data' => ['id' => new \yii\web\JsExpression('this.value')],
                    'success' => 'function(html){jQuery("#city").html(html).change();}'
                ],
                "id" => "provience"
            ));
            ?>&nbsp;
            <?php
            echo CHtmlExt::dropDownListAjax("city", '', [], array(
                "defaultValue" => false, "prompt" => "请选择", "id" => "city",
                'ajax' => [
                    'url' => Yii::$app->urlManager->createUrl('ajax/get-area'),
                    'data' => ['id' => new \yii\web\JsExpression('this.value')],
                    'success' => 'function(html){jQuery("#country").html(html).change();}'
                ],
            ));
            ?>&nbsp;
            <?php
            echo CHtmlExt::dropDownListAjax("country", '', [], [
                "defaultValue" => false, "prompt" => "请选择", "id" => "country"

            ]);
            ?>&nbsp;
            <span class="resetBtn" id="searchClass">查找学校</span>
        </p>

    </div>

    <div class="content">

        <div class="allClass bgWhite">
            <p class="caption">全部学校</p>
            <div><img class="VAM" src="<?php echo BH_CDN_RES ?>/static/images/warn.jpg" alt="">
                <span class="VAM">没有找到自己的学校 ? </span>
                <a href="javascript:void();" id="schoolArea" schoolCountryId="">点此申请学校</a>
            </div>
        </div>

        <div id="schoolList">
            <?php
            echo $this->render('_school_list', ['schoolInfos' => $schoolInfos, 'pages' => $pages]);
            ?>
        </div>

    </div>
</div>
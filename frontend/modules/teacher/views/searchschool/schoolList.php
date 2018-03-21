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
        <?php echo $this->render('_search_schoolName', ['schoolName' => $schoolName]); ?>
    </div>

    <div class="content">

        <div class="allClass bgWhite">
            <p class="caption">全部学校</p>
            <div><img class="VAM" src="<?php echo BH_CDN_RES ?>/static/images/warn.jpg" alt=""><span class="VAM">没有找到自己的学校 ? </span><a
                        href="javascript:void();" id="schoolArea" schoolCountryId="">点此申请学校</a></div>
        </div>

        <div id="schoolList">
            <?php
            echo $this->render('_school_list', ['schoolInfos' => $schoolInfos, 'pages' => $pages]);
            ?>
        </div>

    </div>
</div>
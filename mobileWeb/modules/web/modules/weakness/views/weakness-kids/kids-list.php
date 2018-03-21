<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午4:59
 */
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->registerJsFile(BH_CDN_RES . '/static/js/appMethods.js' . RESOURCES_VER);
$this->registerCssFile(BH_CDN_RES . '/static/css/weaknessKidList.css' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/zepto.min.js' . RESOURCES_VER);
$this->registerJsFile(BH_CDN_RES . '/static/js/weaknessKidsList.js' . RESOURCES_VER);

$searchArr = ['subjectId' => $subjectId, 'date' => $date];
?>


<div class="wrapper">
    <div class="header">
        <div class="nav">
            <a href="javascript:;" class="back" id="back">
                <img src="<?php BH_CDN_RES ?>/static/img/back.png">
            </a>
        </div>
        <div class="headerTitle clearfix">
            <div id="myErrWork">
                <a id="myErrP" href="<?= Url::to(['/web/weakness/error-questions/question-list', 'date' => $date]); ?>"><p
                            class="noSelected">我的错题</p></a>
                <img src="<?php BH_CDN_RES ?>/static/img/selected.png" class="noShow" id="myErrImg">
            </div>
            <div id="weakSpot">
                <a id="weakP" style="color: #000" href="<?= Url::to(['/web/weakness/weakness-kids/kids-list', 'date' => $date]); ?>"><p>
                        薄弱知识点</p></a>
                <img src="<?php BH_CDN_RES ?>/static/img/selected.png" id="weakImg">
            </div>
        </div>
    </div>

    <div class="selectSubject">

        <div class="topOrange" id="topOrange">
            <p class="subjectSelected"><?= $subjectName != '' ? $subjectName : '全部'; ?></p>
            <p class="otherSubject"><img src="<?php BH_CDN_RES ?>/static/img/orangeGo.png"></p>
        </div>
        <div class="options" id="options">
            <p>科目</p>
            <ul class="clearfix" id="toggleSubject">
                <li class="<?php echo $subjectId == '' ? 'isSelected' : ''; ?>">
                    <a style="color: #000"
                       href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => ''])); ?>">全部</a>
                </li>
                <li class="<?php echo $subjectId == 10010 ? 'isSelected' : ''; ?>">
                    <a style="color: #000"
                       href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => 10010])); ?>">语文</a>
                </li>
                <li class="<?php echo $subjectId == 10011 ? 'isSelected' : ''; ?>">
                    <a style="color: #000"
                       href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => 10011])); ?>">数学</a>
                </li>
                <li class="<?php echo $subjectId == 10012 ? 'isSelected' : ''; ?>">
                    <a style="color: #000"
                       href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => 10012])); ?>">英语</a>
                </li>
                <?php if ($userInfo->department != null && $userInfo->department != 20201) { ?>
                    <li class="<?php echo $subjectId == 10014 ? 'isSelected' : ''; ?>">
                        <a style="color: #000"
                           href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => 10014])); ?>">物理</a>
                    </li>
                    <li class="<?php echo $subjectId == 10015 ? 'isSelected' : ''; ?>">
                        <a style="color: #000"
                           href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => 10015])); ?>">化学</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="shadeBox" id="shadeBox"></div>

    <!-- 将错题数放在data-num中和后面的内容中 -->
    <?php if (count($kidList) == 0) {
        \mobileWeb\components\ViewHelper::emptyView("最近暂无薄弱知识点");
    } else { ?>
        <div class="errWorkList" id="errWorkList"  data-date="<?=$date?>" data-subject-id="<?=$subjectId?>">
            <p class="errWorkListTitle"><?=$monthNum?>月份薄弱知识点</p>
            <div id="errWorkHeight">
                <?= $this->render('_kid_info_list', ['kidList' => $kidList, 'date' => $date]) ?>
            </div>
            <p class="loadMore" id="loadMore">加载更多</p>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
    history.replaceState(null, "", "");
</script>

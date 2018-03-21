<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-14
 * Time: 下午5:38
 */
use yii\helpers\Url;
$searchArr =['subjectId' => $subjectId, 'complexity' => $complexity, 'date' => $date];
?>


<div class="topOrange" id="topOrange">
            <p class="subjectSelected"><?= $subjectName!='' ? $subjectName : '全部'; ?></p>
<p class="otherSubject"><img src="<?php BH_CDN_RES ?>/static/img/orangeGo.png"></p>
</div>
<div class="options" id="options">
    <p>科目</p>
    <ul class="clearfix" id="toggleSubject">
        <li class="<?php echo $subjectId == '' ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr, ['subjectId' => ''])); ?>">全部</a>
        </li>
        <li class="<?php echo $subjectId == 10010 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''],$searchArr, ['subjectId' => 10010])); ?>">语文</a>
        </li>
        <li class="<?php echo $subjectId == 10011 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''],$searchArr, ['subjectId' => 10011])); ?>">数学</a>
        </li>
        <li class="<?php echo $subjectId == 10012 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''],$searchArr, ['subjectId' => 10012])); ?>">英语</a>
        </li>
        <?php if ($userInfo->department != null && $userInfo->department != 20201) { ?>
            <li class="<?php echo $subjectId == 10014 ? 'isSelected' : ''; ?>">
                <a href="<?= Url::to(array_merge([''],$searchArr,['subjectId' => 10014])); ?>">物理</a>
            </li>
            <li class="<?php echo $subjectId == 10015 ? 'isSelected' : ''; ?>">
                <a href="<?= Url::to(array_merge([''],$searchArr, ['subjectId' => 10015])); ?>">化学</a>
            </li>
        <?php } ?>
    </ul>
    <p>题目难度</p>
    <ul class="clearfix" id="toggleDifficulty">
        <li data-difficulty="0" class="<?php echo $complexity == '' ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr, ['complexity' => ''])); ?>">全部</a>
        </li>
        <li class="<?php echo $complexity == 21101 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr,['complexity' => 21101])); ?>">容易</a>
        </li>
        <li class="<?php echo $complexity == 21102 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr,['complexity' => 21102])); ?>">较易</a>
        </li>
        <li class="<?php echo $complexity == 21103 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr,['complexity' => 21103])); ?>">一般</a>
        </li>
        <li class="<?php echo $complexity == 21104 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr,['complexity' => 21104])); ?>">较难</a>
        </li>
        <li class="<?php echo $complexity == 21105 ? 'isSelected' : ''; ?>">
            <a href="<?= Url::to(array_merge([''], $searchArr,['complexity' => 21105])); ?>">困难</a>
        </li>
    </ul>
</div>
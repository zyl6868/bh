<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/25
 * Time: 11:23
 */
?>
<table class="sUI_table single_table">
    <thead>
    <tr>
        <th>满分</th>
        <th>实考人数</th>
        <th>缺考人数</th>
        <th>平均分</th>
        <th>最高分</th>
        <th>最低分</th>
        <th>优良率</th>
        <th>优良人数</th>
        <th>及格率</th>
        <th>不及格人数</th>
        <th>低分率</th>
        <th>低分人数</th>
        <th>分数线</th>
        <th>上线人数</th>
    </tr>
    </thead>
    <tbody>
        <?php if(empty($seExamReprotBaseInfoList)){echo '统计数据正在生成中，请等待几分钟';}?>
        <tr>
            <td><?= $seExamReprotBaseInfoList->getFullScore() ?></td>
            <td><?= $seExamReprotBaseInfoList->realNumber ?></td>
            <td><?= $seExamReprotBaseInfoList->missNumber ?></td>
            <td><?= sprintf("%.2f",$seExamReprotBaseInfoList->avgScore) ?></td>
            <td><?= $seExamReprotBaseInfoList->maxScore ?></td>
            <td><?= $seExamReprotBaseInfoList->minScore ?></td>
            <td><?= $seExamReprotBaseInfoList->getExcellentRate() ?>%</td>
            <td><?= $seExamReprotBaseInfoList->goodNum ?></td>
            <td><?= $seExamReprotBaseInfoList->getPassRate() ?>%</td>
            <td><?= $seExamReprotBaseInfoList->noPassNum ?></td>
            <td><?= $seExamReprotBaseInfoList->getLowScoreRate() ?>%</td>
            <td><?= $seExamReprotBaseInfoList->lowScoreNum ?></td>
            <td><?= $seExamReprotBaseInfoList->getScoreLineOne() ?></td>
            <td><?= $seExamReprotBaseInfoList->overLineNum ?></td>
        </tr>
    </tbody>
</table>
<br>
<?php if(!empty($classId)){?>
<table class="sUI_table single_table">
    <thead>
    <tr>
        <th colspan="<?= count($rankListDesc)?>" style="background:#7edc92;color:#fff;text-align:left">&nbsp;&nbsp;班级前<?= count($rankListDesc)?>名</th>
        <th colspan="<?= count($rankListAsc)?>" style="background:#f97372;color:#fff;text-align:right">班级后<?= count($rankListAsc)?>名&nbsp;&nbsp;</th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <?php foreach($rankListDesc as $rankDesc){ ?>
            <td title="<?php  echo  implode(',',$rankDesc['userId'])?>">
                <?= $rankDesc['score']?><br><span><?php echo  $rankDesc['userId'][0]; if(count($rankDesc['userId']) > 1){echo ',等';}?></span>
            </td>
        <?php }?>

        <?php for($i=count($rankListAsc)-1 ; $i>=0 ;$i--){?>
            <td title="<?php echo  implode(',',$rankListAsc[$i]['userId']); ?>"><?= $rankListAsc[$i]['score']?><br><span><?php echo $rankListAsc[$i]['userId'][0]; if(count($rankListAsc[$i]['userId']) > 1){echo ',等';}?></span></td>
        <?php }?>

    </tr>
    </tbody>
</table>
<?php }?>
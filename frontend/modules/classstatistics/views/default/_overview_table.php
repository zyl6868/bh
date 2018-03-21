<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/24
 * Time: 18:09
 */
use common\models\dicmodels\SubjectModel;

?>
<table class="sUI_table">
    <thead>
    <tr>
        <th>学科</th>
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
    <?php
    if(empty($seExamReprotBaseInfoList)){echo '统计数据正在生成中，请等待几分钟';}
    foreach ($seExamReprotBaseInfoList as $seExamReprotBaseInfo) {

        ?>
        <tr>
            <td><?= SubjectModel::model()->getName((int)$seExamReprotBaseInfo->subjectId) ?></td>
            <td><?= $seExamReprotBaseInfo->getFullScore() ?></td>
            <td><?= $seExamReprotBaseInfo->realNumber ?></td>
            <td><?= $seExamReprotBaseInfo->missNumber ?></td>
            <td><?= sprintf("%.2f",$seExamReprotBaseInfo->avgScore) ?></td>
            <td><?= $seExamReprotBaseInfo->maxScore ?></td>
            <td><?= $seExamReprotBaseInfo->minScore ?></td>
            <td><?= $seExamReprotBaseInfo->getExcellentRate() ?>%</td>
            <td><?= $seExamReprotBaseInfo->goodNum ?></td>
            <td><?= $seExamReprotBaseInfo->getPassRate() ?>%</td>
            <td><?= $seExamReprotBaseInfo->noPassNum ?></td>
            <td><?= $seExamReprotBaseInfo->getLowScoreRate() ?>%</td>
            <td><?= $seExamReprotBaseInfo->lowScoreNum ?></td>
            <td><?= $seExamReprotBaseInfo->getScoreLineOne() ?> </td>
            <td><?= $seExamReprotBaseInfo->overLineNum ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
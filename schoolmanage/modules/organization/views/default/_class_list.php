<?php

/** @var common\models\pos\SeUserinfo $item */
use common\models\dicmodels\SchoolLevelModel;
use common\models\pos\SeClass;
use common\components\WebDataCache;

?>

<div class="num">学校共计：<em class="nub_of_peo_em"><?php echo $classCount;?></em>&nbsp;个班级</div>

<div id="class_list">
    <?php
    if(empty($classListData)){
        \frontend\components\helper\ViewHelper::emptyView('暂无数据');
    }else{
    ?>

	<table class="sUI_table">
		<thead>
		<tr>
            <th width="100px">学部</th>
            <th width="100px">入学年份</th>
            <th width="80px">年级</th>
            <th width="80px">班级</th>
            <th width="100px">班级人数</th>
            <th width="100px">授课老师人数</th>
            <th width="80px">班主任</th>
            <th width="80px">状态</th>
            <th width="160px">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($classListData as $item) {
			?>
			<tr class="u<?php echo $item["gradeID"]; ?>">
                <td><?php echo SchoolLevelModel::getClassDepartment((int)$departmentId); ?></td>
                <td><?php echo $item["joinYear"]; ?></td>
                <td><?php echo WebDataCache::getGradeName((int)$item["gradeID"]); ?></td>
                <td><?php echo $item["className"]; ?></td>
                <td><?php echo !empty($item["studentNum"]) ? $item["studentNum"] : '无'; ?></td>
                <td><?php echo !empty($item["teacherNum"]) ? $item["teacherNum"] : '无'; ?></td>
                <td><?php echo $item["classAdviser"]; ?></td>
                <td><?php echo SeClass::getClassStatus($item['status']); ?></td>
                <td width="160px" class="oper fathers_td" classId="<?php echo $item['classID'];?>">
                    <?php if($item['status'] == 0){?>
                    <a href="<?php echo \yii\helpers\Url::to(['/organization/personal/manage-list','classId'=>$item['classID']])?>" class="see_b view_info viewInfo" id="mag2">管理</a>
                    <?php }else{ ?>
                        <a href="javascript:;" class="see_b" style="color: #808080" id="mag2">管理</a>
                    <?php } ?>
                </td>
			</tr>
		<?php } ?>
		</tbody>

	</table>
    <?php }?>
</div>

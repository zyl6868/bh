<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/12
 * Time: 14:09
 */
use common\models\dicmodels\SchoolLevelModel;

?>

<td><?php
	if (empty($item['stuID']) && $item['stuID'] != '0') {
		echo "--";
	} else {
		echo $item['stuID'];
	}
	?></td>
<td title="<?=$item['trueName']?>"><?php ;
	if (empty($item['trueName'])) {
		echo "--";
	} else {
		echo cut_str($item['trueName'],10);
	}
	?></td>
<td><?php if ($item['sex'] == 1) {
		echo "男";
	} elseif ($item['sex'] == 2) {
		echo "女";
	} else {
		echo "保密";
	} ?></td>
<td><?php
	if (empty($item['bindphone'])) {
		echo "--";
	} else {
		echo $item['bindphone'];
	}
	?></td>
<td  width="50px"><?php
	if (empty($item['department'])) {
		echo "--";
	} else {
		echo SchoolLevelModel::model()->getName($item['department']);
	}
	?></td>
<td><?php
	if (empty($item['classID'])) {
		echo "--";
	} else {
		echo \common\components\WebDataCache::getClassesNameByClassId($item['classID']);
	}
	?></td>
<td  width="160px" class="oper fathers_td" uid="<?php echo $item["userID"] ?>">
	<a href="javascript:;" class="see_b view_info viewInfo" id="">查看</a>
	<span class="blue fl">|</span>
	<a href="javascript:;" class="edit_b edit_stu_info editInfo">编辑</a>
	<span class="blue fl">|</span>

	<div data-noChange class="sUI_select sUI_select_min fl other_operation">
		<em class="sUI_select_t">其它操作</em>
		<ul class="sUI_selectList pop">
			<li><a href="javascript:void(0);" data-userId="<?=$item["userID"]?>" class="class-mob">班级调动</a></li>
			<li><a href="javascript:void(0);" class="reset_passwd_bt reset_pwd">重置密码</a></li>
			<li><a href="javascript:void(0);" data-trueName="<?=$item['trueName']?>" data-userId="<?=$item["userID"]?>" class="live-sch">移除学校</a></li>
		</ul>
		<i class="sUI_select_open_btn"></i>
	</div>
</td>


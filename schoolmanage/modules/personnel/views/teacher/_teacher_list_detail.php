<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/12
 * Time: 11:14
 */
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;

?>

<td style="padding: 0 1px" width="100px" title="<?=$item['trueName']?>"><?php echo cut_str($item['trueName'],10); ?></td>
<td style="padding: 0 1px" width="40px">
	<?php if ($item['sex'] == 1) {
		echo "男";
	} elseif ($item['sex'] == 2) {
		echo "女";
	} else {
		echo "保密";
	} ?>
</td>
<td style="padding: 0 1px" width="50px"><?php echo SchoolLevelModel::model()->getName($item['department']); ?></td>
<td style="padding: 0 1px" width="50px"><?php echo SubjectModel::model()->getName((int)$item["subjectID"]) ?></td>
<td style="padding: 0 1px" width="130px"><?php echo $item['bindphone']; ?></td>
<td style="padding: 0 1px" title="<?=$item['phoneReg']?>"><?php echo cut_str($item['phoneReg'],17); ?></td>
<td style="padding: 0 1px" width="160px" class="oper fathers_td" uId="<?php echo $item["userID"] ?>">
	<a href="javascript:;" class="see_b view_info viewInfo" id="">查看</a>
	<span class="blue fl">|</span>
	<a href="javascript:;" class="edit_b edit_stu_info editInfo">编辑</a>
	<span class="blue fl">|</span>

	<div data-noChange class="sUI_select sUI_select_min fl other_operation">
		<em class="sUI_select_t">其它操作</em>
		<ul class="sUI_selectList pop">
			<li><a href="javascript:;" class="reset_passwd_bt reset_pwd">重置密码</a></li>
			<li><a class="update_class" href="javascript:;" data-userId="<?php echo  $item["userID"]?>" data-departmentName="<?php echo SchoolLevelModel::model()->getName($item['department']); ?>" data-departmentId="<?php echo $item['department']?>">修改班级</a></li>
			<li><a  class="live-school-th" href="javascript:;" data-userId="<?php echo  $item["userID"]?>" data-userName="<?php echo $item['trueName']; ?>">移除学校</a></li>
		</ul>
		<i class="sUI_select_open_btn"></i>
	</div>
</td>

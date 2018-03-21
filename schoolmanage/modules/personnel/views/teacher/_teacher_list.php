<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/5
 * Time: 10:19
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;


?>
<script type="text/javascript">
	$(function () {
		$(".nub_of_peo_em").text(<?php echo $numberOfPeople; ?>);
	})
</script>
<?php
if (empty($userInfo)) {
	echo "<tr>" . ViewHelper::emptyView("无人员数据！") . "</tr>";
}else{
?>
<table class="sUI_table">
	<thead>
	<tr>
		<th width="100px">姓名</th>
		<th width="40px">性别</th>
		<th width="50px">学段</th>
		<th width="50px">学科</th>
		<th width="130px">手机号</th>
		<th>登录名</th>
		<th width="160px">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($userInfo as $item) {
		?>
		<tr class="u<?php echo $item["userID"]?>">
			<?php echo $this->render("_teacher_list_detail",["item"=>$item]);?>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<div class="page">
	<?php
	echo CLinkPagerExt::widget(
		array(
			'pagination' => $pages,
			'updateId' => '#personnel_list',
			'maxButtonCount' => 10,
			'showjump' => true
		)
	)
	?>
</div>
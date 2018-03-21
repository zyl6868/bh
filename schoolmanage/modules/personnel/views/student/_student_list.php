<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/2
 * Time: 14:28
 */
use frontend\components\CLinkPagerExt;
use frontend\components\helper\ViewHelper;
use common\models\dicmodels\SchoolLevelModel;

/** @var common\models\pos\SeUserinfo $item */

?>
<script type="text/javascript">
	$(function () {
		$(".nub_of_peo_em").text(<?php echo $numberOfPeople; ?>);
	})
</script>

<?php
if (empty($userInfo)) {
	echo "<tr>" . ViewHelper::emptyView("无人员数据！") . "</tr>";
} else {
	?>
	<table class="sUI_table">
		<thead>
		<tr>
			<th width="100px">学号</th>
			<th width="80px">姓名</th>
			<th width="30px">性别</th>
			<th width="">手机号</th>
			<th width="50px">学段</th>
			<th>班级</th>
			<th width="160px">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($userInfo as $item) {
			?>
			<tr class="u<?php echo $item["userID"]; ?>">
				<?php echo $this->render("_student_list_detail",["item"=>$item]); ?>
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
			'maxButtonCount' => 8,
			'showjump' => true
		)
	)
	?>
</div>
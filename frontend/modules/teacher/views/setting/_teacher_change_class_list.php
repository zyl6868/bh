<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/17
 * Time: 13:54
 */
use frontend\components\CLinkPagerExt;

/** @var common\models\pos\SeClassMembers $item */
?>
<table id="revise" class="revise">
	<thead>
	<tr>
		<td>任教班级</td>
		<td>任教学科</td>
		<td>任教职务</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($classInfo as $item) {

		$classSub = $item->getUserInfo()->select('subjectID')->one();
		?>
		<?php echo $this->render("_teacher_change_class_detial", ["item" => $item, 'classSub' => $classSub]); ?>
		<?php
	} ?>
	</tbody>
</table>
<div class="page">
	<?php
	echo CLinkPagerExt::widget(
		array(
			'pagination' => $pages,
			'updateId' => '#class_list',
			'maxButtonCount' => 8,
			'showjump' => true
		)
	)
	?>
</div>
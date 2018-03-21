<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/12
 * Time: 16:56
 */

use common\models\dicmodels\SubjectModel;

$department = loginUser()->getModel()->department;
$subjectArray = SubjectModel::getSubjectByDepartmentCache($department);
$countSubject = count($subjectArray);
?>

<div class="form_l tl subject_list"><a class="sel_ac" subject="" data-sel-item href="javascript:;">全部学科</a></div>
<div class="form_r moreContShow">
	<?php if ($countSubject > 9) { ?>
		<a class="showMoreBtn" href="javascript:;">更多<i></i></a>
	<?php } ?>
	<ul>
		<?php
		$i = 0;
		foreach ($subjectArray as $key => $val) {
			++$i;
			?>
			<li class="sub_find">
				<a class="subject_list" subject="<?php echo $val->secondCode; ?>" data-sel-item href="javascript:;"><?php echo $val->secondCodeValue; ?></a>
			</li>

			<?php
			if ($i == 9) {
				echo '<br />';
			}
		} ?>
	</ul>

</div>

<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/7
 * Time: 11:31
 */

use common\models\dicmodels\SubjectModel;

$department = loginUser()->getModel()->department;

$subjectArray = SubjectModel::getSubjectByDepartmentCache($department);
$countSubject = count($subjectArray);
?>

<div id="classes_sel_list" class="row classes_sel_list" cl="<?php echo $classId;?>">
	<div class="form_l tl subject_list"  subject=""><a href="javascript:;" class="sel_ac" data-sel-item>全部学科</a></div>
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
				<li>
					<a class="subject_list" subject="<?php echo $val->secondCode; ?>" data-sel-item href="javascript:;"><?php echo $val->secondCodeValue; ?></a>
				</li>

				<?php
				if ($i == 9) {
					echo '<br />';
				}
			} ?>
		</ul>
	</div>
</div>

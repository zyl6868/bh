<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/17
 * Time: 11:33
 * 考务管理：左侧年级列表
 */

use yii\helpers\Url;

/** @var common\models\pos\SeSchoolUpGrade $upTime */
?>
<?php
$yDate = date('Y', time());//年
$mDate = date("m", time());//月
$no = 0;
$joinYear = '';

foreach ($gradeModel as $key => $item) {
	$no = count($gradeModel) - $key;

	if ($upTime) {
		$joinYear = $yDate - $no + 1;
	} else {
		$joinYear = $yDate - $no;
	}
	?>
	<li>
		<a class="<?php echo app()->request->getParam('gradeId', '') == $item['gradeId'] ? 'cur' : ''; ?>"
		   href="<?php echo Url::to(array_merge(['/exam/default/index'], $searchArr, ['gradeId' => $item['gradeId'], 'joinYear' => $joinYear])) ?>">
			<?php echo $item['gradeName'] . '（' . $joinYear . '级）'; ?>
		</a>
	</li>
<?php } ?>

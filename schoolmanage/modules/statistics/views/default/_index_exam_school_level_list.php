<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/17
 * Time: 19:14
 * 考务管理：学部 片段
 */
use common\models\dicmodels\SchoolLevelModel;
use yii\helpers\Url;

$departmentArray = explode(',', $department);

$schoolLevelList = SchoolLevelModel::model()->getListInData($departmentArray);//根据学校id 获取该校的学部
?>
<?php foreach ($schoolLevelList as $key=>$item) { ?>
<dl>
	<dt class="schoolLevel cur">
		<a href="<?php echo Url::to(array_merge(['/statistics/default/index'], $searchArr, ['schoolLevel'=> $key, 'gradeId'=>'','joinYear'=>'']))?>"><?php echo $item; ?></a>
	</dt>
	<dd data-sel-item class="sel_ac"></dd>
	<dd data-sel-item></dd>
</dl>
	<?php } ?>


<?php
use common\models\dicmodels\SchoolLevelModel;
use schoolmanage\components\helper\GradeHelper;
use yii\helpers\Url;
$departmentArray = explode(',', $department);

$schoolLevelList = SchoolLevelModel::model()->getListInData($departmentArray);//根据学校id 获取该校的学部

?>
<?php foreach ($schoolLevelList as $key=>$item) {

    $gradeModel = GradeHelper::getGradeByDepartmentAndLengthOfSchooling($key,$lengthOfSchooling,1);
    $defaultGradeId = $gradeModel[0]->gradeId;
    ?>
<dl>
	<dt class="schoolLevel cur">
		<a href="<?php echo Url::to(['/shortboard/default/index','schoolLevel'=> $key, 'gradeId'=>$defaultGradeId])?>"><?php echo $item; ?></a>
	</dt>
	<dd data-sel-item class="sel_ac"></dd>
	<dd data-sel-item></dd>
</dl>
	<?php } ?>


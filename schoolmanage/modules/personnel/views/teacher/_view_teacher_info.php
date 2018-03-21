<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/4
 * Time: 13:26
 */
use frontend\components\helper\ViewHelper;
use common\components\WebDataCache;
use common\models\dicmodels\EditionModel;
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;
if(empty($teaInfo))
{
	ViewHelper::emptyView("暂无该人员信息，请查证或刷新页面！");
}else{
?>
<div class="popCont">
	<div class="new_sch_con">
		<dl class="row clearfix">
			<dt>姓名：</dt>
			<dd>
				<?php
				if (empty($teaInfo["trueName"])) {
					echo "*";
				} else {
					echo $teaInfo["trueName"];
				}
				?></dd>
		</dl>
		<dl class="row clearfix">
			<dt>手机号：</dt>
			<dd><?php echo $teaInfo["bindphone"] ?></dd>
		</dl>
		<dl class="row clearfix">
			<dt>性别：</dt>
			<dd><?php if ($teaInfo["sex"] == 1) {
					echo "男";
				} elseif ($teaInfo["sex"] == 2) {
					echo "女";
				} else {
					echo "保密";
				} ?></dd>
		</dl>
		<dl class="row clearfix">
			<dt>学段：</dt>
			<dd><?php echo SchoolLevelModel::model()->getName($teaInfo['department']); ?></dd>
		</dl>
		<dl class="row clearfix">
			<dt>学科：</dt>
			<dd>
				<?php echo SubjectModel::model()->getName((int)$teaInfo["subjectID"]); ?>
				&nbsp;&nbsp;
				<?php
				if (empty($teaInfo["textbookVersion"])) {
					echo "<em style='color: red'>未设置版本</em>";
				} else {
					echo EditionModel::model()->getName($teaInfo["textbookVersion"]);
				}
				?>
			</dd>

		</dl>
		<dl class="row clearfix">
			<dt>任教班级：</dt>
			<dd>
				<span>
					<?php
					if (!empty($classMem)) {
						foreach ($classMem as $item) {
							echo WebDataCache::getClassesNameByClassId($item->classID) . "&nbsp;&nbsp;";
						}
					} else {
						echo "<em style='color: red'>未设置班级</em>";
					} ?>
				</span>
			</dd>
		</dl>
	</div>
</div>
<?php }?>
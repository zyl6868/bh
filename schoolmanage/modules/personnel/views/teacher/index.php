<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/3/2
 * Time: 11:46
 */
use frontend\components\CHtmlExt;
use common\models\dicmodels\SchoolLevelModel;
use common\models\dicmodels\SubjectModel;
use yii\helpers\Html;

$this->title = "人员管理-教师管理";
$this->blocks['requireModule'] = 'app/sch_mag/sch_mag_teacher';

?>
<div class="main col1200 clearfix sch_mag_person sch_mag_teacher" id="requireModule" rel="app/sch_mag/sch_mag_teacher">
	<div class="aside col260 alpha clearfix">
		<div class="sel_classes">
			<div class="pd15">
				<h5>人员管理</h5>
			</div>
		</div>
	</div>
	<div class="container col910 omega currency_hg">
		<div class="sUI_pannel tab_pannel">
			<div class="pannel_l">
				<h4 class="tch_detail">教师管理</h4>
			</div>
		</div>
	</div>
	<div class="aside col260 alpha no_bg clearfix">
		<?php echo $this->render("/publicView/_personnel_left") ?>
	</div>
	<div class="container col910 omega">
		<div class="pd25 clearfix">
			<div class="right_con">
				<div class="sUI_pannel">
					<div class="pannel_l">
						<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('departmentId'), "", SchoolLevelModel::model()->getListInData($departmentArray), array(
							'prompt' => '学部',
							'data-validation-engine' => 'validate[required]',
							'data-prompt-target' => "department_prompt",
							'data-prompt-position' => "inline",
							'id' => 'departmentId',
							'ajax' => [
								'url' => Yii::$app->urlManager->createUrl('personnel/teacher/get-subject'),
								'data' => ['department' => new \yii\web\JsExpression('this.value')],
								'success' => 'function(html){jQuery("#' . 'subjectId' . '").html(html).change();}'
							],
						)) ?>

						<?php echo CHtmlExt::dropDownListAjax(Html::getAttributeName('subjectId'), "", SubjectModel::model()->getListData(), array(
							'prompt' => '学科',
							'data-validation-engine' => 'validate[required]',
							'data-prompt-target' => "grade_prompt",
							'data-prompt-position' => "inline",
							'id' => 'subjectId',
						)) ?>
					</div>
					<div class="pannel_r sch_content">
                            <span class="sUI_searchBar sUI_searchBar_max ">
                            <label for="mainSearch"></label>
	                            <input id="mainSearch" type="text" class="text" value="">
                            <button type="button" class="searchBtn" id="search_word">搜索</button>
                            </span>
					</div>
				</div>
				<div class="table_con">
					<div class="clearfix">
						<div class="num">共计：<em class="nub_of_peo_em"><?php echo $numberOfPeople ?></em>&nbsp;位教师</div>
						<dl id="addTh" class="addTh">
							<dt class="addTeahcerAccount"></dt>
							<dd><a href="javascript:;" class="addTeahcerAccount">单个添加老师</a></dd>
						</dl>
					</div>
					<div id="personnel_list">
						<?php echo $this->render("_teacher_list", ["userInfo" => $userInfo, "pages" => $pages, "numberOfPeople" => $numberOfPeople]) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--弹框-->
<!--弹框重置密码-->
<div id="reset_passwordBox" class="popBox reset_passwordBox hide" title="重置密码">

</div>

<!--教师个人信息-->
<div id="infoBox" class="popBox infoBox hide" title="教师个人信息">

</div>

<!--编辑教师个人信息-->
<div id="editInfoBox" class="popBox editInfoBox hide" title="编辑教师个人信息">

</div>

<!--添加单个老师信息-->
<div id="addTeacher" class="popBox hide" title="单个添加老师">

</div>

<div id="addTeacherSuccess" class="popBox hide" title="系统提示">
	<div class="popCont" style="padding: 20px 0 30px;">
		<div class="new_sch_con">
			<h4 class="success_tip">添加成功！</h4>
			<dl class="successDl clearfix">
				<dt>账号：</dt>
				<dd class="phoneReg"></dd>
			</dl>
			<dl class="successDl clearfix">
				<dt>初始密码：</dt>
				<dd>123456</dd>
			</dl>
		</div>
	</div>
</div>

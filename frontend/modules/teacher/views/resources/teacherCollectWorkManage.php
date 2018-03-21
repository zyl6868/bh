<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/5/27
 * Time: 16:16
 */
use frontend\components\helper\DepartAndSubHelper;

$this->title = "作业管理-我的收藏";
$this->blocks['bodyclass'] = "teacher platform";
$this->blocks['requireModule']='app/teacher/teacher_home_hmwk';

$searchMainArr = ['department' => $department, 'subjectId' => $subjectId];
$publicResources = Yii::$app->request->baseUrl;
$this->registerJsFile($publicResources . '/pub/js/My97DatePicker/WdatePicker.js');
?>
<div class="main col1200 clearfix" id="requireModule" rel="app/teacher/teacher_home_hmwk">
	<div class="aside col260 alpha">
		<div id="sel_classes" class=" currency_hg sel_classes">
			<div class="pd15">
				<?php
				$departAndSubArray = DepartAndSubHelper::getTopicSubArray();
				echo $this->render('_depart_and_sub_menu',
						['departAndSubArray' => $departAndSubArray, 'searchArr' => $searchMainArr, 'department' => $department, 'subjectId' => $subjectId]);
				?>
			</div>
		</div>
	</div>
	<div class="tch_resource container col910 omega currency_hg">
		<?php
		//右部导航 公告页面
		echo $this->render("//publicView/resources/_my_resources_right_top_nav");
		?>
	</div>
	<div class="aside col260 alpha no_bg">
		<?php
		//教师作业 左部菜单
		echo $this->render("_teacher_work_manage_nav",["department" => $department, "subjectId" => $subjectId]);
		?>
	</div>
	<div class="tch_question container col910 omega no_bg">
		<div class="container" style="margin-top:0">
			<div class="sUI_pannel collections">
				<div class="pannel_l"><a href="javascript:;" class="sel_ac" data-sel-item>我的收藏</a></div>
			</div>

		</div>
		<div class="container manipulate  no_bg" style="margin-bottom:-18px">
			<div class="sup_box">
				<div id="work_list_page">
					<?php echo $this->render("_teacher_work_manage_list",['homeworkList' => $homeworkList, 'pages' => $pages,]);?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--布置作业弹出层-->
<div id="popBox1" class="popBox popBox_hand hide" title="选择班级">
	<div id="getClassBox">

	</div>
</div>
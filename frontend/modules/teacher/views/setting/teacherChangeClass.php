<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/16
 * Time: 10:45
 */
use yii\web\View;

/** @var common\models\pos\SeClassMembers $classInfo */
$this->title = "个人设置-修改班级";
$this->blocks['requireModule'] = 'app/personal_settings/upload_Pic';
$backend_asset = BH_CDN_RES . '/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
?>

<!--主体-->
<div class="cont24">
	<div class="grid24 main">
		<div class="grid_19 main_r">
			<div class="main_cont userSetup change_pwd">
				<div class="tab">
					<?php echo $this->render("//publicView/setting/_set_href") ?>
					<div class="tabCont">
						<div id="class_list">

							<?php echo $this->render("_teacher_change_class_list", ['classInfo' => $classInfo, 'pages' => $pages]) ?>
						</div>
						<a href="javascript:;" id="add_class"><i></i>添加任教班级</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--主体end-->
<div id="caution" class="caution">
	<div id="caution_header" class="tl caution_header">退出班级<i></i></div>
	<div id="caution_main" class="tc caution_main">是否确认退出班级？</div>
	<div class="btn_c">
		<a href="javascript:;">
			<button class="okBtn" id="quit_class">确定</button>
		</a>
		<button class="cancelBtn btn">取消</button>
	</div>
</div>
<div id="caution_add_class">
	<div id="add_class_header" class="tl">添加任教班级<i></i></div>
	<div id="add_class_main">
	</div>
</div>
<div id="alert_bg" class="alert_bg"></div>



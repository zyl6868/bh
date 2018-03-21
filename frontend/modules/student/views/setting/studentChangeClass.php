<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/8/18
 * Time: 10:41
 */
use common\components\WebDataCache;
use yii\web\View;

$this->title = "个人设置-修改班级";
$this->blocks['requireModule'] = 'app/personal_settings/stu_upload_Pic';
$backend_asset = BH_CDN_RES . '/static';
$this->registerCssFile($backend_asset . '/css/upload_Pic.min.css' . RESOURCES_VER, ['position' => View::POS_HEAD]);
?>
<!--主体-->
<div class="cont24 edit_class">
	<div class="grid24 main">
		<div class="grid_19 main_r">
			<div class="main_cont userSetup change_pwd">
				<div class="tab">
					<?php echo $this->render("//publicView/setting/_set_href") ?>
					<div class="tabCont">
						<p id="stu_leave_class">当前所在班级:
							<span>
								<?php echo WebDataCache::getClassesNameByClassId($classInfo->classID); ?>
							</span>
							<a href="javascript:;" class="q_class" clId="<?php echo $classInfo->classID; ?>">退出班级</a>
						</p>
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
		<a href="javascript:;"><button class="okBtn" id="quit_class">确定</button></a>
		<button class="cancelBtn btn">取消</button>
	</div>
</div>
<div id="alert_bg" class="alert_bg"></div>


<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/5/6
 * Time: 11:23
 */
use frontend\services\pos\pos_ClassMembersService;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<?php if (loginUser()->getUserInfo(app()->request->getParam("teacherId"))->isTeacher()) {
	if (count($this->context->isSameClass(app()->request->getParam("teacherId"))) > 0) {
		$classArray = $this->context->isSameClass(app()->request->getParam("teacherId"));
		$array = array();
		foreach ($classArray as $v) {
			array_push($array, array("className" => $v["className"], "classID" => $v["classID"]));
		}
		?>
		<h4>Wo 们的班级:<?php
			echo Html::dropDownList("", app()->request->getParam('classID', '')
				,
				ArrayHelper::map($array, 'classID', 'className'),
				array(
					//"prompt" => "请选择",
					"id" => "classID"
				));
			?></h4>

		<ul class="ta_student_list clearfix" id="classMember">
			<?php
			foreach ($classArray as $v1) {
				$classId = $v1['classID'];
				$classServer = new pos_ClassMembersService();
				$classResult = $classServer->loadRegisteredMembers($classId, '' , $teacherId);
				echo $this->render("_class_member", array("classResult" => $classResult, 'classId'=>$classId,'teacherId'=>$teacherId));
				break;
			}
			?>
		</ul>

	<?php } else { ?>
		<h4>Ta 的班级:<?php
			$array = array();
			$classInfo = loginUser()->getUserInfo($teacherId)->getClassInfo();
			foreach ($classInfo as $v) {
				array_push($array, array("classID" => $v->classID, "className" => $v->className));
			}
			echo Html::dropDownList("", app()->request->getParam('classID', '')
				,
				ArrayHelper::map($array, 'classID', 'className'),
				array(
					//"prompt" => "请选择",
					"id" => "allClassID"
				));
			?></h4>

		<ul class="ta_student_list clearfix" id="allClassMember">
			<?php
			foreach ($classInfo as $v2) {
				$classId = $v2->classID;
				$classServer = new pos_ClassMembersService();
				$classResult = $classServer->loadRegisteredMembers($classId, '' , $teacherId);
				echo $this->render("_class_member", array("classResult" => $classResult,'classId'=>$classId,'teacherId'=>$teacherId));
				break;
			}
			?>
		</ul>
	<?php }
} ?>
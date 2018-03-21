<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/5/6
 * Time: 11:25
 */
use frontend\services\pos\pos_ClassMembersService;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
	<h4>Wo 的班级:<?php
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

	<ul class=" ta_student_list clearfix" id="allClassMember">
		<?php
		foreach ($classInfo as $v) {
			$classId = $v->classID;
			$classServer = new pos_ClassMembersService();
			$classResult = $classServer->loadRegisteredMembers($classId, '' , $teacherId);
			echo $this->render("_class_member", array("classResult" => $classResult, 'classId'=>$classId, 'teacherId'=>$teacherId));
			break;
		}
		?>
	</ul>

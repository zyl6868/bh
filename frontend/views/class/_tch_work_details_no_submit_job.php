<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/1/11
 * Time: 10:29
 * 教师 未提交
 */
?>
<div class="tab_con">
	<div class="stat">
		未作答 学生(共<?php echo $noStudentMember; ?>人)
	</div>
	<div class="stu_list" id="stuList">
		<div class="stu_inner">
			<?php
			if (empty($answerStuList)) {
				foreach ($studentList as $k => $stuVal) {
					echo '<div class="chk">';
					echo '<label>';
					echo '<a title="' . $stuVal->memName . '"><span>' . $stuVal->memName . '</span> </a>';
					echo '</label>';
					echo '</div>'; //注意这里
				}
			} else {
//                                获取未答作业的学生
				$answerStuArray = array();
				foreach ($answerStuList as $v) {
					array_push($answerStuArray, $v->studentID);
				}
				$unAnswerStuList = array();
				foreach ($studentList as $v) {
					if (!in_array($v->userID, $answerStuArray)) {
						array_push($unAnswerStuList, $v);
					}
				}
				foreach ($unAnswerStuList as $stuVal) {
					echo '<div class="chk">';
					echo '<label>';
					echo '<a title="' . $stuVal->memName . '"><span>' . $stuVal->memName . '</span> </a>';
					echo '</label>';
					echo '</div>'; //注意这里
				}
			}
			?>
		</div>
	</div>
</div>

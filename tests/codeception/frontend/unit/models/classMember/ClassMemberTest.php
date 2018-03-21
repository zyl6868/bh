<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/6/28
 * Time: 14:04
 */
namespace tests\codeception\common\unit\models;

use common\models\pos\SeClassMembers;
use tests\codeception\frontend\unit\TestCase;

class ClassMemberTest extends TestCase
{
	public function testSeletClassMember()
	{
		$model = new SeClassMembers();
		$classId = 202192;
		$identity = 20403;
		//查询班主任
		$master = $model->selectClassAdviser($classId);
		$this->assertInternalType("object",$master);

		//查询教师列表
		$teacherList = $model->selectClassTeacherList($classId);
		$this->assertTrue(is_array($teacherList));

		//查询学生列表
		$studentList = $model->selectClassStudentList($classId);
		$this->assertTrue(is_array($studentList));

		//根据班级id查询 教师或学生 人数  已学生为例
		$studentNumber = $model->getClassNumByClassId($classId,$identity);
		$this->assertTrue(is_numeric($studentNumber));
	}
}
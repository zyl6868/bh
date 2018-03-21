<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/6/29
 * Time: 10:42
 */
namespace tests\codeception\common\unit\models;

use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClassEvent;
use common\models\pos\SeHomeworkRel;
use tests\codeception\common\unit\TestCase;

class ClassIndexTest extends TestCase
{
	public function testClassIndex()
	{
		$classId = 202192;

		//查询答疑
		$answerModel = new SeAnswerQuestion();
		$oneAnswerResult = $answerModel->selectOneClassAnswer($classId);
		$this->assertInternalType("object", $oneAnswerResult);

		//查询作业
		$homeworkRelModel = new SeHomeworkRel();
		$homeworkResult = $homeworkRelModel->selectOneClassHomework($classId);
		$this->assertInternalType("object", $homeworkResult);

		//查询班级大事记
		$classEventModel = new SeClassEvent();
		$classEventList = $classEventModel->selectClassEventList($classId);
		$this->assertTrue(is_array($classEventList));
	}
}

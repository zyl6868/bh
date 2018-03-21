<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/6/20
 * Time: 10:21
 */
namespace tests\codeception\frontend\unit\models;


use common\models\pos\SeHomeworkTeacher;
use tests\codeception\frontend\unit\TestCase;

class WorkManageTest extends TestCase
{
	/**
	 * 加入作业
	 * $homeworkID 平台作业ID
	 * $userID 用户ID
	 * @param $homeworkID
	 * @param $userID
	 * @return bool
	 * @throws \yii\db\Exception
	 */
	public function testAddWork()
	{
		$model = new SeHomeworkTeacher();

		$homeworkID = 2;
		$userId = 202534;
		$addWork = $model->collectHomework($homeworkID, $userId);

		$this->assertTrue(is_bool($addWork));
	}
}
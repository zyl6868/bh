<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/6/20
 * Time: 12:00
 */
namespace tests\codeception\common\unit\models;

use tests\codeception\frontend\unit\TestCase;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeQuestionResult;
use common\models\pos\SeSchoolInfo;
use frontend\modules\teacher\models\teaQuestionPackForm;

class AnswerQuestion extends TestCase
{


	/**
	 * 检测答疑数 和 添加答疑
	 */
	public function testAddAnswerQuestion()
	{
		$model = new SeAnswerQuestion();

		$schoolId = '20259';

		$schoolInfo =SeSchoolInfo::getOneCache($schoolId);
		$classId = "202201";
		$dataBag = new teaQuestionPackForm();
		$subjectId = '10011';
		$moreIdea = '1'; //分享 联盟 1，学校 2， 班级 3
		$picurls = ''; //图片地址
		$userId = 202534;
		//检测当前人 今天的提问题的数
		$checkTodayAnswerNum = $model->checkAnswerNum($userId);
		$this->assertTrue(is_numeric($checkTodayAnswerNum));

		//查询当前用户提问总数
		$checkUserAnswerSum = $model->getUserAskQuestion($userId);
		$this->assertTrue(is_numeric($checkUserAnswerSum));

		//添加答疑
		$addAnswer = $model->addAnswer($schoolInfo,$classId,$schoolId,$dataBag,$subjectId,$moreIdea,$picurls,$userId);
		$this->assertTrue(is_bool($addAnswer));
	}

	//查询答疑
	public function testSelectAnswerQuesiton(){
		$aqId = 9011764;
		$answerModel = new SeAnswerQuestion();

		//查询单条答疑
		$selectAnswerOne = $answerModel->selectAnswerOne($aqId);
		$this->assertInternalType("object", $selectAnswerOne);

		//设置最佳答案 修改答疑 为 已解决状态
		$updateAnswerSolve = $answerModel->updateAnswerQuestionsSolve($aqId);
		$this->assertTrue(is_bool($updateAnswerSolve));

	}

	//回答相关
	public function testQuestionResult()
	{
		$userId = 202534;
		$aqId = 9011764;  //问题id
		$resultId = 3660; //回答id

		$model = new SeQuestionResult();

		//查询当前用户回答问题的总数
		$checkUserResultAnswerSum = $model->getUserAnswerQuestion($userId);
		$this->assertTrue(is_numeric($checkUserResultAnswerSum));

		//查询当前用户回答问题被采纳的总数
		$checkUserRelyQuestion = $model->getUserRelyQuestion($userId);
		$this->assertTrue(is_numeric($checkUserRelyQuestion));

		//查看答案列表
		$questionResultList = $model->selectQuestionResultList($aqId);
		$this->assertTrue(is_array($questionResultList));

		//检查最佳答案是否存在
		$checkBestAnswer = $model->checkQuestionResult($aqId);
		$this->assertTrue(is_bool($checkBestAnswer));

		//设置最佳答案
		$setBestAnswer = $model->updateUseAnswer($resultId);
		$this->assertTrue(is_bool($setBestAnswer));
	}

	//添加回答
	public function testAddResultQuestion(){
		$userId = 202534;
		$aqId = 9011764;
		$answerContent = 123213213;  //回答内容 当回答内容不为空时， 图片路径可为空
		$imgPath = ''; //图片路径 可为空
		$model = new SeQuestionResult();
		$addResultQuestion = $model->addResultQuestion($userId, $aqId, $answerContent, $imgPath);

		$this->assertTrue(is_bool($addResultQuestion));

	}

	/**
	 * 班级首页 答疑
	 */
	public function testSelectOneClassAnswer()
	{
		$classId = 202192;
		$model = new SeAnswerQuestion();
		$oneAnswerResult = $model->selectOneClassAnswer($classId);
		$this->assertInternalType("object", $oneAnswerResult);
	}

}
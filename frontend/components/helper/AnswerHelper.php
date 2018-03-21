<?php
namespace frontend\components\helper;

use common\models\pos\SeQuestionResult;
use common\models\pos\SeSameQuestion;

/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/8/4
 * Time: 14:36
 */


class AnswerHelper
{

	/**
	 * 查询同问人
	 * @param $apId
	 * @return array|\common\models\pos\SeSameQuestion[]
	 */
	public static function ComeFrom($apId){
		$model = SeSameQuestion::find()->where(['aqID'=>$apId])->all();
		return $model;
	}

	/**
	 * 查询回答数
	 * @param $apId
	 * @return array|\common\models\pos\SeQuestionResult[]
	 */

	public static function ReplyNumber($apId)
	{
		$dataNumer = SeQuestionResult::find()->where(['rel_aqID'=>$apId])->count();
		return $dataNumer;
	}


	/**
	 * 查询同问数
	 * @param $apId
	 * @return int
	 */
	public static function AlsoAsk($apId)
	{
		$dataNumber = SeSameQuestion::find()->where(['aqID'=>$apId])->count();
		return $dataNumber;
	}
}
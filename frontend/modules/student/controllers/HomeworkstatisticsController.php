<?php
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 2016/10/11
 * Time: 10:35
 */
namespace frontend\modules\student\controllers;

use common\models\pos\SeHomeworkAnswerInfo;
use common\models\pos\SeHomeworkRel;
use frontend\components\StudentBaseController;
use common\components\WebDataKey;

class HomeworkstatisticsController extends StudentBaseController
{
	public $layout = 'lay_user_new';

    /**
     * 学生个人中心 个人统计 作业优秀率统计
     * wgl
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionHomeworkExcellentRate()
	{

		//获取当前时间
		$n = time() - 86400 * date('N', time());

		//获取（上一周） 开始时间（周一）和 结束时间（周日）
		$week_start = date('Y-m-d', $n - 86400 * 6);
		$week_end = date('Y-m-d', $n);

		//获取页面查询时间，（默认上周一周时间）
		$weekStart = app()->request->get('weekStart', $week_start);
		$weekEnd = app()->request->get('weekEnd', $week_end);
		$defaultTime = $weekStart . ',' . $weekEnd;
		$userId = user()->id;

		//时间转换成时间戳
		$startTime = strtotime($weekStart) * 1000;
		$endTime = strtotime($weekEnd) * 1000;

		//获取当前周的周一
		$nowMonday = date('Y-m-d', strtotime('last Monday'));

		$cache = \Yii::$app->cache;
		$cacheKey = WebDataKey::STUDENT_PERSON_HOMEWORK_PROFICIENCY_OF_STATISTICAL_CACHE_KEY . '_' . $defaultTime . '_' . $userId;
		$data = $cache->get($cacheKey);
		//获取作业优秀率数据
		if ($data === false) {
			$data = SeHomeworkAnswerInfo::getStudentHomeworkProficiencyOfStatistical($userId, $startTime, $endTime);
			//判断 周一大于 周日时 进行缓存，缓存时间为7天（不缓存当周）
			if (!empty($data) && $nowMonday > $weekEnd) {
				$cache->set($cacheKey, $data, 600);
			}
		}

		//查询数据 转换其中的优秀率名称
		$newDataName = [];
		$newDataMem = [];
		$name = '';
		$mem = '';
		foreach ($data as $key => $val) {
			$correctLevel = $val['correctLevel'];
			switch ($correctLevel) {
				case 1;
					$name = '差';
					break;
				case 2;
					$name = '中';
					break;
				case 3;
					$name = '良';
					break;
				case 4;
					$name = '优';
					break;
			}
			$mem = $val['countMem'];
			$newDataName[] = $name;
			$newDataMem[] = $mem;
		}
		//左侧排序名字
		$title = ['优', '良', '中', '差'];
		//优秀率名字
		$rateName = ['优秀率'];
		//合并数组 将优秀率名字和相应的优秀数组合新数组
		$newData = [];
		foreach ($newDataName as $k => $v) {
			$newData[$k]['value'] = $newDataMem[$k];
			$newData[$k]['name'] = $v;
		}
		if (app()->request->isAjax) {
			return $this->renderPartial('_index_info', array('newData' => $newData, 'title' => $title, 'rateName' => $rateName));
		}

		return $this->render('homework-excellent-rate',
			[
				'defaultTime' => $defaultTime,
				'weekStart' => $weekStart,
				'weekEnd' => $weekEnd,
				'newData' => $newData,
				'title' => $title,
				'rateName' => $rateName
			]);
	}


    /**
     * 作业未完成统计
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionHomeworkUnfinished()
	{

		$classInfo = loginUser()->getClassInfo();
		$classId = empty($classInfo) ? null : $classInfo[0]->classID;

		//获取当前时间
		$n = time() - 86400 * date('N', time());

		//获取（上一周） 开始时间（周一）和 结束时间（周日）
		$week_start = date('Y-m-d', $n - 86400 * 6);
		$week_end = date('Y-m-d', $n);

		//获取页面查询时间，（默认上周一周时间）
		$weekStart = app()->request->get('weekStart', $week_start);
		$weekEnd = app()->request->get('weekEnd', $week_end);
		$defaultTime = $weekStart . ',' . $weekEnd;
		$userId = user()->id;

		//时间转换成时间戳
		$startTime = strtotime($weekStart) * 1000;
		$endTime = strtotime($weekEnd) * 1000;

		//获取当前周的周一
		$nowMonday = date('Y-m-d', strtotime('last Monday'));

		$cache = \Yii::$app->cache;
		$cacheKey = WebDataKey::STUDENT_PERSON_HOMEWORK_UNFINISHED_CACHE_KEY . '_' . $defaultTime . '_' . $userId;
		$data = $cache->get($cacheKey);
		if ($data === false) {
			$data = SeHomeworkRel::unHomework($userId,$classId,$startTime,$endTime);

			//判断 周一大于 周日时 进行缓存，缓存时间为7天（不缓存当周）
			if (!empty($data) && $nowMonday > $weekEnd) {
				$cache->set($cacheKey, $data, 600);
			}
		}

//查询数据 转换其中的优秀率名称
		$newDataName = [];
		$newDataMem = [];
		$name = '';
		$mem = '';
		foreach ($data as $key => $val) {

			$isUploadAnswer = $val['isUploadAnswer'];
			switch ($isUploadAnswer) {
				case '';
					$name = '未完成';
					break;
				case 1;
					$name = '已完成';
					break;
			}
			$mem = $val['countMem'];
			$newDataName[] = $name;
			$newDataMem[] = $mem;
		}

		$title = ['未完成', '已完成'];
		//完成率的名字
		$rateName = ['完成率'];
		//合并数组 将优秀率名字和相应的优秀数组合新数组
		$newData = [];

		foreach ($newDataName as $k => $v) {
			$newData[$k]['value'] = $newDataMem[$k];
			$newData[$k]['name'] = $v;
		}
		if (app()->request->isAjax) {
			return $this->renderPartial('_not_homework_index_info', array('newData' => $newData, 'title' => $title, 'rateName' => $rateName));
		}
		return $this->render('homeworkUnfinished',
			[
				'defaultTime' => $defaultTime,
				'weekStart' => $weekStart,
				'weekEnd' => $weekEnd,
				'newData' => $newData,
				'title' => $title,
				'rateName' => $rateName
			]);
	}
}
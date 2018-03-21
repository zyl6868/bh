<?php

namespace frontend\modules\student\controllers;

use common\models\pos\SeHomeworkRel;
use frontend\components\StudentBaseController;
use yii\data\Pagination;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-11-18
 * Time: 上午10:08
 */

/**
 * Class ManagetaskController
 * @package frontend\modules\student\controllers
 */
class ManagetaskController extends StudentBaseController
{
	public $layout = 'lay_user_new';


    /**
     * 学生个人作业列表
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionWorkList()
	{
		$classId = loginUser()->getFirstClass();
		$subjectId = app()->request->getParam('subjectId');
		$state = app()->request->getParam('state');

		$pages = new Pagination();
		$pages->pageSize = 10;
		$homeworkQuery = SeHomeworkRel::find()->innerJoinWith('homeWorkTeacher')->where(['classID' => $classId]);
		//未完成 0，已完成 1
		if ($state == 0) {
			$homeworkQuery->andWhere('se_homework_rel.id not in (select relId from se_homeworkAnswerInfo where isUploadAnswer=1 and studentID=:userId)', [':userId' => user()->id]);
		} elseif ($state == 1) {
			$homeworkQuery->andWhere('se_homework_rel.id  in (select relId from se_homeworkAnswerInfo where isUploadAnswer=1 and studentID=:userId)', [':userId' => user()->id]);
		}

		if ($subjectId) {
			$homeworkQuery->andWhere(['se_homework_teacher.subjectId' => $subjectId]);
		}
		$pages->totalCount = $homeworkQuery->count();
		$list = $homeworkQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		SeHomeworkRel::existsStuIsComplete($list);
		$pages->params = ['subjectId' => $subjectId, 'state' => $state];
		if (app()->request->isAjax) {
			return $this->renderPartial('work_list', [
				'list' => $list,
				'pages' => $pages,
				'classId' => $classId,
			]);
		}
		return $this->render('workList',
			[
				'list' => $list,
				'pages' => $pages,
				'classId' => $classId,
			]);
	}


}
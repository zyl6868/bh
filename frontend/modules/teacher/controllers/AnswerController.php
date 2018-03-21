<?php
namespace frontend\modules\teacher\controllers;

use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeQuestionResult;
use frontend\components\TeacherBaseController;
use yii\data\Pagination;

/**
 * Created by Unizk.
 * User: ysd
 * Date: 14-10-30
 * Time: 下午4:56
 */
class AnswerController extends TeacherBaseController
{
	public $layout = 'lay_user_new';

	public function actions()
	{
		//私信部分
		return ['add-question' => [
			'class' => 'frontend\controllers\answer\CreateAnswerAction'
		],
			'update-question' => [
				'class' => 'frontend\controllers\answer\UpdateAnswerAction'
			]
		];
	}

    /**
     * 我的提问
     * wgl
     * @return string | null
     * @throws \yii\base\InvalidParamException
     *
     */
	public function actionMyQuestions()
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;

		$solvedType = app()->request->get('solved_type', null);
		$questionQuery = SeAnswerQuestion::find()->active()->andWhere(['creatorID' => user()->id]);

		//已解决
		if ($solvedType == 1) {
			$questionQuery->andWhere(['isSolved' => 1]);
		}
		//未解决
		if ($solvedType == 2) {
			$questionQuery->andWhere(['isSolved' => 0]);
		}

		$pages->totalCount = $questionQuery->count();
		$questionList = $questionQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		//查询回答数
		SeAnswerQuestion::getAnswerCount($questionList);

		if (app()->request->isAjax) {
			return $this->renderPartial('//publicView/answer/_my_question_list', array('modelList' => $questionList, 'pages' => $pages));
		}
		return $this->render('myQuestions', array('modelList' => $questionList, 'pages' => $pages));
	}

    /**
     * 我的回答
     * wgl
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionMyAnswer()
	{
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;
		$answerResultQue = SeQuestionResult::find()->where(['creatorID' => user()->id])->active()->select('rel_aqID,isUse')->groupBy('rel_aqID');

		$pages->totalCount = $answerResultQue->count();

		$questionList = $answerResultQue->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

		//查询提问的详情
		$answerQuestionData = SeAnswerQuestion::getAnswerQuestionInfo($questionList);

		//查询回答数
		SeAnswerQuestion::getAnswerCount($answerQuestionData);
		//查询同问数
		SeAnswerQuestion::getAlsoAskCount($answerQuestionData);

		if (app()->request->isAjax) {
			return $this->renderPartial('//publicView/answer/_my_answer_question_list', array('modelList' => $answerQuestionData, 'pages' => $pages));
		}
		return $this->render('myAnswer', array('modelList' => $answerQuestionData, 'pages' => $pages));
	}
}

?>
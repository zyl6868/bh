<?php
namespace frontend\modules\terrace\controllers;
use common\models\pos\SeAnswerQuestion;
use frontend\components\BaseAuthController;
use yii\data\Pagination;

/**
 * Created by Unizk.
 * User: ysd
 * Date: 14-12-3
 * Time: 下午3:23
 */
class AnswerController extends BaseAuthController
{
	public $layout = "lay_terrace_v2";

	public function  actionIndex()
	{
		return $this->actionAnswerQuestionsList();
	}

	/**
	 * 平台答疑
	 * 答疑列表
	 * @return string
	 */

	public function actionAnswerQuestionsList()
	{
        $proFirstime = microtime(true);
		$pages = new Pagination();
		$pages->validatePage=false;
		$pages->pageSize =10;
		$keyWord = app()->request->getParam('keyWord', '');
		$subjectID = app()->request->getQueryParam('subjectID', '');

		$solvedType = app()->request->get('solved_type', null);
		$model = SeAnswerQuestion::find()->active();

		if(!empty($keyWord)){
			$model->andWhere(['like','aqName',$keyWord]);
		}

		if(!empty($subjectID)){
			$model->andWhere(['subjectID'=>$subjectID]);
		}
		//已解决
		if ($solvedType == 1) {
			$model->andWhere(['isSolved' => 1]);
		}
		//未解决
		if ($solvedType == 2) {
			$model->andWhere(['isSolved' => 0]);
		}
		$pages->totalCount = $model->count();
		$modelList = $model->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
        \Yii::info('平台答疑 '.(microtime(true)-$proFirstime),'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('//publicView/answer/_new_answer_question_list', array('modelList'=>$modelList,'pages' => $pages));
		}
		return $this->render('answerQuestion', array('modelList' => $modelList, 'pages' => $pages));
	}
}
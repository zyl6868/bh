<?php
declare(strict_types=1);
/**
 * Created by Unizk.
 * User: ysd
 * Date: 14-12-3
 * Time: 下午3:23
 */
namespace frontend\modules\platform\controllers;
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeQuestionResult;
use frontend\components\BaseAuthController;
use yii\data\Pagination;

/**
 * Class AnswerController
 * @package frontend\modules\platform\controllers
 */
class AnswerController extends BaseAuthController
{
	public $layout = 'lay_platform';

	public function  actionIndex()
	{
		return $this->actionAnswerQuestionsList();
	}

    /**
     * 平台答疑
     * 答疑列表
     * @return string
     * @throws \yii\base\InvalidParamException
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
		//查询各个问题的回答数
		SeAnswerQuestion::getAnswerCount($modelList);
		//查询同问数
		SeAnswerQuestion::getAlsoAskCount($modelList);
        \Yii::info('平台答疑 '.(microtime(true)-$proFirstime),'service');
		if (app()->request->isAjax) {
			return $this->renderPartial('//publicView/answer/_new_answer_question_list', array('modelList'=>$modelList, 'pages' => $pages));
		}
		return $this->render('answerQuestion', array('modelList' => $modelList, 'pages' => $pages));
	}

    /**
     * 答疑详情页
     * @param int $aqid
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @internal param int $aqid问题id
     */
	public function actionDetail(int $aqid){

		$answerQuestionModel = new SeAnswerQuestion();
		$answerQuestionData = $answerQuestionModel->selectAnswerOne($aqid);

		if(empty($answerQuestionData)){
			return $this->notFound('暂无此答疑');
		}
		$pages = new Pagination();
		$pages->validatePage = false;
		$pages->pageSize = 10;

		$questionResultModel = new SeQuestionResult();

		$replyListModel = $questionResultModel->getQuestionResultList($aqid);
		$pages->totalCount = $replyListModel->count();
		$replyListArr = $replyListModel->offset($pages->getOffset())->limit($pages->getLimit())->all();


		$isuse = $questionResultModel->checkQuestionResult($aqid);
		if(app()->request->isAjax){
			return $this->renderPartial('//publicView/answer/_new_answer_details_list', ['answerQuestionModel'=>$answerQuestionData,'replyListArr'=>$replyListArr,'isuse'=>$isuse,'pages'=>$pages]);
		}
		return $this->render('//publicView/answer/answer_question_detail',
			[
				'answerQuestionModel'=>$answerQuestionData,
				'replyListArr'=>$replyListArr,
				'isuse'=>$isuse,
				'pages'=>$pages
			]);
	}

}
<?php
declare(strict_types=1);
namespace frontend\controllers;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-4
 * Time: 上午11:11
 */
use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeSchoolSummary;
use frontend\components\BaseAuthController;
use yii\data\Pagination;

class SchoolController extends BaseAuthController
{
    /**
     * @var string
     */
    public $layout = 'lay_new_school';

    /**
     *学校主页
     * @param integer $schoolId
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionIndex(int $schoolId)
    {
        $this->layout = false;
        // 学校信息
        $schoolModel = $this->getSchoolModel($schoolId);

        //学校简介
        $schoolSummary = SeSchoolSummary::getSchoolSummary($schoolId);

        return $this->render('schoolIntroduction', ['schoolModel' => $schoolModel, 'schoolSummary' => $schoolSummary]);
    }


    /**
     * 校内答疑
     * @param $schoolId
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     */

	public function actionAnswerQuestions($schoolId)
	{
		$this->getSchoolModel($schoolId);
		$pages = new Pagination();
		$pages->validatePage=false;
		$pages->pageSize =10;

		$keyWord = app()->request->getParam('keyWord', '');
		$subjectID = app()->request->getQueryParam('subjectID', '');

		$answerQuery = SeAnswerQuestion::find()->active()->andWhere(['schoolID'=>$schoolId]);

		if(!empty($keyWord)){
			$answerQuery->andWhere(['like','aqName',$keyWord]);
		}

		if(!empty($subjectID)){
			$answerQuery->andWhere(['subjectID'=>$subjectID]);
		}

		$answerList = $answerQuery->orderBy('createTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();
		$pages->totalCount = $answerQuery->count();
		if (app()->request->isAjax) {
			return $this->renderPartial('//publicView/answer/_answer_list', array('modelList'=>$answerList,'pages' => $pages, 'schoolId' => $schoolId));
		}
		return $this->render('answerQuestions', array('modelList' => $answerList, 'pages' => $pages, 'schoolId' => $schoolId));
	}


}
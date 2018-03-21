<?php
namespace frontend\modules\student\controllers;
use common\models\pos\SeWrongQuestionBookInfo;
use common\models\pos\SeWrongQuestionBookSubject;
use frontend\components\StudentBaseController;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: liquan
 * Date: 2014/11/17
 * Time: 10:05
 */
class WrongtopicController extends StudentBaseController
{
	public $layout = 'lay_user_new';

    /**
     * 错题列表 新
     * @return string
     * @throws \yii\base\InvalidParamException
     */
	public function actionManage()
	{
        $userId = user()->id;
        $questionList=SeWrongQuestionBookSubject::find()->where(['userId'=>$userId])->all();
        return $this->render('manage', array('questionList' => $questionList));
	}

    /**
     * 新单科 错题列表
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionWroTopForItem(){
        $wrongSubjectId=app()->request->get('subjectId');
        $userId = user()->id;
        //错题本
        $wrongQuestionQuery=SeWrongQuestionBookInfo::find()->where(['userId' =>$userId,'wrongSubjectId'=>$wrongSubjectId,'isDetete'=>0])->orderBy(['createTime' => SORT_DESC, 'questionId' => SORT_ASC]);
        $wrongSubject= SeWrongQuestionBookSubject::find()->where(['userId'=>$userId,'wrongSubjectId'=>$wrongSubjectId])->one();
       //错题
        $pages = new Pagination();
        $pages->validatePage=false;
        $pages->pageSize = 10;
        $pages->totalCount = $wrongQuestionQuery->count();
        $wrongQuestion=$wrongQuestionQuery->offset($pages->getOffset())->limit($pages->getLimit())->all();
		if(app()->request->isAjax){
			return $this->renderPartial('//publicView/wrong/_new_wrong_question_list',[
				'wrongQuestion'=>$wrongQuestion,
				'pages' => $pages
			]);
		}
        return $this->render('newwrongtopic',['wrongQuestion'=>$wrongQuestion,
            'wrongSubject'=>$wrongSubject,
            'pages' => $pages
		]);
    }
}
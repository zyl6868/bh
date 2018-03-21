<?php
namespace frontend\modules\terrace\controllers;

use common\models\pos\ComArea;
use common\models\sanhai\ShQuestionPaper;
use common\models\sanhai\ShQuestionVideo;
use common\models\sanhai\ShResource;
use common\models\sanhai\ShTestquestion;
use common\models\search\Es_testQuestion;
use frontend\components\BaseAuthController;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 15-8-19
 * Time: 下午6:01
 */
class VideopaperController extends BaseAuthController
{
    public $layout = "lay_new_terrace";

    /**
     * 试卷列表
     */
    public function actionIndex()
    {
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;

        $provinces = ComArea::find()->where(['levels' => '1'])->all();
        $grade = app()->request->getQueryParam('grade', '');
        $province = app()->request->getQueryParam('province', '');
        $subjectid = app()->request->getQueryParam('subjectid', '');
        $year = app()->request->getQueryParam('year', '');
        $papersQuery = ShQuestionPaper::find()->active();


        if ($grade != '') {
            $papersQuery->andWhere(['department' => $grade]);
        }
        if ($province != '') {
            $papersQuery->andWhere(['like', 'paperName',$province]);
        }
        if ($subjectid != '') {
            $papersQuery->andWhere(['subjectId' => $subjectid]);
        }
        if ($year != '') {
            $papersQuery->andWhere(['year' => $year]);
        }

        $pages->totalCount = $papersQuery->count();
        $papers = $papersQuery->offset($pages->getOffset())->limit($pages->getLimit())->all();
        $pages->params = [
            'grade' => $grade,
            'subjectid' => $subjectid,
            'province' => $province,
            'year' => $year,
        ];
        if (app()->request->isAjax) {
            return $this->renderPartial('_list_video', ['provinces' => $provinces, 'subjectid' => $subjectid, 'year' => $year, 'grade' => $grade, 'province' => $province, 'papers' => $papers, 'pages' => $pages]);
        }
        return $this->render('index', ['provinces' => $provinces, 'subjectid' => $subjectid, 'year' => $year, 'grade' => $grade, 'province' => $province, 'papers' => $papers, 'pages' => $pages]);
    }

    /**
     * 试卷题目
     */
    public function actionVideo()
    {
        $paperId = app()->request->getQueryParam('paperId');
        $paper = ShQuestionPaper::find()->where(['paperId' => $paperId])->one();
        if ($paper) {
            $pages = new Pagination();
            $pages->validatePage = false;
            $pages->pageSize = 1000;

            $questionsModel = Es_testQuestion::find();
            $pages->totalCount = $questionsModel->where(['paperId' => $paperId])->count();
            $questions = $questionsModel->where(['paperId' => $paperId])->offset($pages->getOffset())->limit($pages->getLimit())->all();
            $paperName = $paper->paperName;

            $pages->params = ['paperId' => $paperId, 'questions' => $questions, 'paperName' => $paperName];
            if (app()->request->isAjax) {
                return $this->renderPartial('_questions_video', ['questions' => $questions, 'paperName' => $paperName, 'paperId' => $paperId, 'pages' => $pages, 'offset' => $pages->getOffset()]);
            }

            return $this->render('video', ['questions' => $questions, 'paperName' => $paperName, 'paperId' => $paperId, 'pages' => $pages, 'offset' => $pages->getOffset()]);
        } else {
            return $this->notFound('试卷不存在！', 403);
        }
    }

    /**
     * 视频详情
     */
    public function actionVideoDetails()
    {
        $videosResource = [];
        $paperId = app()->request->getQueryParam('paperId');
        $paper = ShQuestionPaper::find()->where(['paperId' => $paperId])->one();
        if ($paper) {
            $id = app()->request->getQueryParam('id');
            $videos = ShQuestionVideo::find()->where(['questionId' => $id])->orderBy('resourceId')->all();
            $questionDetails = ShTestquestion::find()->where(['id' => $id])->one();
            if ($videos) {
                foreach ($videos as $video) {
                    $videoResource = ShResource::find()->where(['id' => $video->resourceId])->one();
                    $videosResource[] = $videoResource;
                }
            }
            return $this->render('videodetails', ['paperId' => $paperId, 'questionDetails' => $questionDetails, 'videosResource' => $videosResource]);
        } else {
            return $this->notFound('试卷不存在！', 403);
        }
    }

}
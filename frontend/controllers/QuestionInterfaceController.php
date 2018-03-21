<?php
namespace frontend\controllers;

use common\models\sanhai\SeSchoolGrade;
use common\models\search\Es_testQuestion;
use common\components\WebDataCache;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\EditionModel;
use Yii;
use yii\base\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * 给课海查提接口
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/1/11
 * Time: 9:13
 */
class QuestionInterfaceController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isGet) {
            $str = Yii::$app->request->get('id');
        } elseif (Yii::$app->request->isPost) {
            $str = Yii::$app->request->post('id');
        } else {
            $str = '';
        }
        $array = explode(',', $str);
        $questionList = [];
        foreach ($array as $key => $val) {

            $id = (int)$val;

            if($id <= 0){
                continue;
            }

            /** @var Es_testQuestion $questionModel */
            $questionModel = Es_testQuestion::forKeHaiSearch()->where(['id' => $id])->one();

            if (empty($questionModel)) {
                continue;
            }
            $data = $this->questionContent($questionModel);

            $list['subjectId'] = $questionModel->subjectid;
            $list['content'] = $data;
            $list['kid'] = $questionModel->kid;
            $list['versionName'] = '';
            $list['questionId'] = $id;
            if (isset($questionModel->versionid)) {
                $list['versionName'] = EditionModel::model()->getNames(explode(',', $questionModel->versionid));

            }

            $questionList[] = $list;
        }
        if ($questionList) {
            $arrays['resCode'] = '000';
            $arrays['resMsg'] = '成功';
            $arrays['data']['qs'] = $questionList;
            return $arrays;
        } else {
            $arrays['resCode'] = '001';
            $arrays['resMsg'] = '失败';
            $arrays['data']['qs'] = $questionList;
            return $arrays;
        }

    }

    /**
     * 关键字搜题
     * @return array
     */
    public function actionSearchByKey()
    {
        yii::$app->response->format = Response::FORMAT_JSON;
        $searchKey = Yii::$app->request->get('searchKey', Yii::$app->request->post('searchKey'));
        $subjectId = Yii::$app->request->get('subjectId', Yii::$app->request->post('subjectId'));
        $currentPage = Yii::$app->request->get('currentPage', Yii::$app->request->post('currentPage'));
        $pageSize = Yii::$app->request->get('pageSize', Yii::$app->request->post('pageSize'));
        if ($pageSize == null) {
            $pageSize = 10;
        }
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $subjectIdArr = [10010, 10011, 10012, 10014, 10015];
        $Es_testQuestionQuery = Es_testQuestion::forKeHaiSearch();
        $Es_testQuestionQuery->where(['subjectid' => $subjectIdArr]);
        if ($subjectId != null) {
            $Es_testQuestionQuery->andWhere(['subjectid' => $subjectId]);
        }
        if ($searchKey != null) {
            $Es_testQuestionQuery->query([
                'match' => [
                    'content' => ['query' =>
                        $searchKey,
                        'minimum_should_match' => '30%'
                    ]]
            ]);
        }
        $countSize = $Es_testQuestionQuery->count();
        $offset = ($currentPage - 1) * $pageSize;
        $questionList = $Es_testQuestionQuery->offset($offset)->limit($pageSize)->all();
        $array = [];
        $array['data']['qs'] = [];
        if (!empty($questionList)) {
            $array['resCode'] = '000';
            $array['resMsg'] = '成功';
            $array['data']['currentPage'] = $currentPage;
            $array['data']['pageSize'] = $pageSize;
            $array['data']['countSize'] = $countSize;
            $array['data']['totalPages'] = ceil($countSize / $pageSize);
            foreach ($questionList as $v) {
                $array['data']['qs'][] = ['subjectId' => $v->subjectid, 'content' => $this->questionContent($v), 'kid' => $v->kid, 'questionId' => $v->id];
            }
        } else {
            $array['resCode'] = '001';
            $array['resMsg'] = '失败';
        }
        return $array;
    }

    /**
     * 根据ID搜原题和相似题
     * @return array
     */
    public function actionFindById()
    {

        yii::$app->response->format = Response::FORMAT_JSON;
        $questionId = (int)Yii::$app->request->get('questionId', Yii::$app->request->post('questionId'));
        $currentPage = (int)Yii::$app->request->get('currentPage', Yii::$app->request->post('currentPage'));
        $pageSize = (int)Yii::$app->request->get('pageSize', Yii::$app->request->post('pageSize'));
        if ($pageSize == null) {
            $pageSize = 10;
        }
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $offset = ($currentPage - 1) * $pageSize;
        $array = [];
        $array['resCode'] = '001';
        $array['resMsg'] = '试题不存在';

        if($questionId <= 0 ){
            return $array;
        }

        /** @var Es_testQuestion $oriQuestion */
        $oriQuestion = Es_testQuestion::find()->where(['id' => $questionId])->one();

        if ($oriQuestion != null) {
            $array['resCode'] = '000';
            $array['resMsg'] = '成功';
            $array['data']['qinfo']['subjectId'] = $oriQuestion->subjectid;
            $array['data']['qinfo']['content'] = $this->questionContent($oriQuestion);
            $array['data']['qinfo']['kid'] = $oriQuestion->kid;
            $array['data']['qinfo']['questionId'] = $oriQuestion->id;

            $Es_testQuestionQuery = Es_testQuestion::forKeHaiSearch();
            //去除文本中的空格

            $content = preg_replace('/”|“|_|\(|\)|。|\,|）|（|[0-9]|：|:/', ' ', str_replace('&nbsp;', '', strip_tags($oriQuestion->content)));

            if ($questionId != null) {
                $Es_testQuestionQuery->query([
                    'match' => [
                        'content' => ['query' =>
                            $content,
                            'minimum_should_match' => '50%'
                        ]]
                ])->andWhere(['subjectid' => $oriQuestion->subjectid])->andWhere(['not', ['id' => $oriQuestion->id]]);
            }
//
            $questionList = $Es_testQuestionQuery->limit(40)->all();
            $questionCount = count($questionList);
            $array['data']['qs'] = [];
            $array['data']['currentPage'] = $currentPage;
            $array['data']['pageSize'] = $pageSize;
            $array['data']['countSize'] = 0;
            $array['data']['totalPages'] = 1;
            if (!empty($questionList)) {
                if ($questionCount > 20) {
                    $array['data']['countSize'] = 20;
                    $questionKeys = array_rand($questionList, 20);
                    foreach ($questionKeys as $v) {
                        $array['data']['qs'][] = ['subjectId' => $questionList[$v]->subjectid,
                            'content' => $this->questionContent($questionList[$v]),
                            'kid' => $questionList[$v]->kid,
                            'questionId' => $questionList[$v]->id];
                    }
                } else {
                    $array['data']['countSize'] = $questionCount;
                    shuffle($questionList);
                    foreach ($questionList as $v) {
                        $array['data']['qs'][] = ['subjectId' => $v->subjectid,
                            'content' => $this->questionContent($v),
                            'kid' => $v->kid,
                            'questionId' => $v->id];
                    }
                }

            }

        }
        return $array;

    }


    /**
     * 组合小题
     * @param Es_testQuestion $questionModel
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function questionContent(Es_testQuestion $questionModel)
    {

        $data = $this->renderPartial('/publicView/questionInterface/_itemQuestion', ['questionModel' => $questionModel]);
        return $data;
    }

    /**
     * 根据题目id返回章节id和章节名字，多个题目id逗号分隔
     * @return array
     */
    public function actionGetChapterById()
    {
        yii::$app->response->format = Response::FORMAT_JSON;
        $questionId = Yii::$app->request->get('questionId', Yii::$app->request->post('questionId'));
        $arrayQuestionId = explode(',', $questionId);
        $array = [];
        $array['data'] = [];
        $resultList = [];
        foreach ($arrayQuestionId as $value) {

            $id = (int)$value;

            if($id <= 0){
                continue;
            }

            $questionModel = Es_testQuestion::forKeHaiSearch()->where(['id' => $id])->one();
            if (empty($questionModel)) {
                continue;
            }
            $arrayChapterName = ChapterInfoModel::getChapterNameByIdMany((string)$questionModel->chapterId);
            $resultList = array_merge($resultList, $arrayChapterName);
        }

        //去重
        $resultList = array_column($resultList, 'chapter', 'chapterId');
        $resultList = array_unique($resultList);

        //返回对应值
        foreach ($resultList as $chapterId => $chapterName) {
            $array['data'][] = ['chapterId' => $chapterId, 'chapterName' => $chapterName];
        }
        if (!empty($resultList)) {
            $array['resCode'] = '000';
            $array['resMsg'] = '成功';
        } else {
            $array['resCode'] = '001';
            $array['resMsg'] = '失败';
        }
        return $array;
    }

    /**
     * 查询相同知识点的题目
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public function actionSameKnowledgeQuestionById()
    {
        yii::$app->response->format = Response::FORMAT_JSON;
        $questionId = (int)Yii::$app->request->get('questionId', Yii::$app->request->post('questionId', 0));
        $currentPage = (int)Yii::$app->request->get('currentPage', Yii::$app->request->post('currentPage'));
        $pageSize = (int)Yii::$app->request->get('pageSize', Yii::$app->request->post('pageSize'));
        $useNumber = (int)Yii::$app->request->get('pageSize', Yii::$app->request->post('useNumber', 1));
        $array = [];
        $array['data'] = [];

        $array['data']['qs'] = [];
        $array['resCode'] = '001';
        $array['resMsg'] = '没有该题';
        $array['data']['qinfo'] = null;
        $array['data']['currentPage'] = 0;
        $array['data']['pageSize'] = $pageSize;
        $array['data']['countSize'] = 0;
        $array['data']['totalPages'] = 0;

        if ($questionId === 0) {
            return $array;
        }

        if ( $pageSize <= 0) {
            $pageSize = 10;
        }

        if ( $pageSize >50) {
            $pageSize = 50;
        }

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        /** @var Es_testQuestion $oriQuestion */
        $oriQuestion = Es_testQuestion::getTestQuestionDetails($questionId);

        if ($oriQuestion !== null) {
            $questionInfo = new \stdClass();
            $questionInfo->subjectId = $oriQuestion->subjectid;
            $questionInfo->content = $this->questionContent($oriQuestion);
            $questionInfo->kid = $oriQuestion->kid;
            $questionInfo->questionId = $oriQuestion->id;
            $array['data']['qinfo'] = $questionInfo;
            $array['resCode'] = '000';
            $array['resMsg'] = '成功';
            if (empty($oriQuestion->kid)) {
                return $array;
            }

            $Es_testQuestionQuery = Es_testQuestion::forKeHaiSearch();
            $Es_testQuestionQuery->query([
                'function_score' => [
                    'functions' => [
                        [
                            'filter' => [
                                'term' => [
                                    'showType' => 5
                                ]
                            ],
                            'weight' => 2
                        ]
                    ],

                ]
            ]);
            $Es_testQuestionQuery->andWhere(['kid' => $oriQuestion->kid])->andWhere(['subjectid' => $oriQuestion->subjectid])->andWhere(['not', ['id' => $oriQuestion->id]])->andWhere(['between', 'keHaiUseNum', 0, $useNumber]);

            $countSize = $Es_testQuestionQuery->count();
            $offset = ($currentPage - 1) * $pageSize;
            $questionList = $Es_testQuestionQuery->orderBy('keHaiUseNum asc')->addOrderBy('_score desc')->offset($offset)->limit($pageSize)->all();
            $array['data']['currentPage'] = $currentPage;
            $array['data']['pageSize'] = $pageSize;
            $array['data']['countSize'] = $countSize;
            $array['data']['totalPages'] = ceil($countSize / $pageSize);
            /** @var Es_testQuestion[] $questionList */
            foreach ($questionList as $v) {
                $array['data']['qs'][] = ['subjectId' => $v->subjectid, 'content' => $this->questionContent($v), 'kid' => $v->kid, 'questionId' => $v->id];
            }

        }

        return $array;
    }


    /**
     * 查询相同年级、科目下包含相同知识点或章节的题目id
     * @return array
     */
    public function actionFindSameErrorsQuestionsById()
    {
        yii::$app->response->format = Response::FORMAT_JSON;
        $questionId = (int)Yii::$app->request->get('questionId', Yii::$app->request->post('questionId'));

        //获取该题目信息
        $array = [];
        $questionIdList = [];

        $array['resCode'] = '001';
        $array['resMsg'] = '没有该题';
        $array['data']['qs'] = $questionIdList;

        if($questionId <= 0){
            return $array;
        }

        /** @var Es_testQuestion $questionInfo */
        $questionInfo = Es_testQuestion::getTestQuestionDetails($questionId);
        if (empty($questionInfo)) {
            return $array;
        }

        $Es_testQuestionQuery = Es_testQuestion::forKeHaiSearch()->andWhere(['not', ['id' => $questionInfo->id]]);

        //学部
        if (!empty($questionInfo->gradeid)) {
            $department = WebDataCache::getGradeModel($questionInfo->gradeid);
            $gradeList = SeSchoolGrade::accordingDepartmentsGetGradeId($department->schoolDepartment);
            $gradeArr = ArrayHelper::getColumn($gradeList, 'gradeId', false);
            $Es_testQuestionQuery->andWhere(['gradeid' => $gradeArr]);
        }

        //科目
        if (!empty($questionInfo->subjectid)) {
            $Es_testQuestionQuery->andWhere(['subjectid' => $questionInfo->subjectid]);
        }

        //知识点或者章节
        $kidArray = Es_testQuestion::getQuestionKnowledge($questionInfo);
        $chapterIdArray = Es_testQuestion::getQuestionChapter($questionInfo);
        if (!empty($kidArray)) {
            $Es_testQuestionQuery->andWhere(['kid' => $kidArray]);
        } else {
            if (!empty($chapterIdArray)) {
                $Es_testQuestionQuery->andWhere(['chapterId' => $chapterIdArray]);
            }
        }
        $questionList = $Es_testQuestionQuery->limit(40)->all();
        $questionCount = count($questionList);

        //处理随机返回数据
        if (!empty($questionList)) {
            if ($questionCount > 20) {
                $array['data']['countSize'] = 20;
                $questionKeys = array_rand($questionList, 20);
                foreach ($questionKeys as $key) {
                    $questionIdList[] = $questionList[$key]->id;
                }
            } else {
                $array['data']['countSize'] = $questionCount;
                shuffle($questionList);
                foreach ($questionList as $question) {
                    $questionIdList[] = $question->id;
                }
            }
        }


        if (!empty($questionIdList)) {
            $array['resCode'] = '000';
            $array['resMsg'] = '成功';
        } else {
            $array['resMsg'] = '没有相关题目';
        }
        $array['data']['qs'] = $questionIdList;
        return $array;

    }


}
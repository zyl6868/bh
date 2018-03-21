<?php
declare(strict_types=1);
namespace frontend\modules\platform\controllers;

use common\clients\material\ChapterService;
use common\models\pos\SePaperQuesTypeRlts;
use common\models\sanhai\SeSchoolGrade;
use common\models\search\Es_testQuestion;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\KnowledgePointModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use frontend\components\BaseAuthController;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/18
 * Time: 10:57
 */
class QuestionController extends BaseAuthController
{
    public $layout = 'lay_platform';

    /**
     * 搜索选题
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionKeywordsChoose()
    {
        $proFirstime = microtime(true);
        $text = app()->request->getParam('text', '');
        $typeId = app()->request->getParam('type', '');
        $complexity = app()->request->getParam('complexity', '');
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $department =(int)app()->request->getParam('department', 20201);
        $subjectid =(int)app()->request->getParam('subjectId', 10010);
        $gradeList = SeSchoolGrade::getGradeId_Cache($department);
        $gradeArr = ArrayHelper::getColumn($gradeList, 'gradeId', false);
        $result=SePaperQuesTypeRlts::getPaperQuesTypeRltsList_Cache($department, $subjectid);
        $searchArrMore= array(
            'type'=>$typeId,
            'complexity'=>$complexity,
            'department'=>$department,
            'subjectId'=>$subjectid,
            'text'=>$text

        );
        $Es_testQuestionQuery = Es_testQuestion::forFrondSearch()->andWhere(['gradeid' => $gradeArr]);
        if ($typeId != null) {
            $Es_testQuestionQuery->andWhere(['tqtid' => $typeId]);
        }
        if ($complexity != null) {
            $Es_testQuestionQuery->andWhere(['complexity' => $complexity]);
        }
        $Es_testQuestionQuery->andWhere(['subjectid' => $subjectid]);
        if ($text != null) {
            $Es_testQuestionQuery->query([
                'match' => [
                    'content' => ['query' =>
                        $text,
                        'operator' => 'and'
                    ]]
            ]);
        }
        $pages->totalCount = $Es_testQuestionQuery->count();
        /** @var Es_testQuestion $dataList */
        $dataList = $Es_testQuestionQuery->orderBy('updateTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->highlight(['fields' => ['content' => ['number_of_fragments' => 0, "pre_tags" => ['<em class="highlight">'], "post_tags" => ["</em>"]]]])->all();
//       获取所有的题目ID
        foreach ($dataList as $item) {
            $questionIDArray[] = $item->id;
        }
        foreach ($dataList as $item) {
            $highLight = $item->getHighlight();
            if ($highLight && isset($highLight['content'])) {
                $item->content = $highLight['content'][0];
            }
        }
        $pages->params = ['text' => $text, 'type' => $typeId, 'complexity' => $complexity, 'department' => $department, 'subjectId' => $subjectid];

        \Yii::info('试题库 '.(microtime(true)-$proFirstime),'service');
        if (app()->request->isAjax) {
            return $this->renderPartial('content_view', ['dataList' => $dataList, 'pages' => $pages,'result'=>$result,'searchArr'=>$searchArrMore]);
        }
        return $this->render('keywordsChoose', ['result' => $result,
            'department' => $department,
            'subjectid' => $subjectid,
            'dataList' => $dataList,
            'pages' => $pages,
            'text' => $text,
            'searchArrMore'=>$searchArrMore
        ]);
    }

    /**
     * 章节选题
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionChapterChoose(){

        $proFirstime = microtime(true);
        //学部
        $departments = (int)app()->request->getParam('department',20201);
        $subjectid = (int)app()->request->getParam('subjectId',10010);

        //题型id
        $type = app()->request->getParam('type', null);
        //难度
        $complexity = app()->request->getParam('complexity', null);
        //学部 科目
        $result = SePaperQuesTypeRlts::getPaperQuesTypeRltsList_Cache($departments,$subjectid);
        //根据学部展示年级
        $gradeList = SeSchoolGrade::getGradeId_Cache($departments);
        $gradeArr = ArrayHelper::getColumn($gradeList, 'gradeId', false);
        //根据科目获取版本
        $versionList = LoadTextbookVersionModel::model($subjectid,null,$departments)->getListData();
        $version = (int)app()->request->getParam('version',key($versionList));

       $chapterTomeResult= ChapterService::getTomeList($subjectid, $version, $departments);

        //章节id
        if(!empty($chapterTomeResult)) {
            $chapterId = app()->request->getParam('chapterId', $chapterTomeResult[0]->id);
        }else{
            $chapterId=null;
        }
        //章节树 查询章节
        $chapterTree = ChapterInfoModel::searchChapterPointToTree($subjectid, $departments, $version, 0, (int)$chapterId);
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $Es_testQuestionQuery =Es_testQuestion::forFrondSearch()->andWhere(['gradeid' => $gradeArr]);
        if ($type!= null) {
            $Es_testQuestionQuery->andWhere(['tqtid' => $type]);
        }
        if ($complexity != null) {
            $Es_testQuestionQuery->andWhere(['complexity' => $complexity]);
        }
        $Es_testQuestionQuery->andWhere(['subjectid' => $subjectid]);
        if($chapterId!=null){
            $Es_testQuestionQuery->andWhere(['chapterId'=>$chapterId]);
        }
        /** @var Es_testQuestion $dataList */
        $pages->totalCount = (int)$Es_testQuestionQuery->count();

        $dataList = $Es_testQuestionQuery->orderBy('updateTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();

        $pages->params = ['type' => $type, 'complexity' => $complexity, 'department' => $departments, 'subjectId' => $subjectid,'chapterId'=>$chapterId,'version'=>$version];
        $searchArrMore= array(
            'type'=>$type,
            'complexity'=>$complexity,
            'department'=>$departments,
            'subjectId'=>$subjectid,
            'chapterId'=>$chapterId,
            'version'=>$version
        );

        \Yii::info('章节选题 '.(microtime(true)-$proFirstime),'service');
        if(app()->request->isAjax){
            return $this->renderPartial('content_view',['searchArr'=>$searchArrMore,'dataList'=>$dataList,'pages'=>$pages,'result'=>$result]);
        }
        return $this->render('chapterChoose',['result' => $result,
            'department' => $departments,
            'subjectId' => $subjectid,
            'pages' => $pages,
            'versionList'=>$versionList,
            'version'=>$version,
            'chapterTomeResult' => $chapterTomeResult,
            'chapterId'=>$chapterId,
            'chapterTree'=>$chapterTree,
            'dataList'=>$dataList,
            'searchArrMore'=>$searchArrMore
        ]);
    }

    /**
     * 知识点选题
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionKnowledgeChoose(){
        $proFirstime = microtime(true);
        //学部
        $department = (int)app()->request->getParam('department', 20201);
        $subjectid = (int)app()->request->getParam('subjectId', 10010);
        //题型id
        $type = app()->request->getParam('type', null);
        //难度
        $complexity = app()->request->getParam('complexity', null);

        //学部学科
        $result=SePaperQuesTypeRlts::getPaperQuesTypeRltsList_Cache($department, $subjectid);
        //知识点
        $kid = app()->request->getParam('kid', null);
        //知识点树
        $knowtree = KnowledgePointModel::searchAllKnowledgePoint($subjectid, $department);
        $gradeList = SeSchoolGrade::getGradeId_Cache($department);
        $gradeArr = ArrayHelper::getColumn($gradeList, 'gradeId', false);


        $Es_testQuestionQuery = Es_testQuestion::forFrondSearch()->andWhere(['gradeid' => $gradeArr]);
        if ($type!= null) {
            $Es_testQuestionQuery->andWhere(['tqtid' => $type]);
        }
        if ($complexity != null) {
            $Es_testQuestionQuery->andWhere(['complexity' => $complexity]);
        }
        $Es_testQuestionQuery->andWhere(['subjectid' => $subjectid]);
        if($kid!=null){
            $Es_testQuestionQuery->andWhere(['kid'=>$kid]);
        }
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        /** @var Es_testQuestion $dataList */
        $pages->totalCount = (int)$Es_testQuestionQuery->count();

        $dataList = $Es_testQuestionQuery->orderBy('updateTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();


        $pages->params = ['type' => $type, 'complexity' => $complexity, 'department' => $department, 'subjectId' => $subjectid,'kid'=>$kid];
        $searchArrMore= array(
            'type'=>$type,
            'complexity'=>$complexity,
            'department'=>$department,
            'subjectId'=>$subjectid,
            'kid'=>$kid
        );

        \Yii::info('知识点选题 '.(microtime(true)-$proFirstime),'service');
         if(app()->request->isAjax){
             return $this->renderPartial('content_view',['searchArr'=>$searchArrMore,'dataList'=>$dataList,'pages'=>$pages,'result'=>$result]);
         }
        return $this->render('knowledgeChoose',['result' => $result, 'department' => $department, 'subjectid' => $subjectid, 'pages' => $pages,'knowtree'=>$knowtree,'dataList'=>$dataList,'kid'=>$kid]);
    }
}
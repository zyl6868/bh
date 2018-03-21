<?php
declare(strict_types=1);
namespace frontend\modules\platform\controllers;

use common\clients\material\ChapterService;
use common\models\pos\SeHomeworkPlatform;
use common\models\pos\SePaperQuesTypeRlts;
use common\models\sanhai\SeSchoolGrade;
use frontend\components\helper\DepartAndSubHelper;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 17:53
 */
class ManagetaskController extends \frontend\components\BaseAuthController
{
    public $layout = 'lay_platform';

    /**
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        //学部
        $departments = (int)app()->request->getParam('department', 20201);

        $subjectid = (int)app()->request->getParam('subjectId', 10010);

        //难度
        $difficulty = app()->request->getParam('difficulty', null);

        //0,普通，1精品
        $level = app()->request->getParam('level', 1);
        //学部 科目
        $result = SePaperQuesTypeRlts::find()->where(['schoolLevelId' => $departments, 'subjectId' => $subjectid])->all();
        //根据学部展示年级
        $gradeList = SeSchoolGrade::find()
            ->where(['schoolDepartment' => $departments])
            ->select('gradeId')->asArray()
            ->all();
        $gradeArr = ArrayHelper::getColumn($gradeList, 'gradeId', false);

        //根据科目获取版本
        $versionList = LoadTextbookVersionModel::model($subjectid, null, $departments)->getListData();
        $version = (int)app()->request->getParam('version', key($versionList));
        $departAndSubArray = DepartAndSubHelper::getTopicSubArray();
        $chapterTomeResult = ChapterService::getTomeList($subjectid, $version, $departments);
        //章节id
        if (!empty($chapterTomeResult)) {
            $chapterId = app()->request->getParam('chapterId', $chapterTomeResult[0]->id);
        } else {
            $chapterId = null;
        }
        //章节树 查询章节
        $chapterTree = ChapterInfoModel::searchChapterPointToTree($subjectid,$departments,$version,0,(int)$chapterId);
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $homeWorks = SeHomeworkPlatform::find()->andWhere(['isDelete' => 0, 'status' => 1, 'gradeId' => $gradeArr]);

        if ($difficulty != null) {
            $homeWorks->andWhere(['difficulty' => $difficulty]);
        }

        if ($version != null) {
            $homeWorks->andWhere(['version' => $version]);
        }

        $homeWorks->andWhere(['subjectId' => $subjectid]);
        if ($chapterId != null) {
            $homeWorks->andWhere(['chapterId' => $chapterId]);
        }

        $homeWorks->andWhere(['level' => $level]);

        $pages->totalCount = (int)$homeWorks->count();

        /** @var SeHomeworkPlatform $dataList */
        $dataList = $homeWorks->orderBy('uploadTime desc')->offset($pages->getOffset())->limit($pages->getLimit())->all();


        $pages->params = [
            'difficulty' => $difficulty,
            'department' => $departments,
            'subjectId' => $subjectid,
            'chapterId' => $chapterId,
            'version' => $version,
            'level' => $level];

        $searchArrMore = array(
            'difficulty' => $difficulty,
            'department' => $departments,
            'subjectId' => $subjectid,
            'chapterId' => $chapterId,
            'version' => $version,
            'level' => $level
        );

        if (app()->request->isAjax) {
            return $this->renderPartial('content_view', [
                'chapterId' => $chapterId,
                'searchArr' => $searchArrMore,
                'dataList' => $dataList,
                'pages' => $pages,
                'result' => $result,
                'level' => $level]);
        }

        return $this->render('index', [
            'result' => $result,
            'departAndSubArray' => $departAndSubArray,
            'level' => $level,
            'difficulty' => $difficulty,
            'department' => $departments,
            'subjectId' => $subjectid,
            'pages' => $pages,
            'versionList' => $versionList,
            'version' => $version,
            'chapterTomeResult' => $chapterTomeResult,
            'chapterId' => $chapterId,
            'chapterTree' => $chapterTree,
            'dataList' => $dataList,
            'searchArrMore' => $searchArrMore,
        ]);

    }


}
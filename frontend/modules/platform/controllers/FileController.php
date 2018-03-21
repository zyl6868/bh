<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2016/1/19
 * Time: 11:25
 */

namespace frontend\modules\platform\controllers;

use common\clients\material\ChapterService;
use common\models\search\Es_Material;
use frontend\components\BaseAuthController;
use frontend\components\helper\TreeHelper;
use frontend\components\helper\VersionHelper;
use common\models\dicmodels\ChapterInfoModel;
use common\models\dicmodels\LoadGradeModel;
use common\models\dicmodels\LoadTextbookVersionModel;
use yii\data\Pagination;

class FileController extends BaseAuthController
{

    public $layout = 'lay_platform';

    /**
     *平台资料库列表
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $proFirstime = microtime(true);
        $pages = new Pagination();
        $pages->validatePage = false;
        $pages->pageSize = 10;
        $userInfo = loginUser()->getModel();

        $department = (int)app()->request->get('department', 20201);
        $subjectId = (int)app()->request->get('subjectId', 10010);
        $fileName = app()->request->get('fileName', '');
        $mattype = app()->request->get('mattype', '');
        $sortType = app()->request->get('sortType', 'createTime');


        $versions = VersionHelper::getVersionArr($department, $subjectId, LoadTextbookVersionModel::model($subjectId, null, $department)->getListData());
        $edition = (int)app()->request->getParam('edition', key($versions));

        $gradeId = empty(LoadGradeModel::model()->getData($userInfo->schoolID, $department)[0]->gradeId) ? '' : LoadGradeModel::model()->getData($userInfo->schoolID, $department)[0]->gradeId;
//        $tomeResult = ChapterInfoModel::getMajorChapter($subjectId, $department, $edition, (int)$gradeId);
        $tomeResult = ChapterService::getTomeList($subjectId, $edition, $department);
        $tomeDefault = '';
        if ($tomeResult) {
            $tomeDefault = $tomeResult[0]->id;
        }
        $tome = (int)app()->request->get('tome', $tomeDefault);

        $chapterData = ChapterInfoModel::searchChapterPointToTree($subjectId, $department, $edition, 0, $tome);
        $treeData = TreeHelper::streefun($chapterData, [], 'tree pointTree');

        //列表
        $Es_materialQuery = Es_Material::forFrondSearch()->andWhere(['between', 'creator', 0, 10000])->andwhere(['department' => $department, 'subjectid' => $subjectId]);
        $Es_materialQuery->orderBy("creator asc");

        $Es_materialQuery->andWhere(['versionid' => $edition]);
        $Es_materialQuery->andWhere(['chapterId' => $tome]);
        if (!empty($mattype)) {
            $Es_materialQuery->andWhere(['matType' => $mattype]);
        }
        if (!empty($sortType)) {
            $Es_materialQuery->addOrderBy("$sortType desc");
        }
        if (!empty($fileName)) {
            $Es_materialQuery->query([
                'match' => [
                    'name' => ['query' =>
                        $fileName,
                        'operator' => 'and'
                    ]]
            ]);
        }
        $pages->totalCount = $Es_materialQuery->count();
        $materialList = $Es_materialQuery->offset($pages->getOffset())->limit($pages->getLimit())->all();

        $searchArr = array(
            'mattype' => $mattype,
            'fileName' => $fileName,
            'edition' => $edition,
            'gradeId' => $gradeId
        );
        $arr = [
            'sortType' => $sortType,
            'mattype' => $mattype,
            'fileName' => $fileName,
            'edition' => $edition,
            'gradeId' => $gradeId,
            'department' => $department,
            'subjectId' => $subjectId,
            'materialList' => $materialList,
            'tome' => $tome,
            'treeData' => $treeData,
            'tomeResult' => $tomeResult,
            'versions' => $versions,
            'pages' => $pages,
            'searchArr' => $searchArr,
        ];
        \Yii::info('课件库 ' . (microtime(true) - $proFirstime), 'service');
        if (app()->request->isAjax) {
            return $this->renderPartial('_index_list', $arr);
        }

        return $this->render('index', $arr);
    }


} 
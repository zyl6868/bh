<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-10-12
 * Time: 下午6:11
 */

namespace mobileWeb\modules\api\modules\homework\controllers;


use common\clients\homework\HomeworkService;
use mobileWeb\controllers\RestfulBaseController;
use yii\web\BadRequestHttpException;

class HomeworkListController extends RestfulBaseController
{

    public function actionIndex()
    {
        $perPage = (int)app()->request->get('per-page', 10);
        $page = (int)app()->request->get('page', 1);
        $departmentId = (int)app()->request->get('department-id');
        $subjectId = (int)app()->request->get('subject-id');
        $versionId = app()->request->get('version-id');
        $chapterId = app()->request->get('chapter-id');
        $homeworkType = (int)app()->request->get('homework-type', 1);
        if ($departmentId == 0 || $subjectId == 0) {
            throw new BadRequestHttpException("参数错误");
        }
        $homeworkService = new HomeworkService();
        $homeworkListResult = $homeworkService->boutiqueList($perPage, $page, $departmentId, $subjectId, $versionId, $chapterId, $homeworkType);

        $boutiqueList = array();
        $boutiqueList['items'] = array();

        $pageInfo = new \stdClass();
        $pageInfo->totalCount = 0;
        $pageInfo->pageCount = 0;
        $pageInfo->currentPage = $page;
        $pageInfo->perPage = $perPage;

        if ($homeworkListResult->code == 200) {
            $boutiqueListInfo = $homeworkListResult->body;
            $pageInfo->pageCount = $boutiqueListInfo->pageCount;
            $pageInfo->totalCount = $boutiqueListInfo->totalCount;
            $boutiqueList['items'] = $boutiqueListInfo->data;

        }
        $boutiqueList['_meta'] = $pageInfo;
        return $boutiqueList;

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-10-13
 * Time: 上午11:24
 */

namespace mobileWeb\modules\api\modules\courseware\controllers;


use common\components\WebDataCache;
use common\clients\material\ListService;
use common\models\dicmodels\SubjectModel;
use frontend\components\helper\ImagePathHelper;
use mobileWeb\controllers\RestfulBaseController;

class MaterialRecommendController extends RestfulBaseController
{
    public function actionIndex()
    {
        $perPage = (int)app()->request->get('per-page', 10);
        $page = (int)app()->request->get('page', 1);

        $listService = new ListService();
        $boutiqueListResult = $listService->boutiqueList($perPage, $page);

        $boutiqueList = array();
        $boutiqueList['items'] = array();

        $pageInfo = new \stdClass();
        $pageInfo->totalCount = 0;
        $pageInfo->pageCount = 0;
        $pageInfo->currentPage = $page;
        $pageInfo->perPage = $perPage;

        if ($boutiqueListResult->code == 200) {
            $boutiqueListInfo = $boutiqueListResult->body;
            $data = [];
            foreach ($boutiqueListInfo->data as $item) {

                $materialModel = new \stdClass();
                $materialModel->id = $item->id;
                $materialModel->name = $item->name;
                $materialModel->matType = $item->matType;
                $materialModel->gradeid = $item->gradeId;
                $materialModel->subjectid = $item->subjectId;
                $materialModel->subjectName = SubjectModel::getClassSubject($item->subjectId);
                $materialModel->image = ImagePathHelper::imgThumbnail($item->image, 250, 140);
                $materialModel->createTime = $item->createTime;
                $data[] = $materialModel;
            }
            $pageInfo->pageCount = $boutiqueListInfo->pageCount;
            $pageInfo->totalCount = $boutiqueListInfo->totalCount;
            $boutiqueList['items'] = $data;
        }
        $boutiqueList['_meta'] = $pageInfo;

        return $boutiqueList;

    }


}
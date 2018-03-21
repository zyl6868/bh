<?php
namespace mobileWeb\modules\api\modules\courseware\controllers;

use common\components\WebDataCache;
use common\clients\material\MaterialMicroService;
use frontend\components\helper\ImagePathHelper;
use mobileWeb\controllers\RestfulBaseController;
use yii\data\ActiveDataProvider;


/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-10-10
 * Time: 下午3:23
 */
class MaterialListController extends RestfulBaseController
{

    public $modelClass = '\common\models\search\Es_Material';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        return
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'prepareDataProvider' => function ($action) {

                        $perPage = (int)app()->request->get('per-page', 10);
                        $page = (int)app()->request->get('page', 1);
                        $departmentId = (int)app()->request->get('department-id');
                        $subjectId = (int)app()->request->get('subject-id');
                        $versionId = (int)app()->request->get('version-id');
                        $chapterId = (int)app()->request->get('chapter-id');
                        $matType = (int)app()->request->get('mat-type');

                        $materialModelService = new MaterialMicroService();
                        $materialList = $materialModelService->list($perPage,$page,$departmentId,$subjectId,$versionId,$chapterId,$matType);

                        $arr = [];

                        if(isset($materialList->code) && $materialList->code != 200){
                            $arr['_meta']['totalCount'] = 0;
                            $arr['_meta']['pageCount'] = 0;
                            $arr['_meta']['currentPage'] = 0;
                            $arr['_meta']['perPage'] = 0;
                            $arr['items'] = [];
                            return $arr;
                        }

                        $arr['_meta']['totalCount'] = $materialList->totalCount;
                        $arr['_meta']['pageCount'] = $materialList->pageCount;
                        $arr['_meta']['currentPage'] = $materialList->page;
                        $arr['_meta']['perPage'] = $materialList->perPage;
                        $arr['items'] = [];

                        if (count($materialList->data) > 0) {
                            foreach ($materialList->data as $item) {
                                $materialModel = new \stdClass();
                                $materialModel->id = $item->id;
                                $materialModel->name = $item->name;
                                $materialModel->matType = $item->matType;
                                $materialModel->createTime = $item->createTime;
                                $materialModel->matDescribe = $item->matDescribe;
                                $materialModel->url = $item->url;
                                $materialModel->readNum = $item->readNum;
                                $materialModel->favoriteNum = $item->favoriteNum;
                                $materialModel->downNum = $item->downNum;
                                $materialModel->isBoutique = $item->isBoutique;
                                $materialModel->image = ImagePathHelper::imgThumbnail($item->image,250,140);
                                $arr['items'][] = $materialModel;
                            }
                        }
                        return $arr;
                    }
                ],

            ];

    }

}
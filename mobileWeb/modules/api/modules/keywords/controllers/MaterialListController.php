<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 18-1-4
 * Time: 上午11:47
 */

namespace mobileWeb\modules\api\modules\keywords\controllers;


use common\clients\material\MaterialMicroService;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class MaterialListController extends Controller
{
    /**
     * 关键字搜索相关课件
     * @return \stdClass
     * @throws BadRequestHttpException
     */
    public function actionIndex()
    {
        $page = (int)app()->request->get('page', 1);
        $perPage = (int)app()->request->get('per-page', 10);
        $keywords = (string)app()->request->get('keywords', '');
        $isHighlight = (int)app()->request->get('is-highlight', 0);

        if ($keywords == '') {
            throw new BadRequestHttpException('参数不正确！');
        }

        $restResult = new \stdClass();
        $restResult->pageCount = 0;
        $restResult->totalCount = 0;
        $restResult->page = $page;
        $restResult->perPage = $perPage;
        $restResult->data = [];

        $model = new MaterialMicroService();
        $result = $model->searchKeywords($keywords, $page, $perPage, $isHighlight);
        if (isset($result->code) && $result->code == 200) {
            $materialResult = $result->body;
            $restResult->pageCount = $materialResult->pageCount;
            $restResult->totalCount = $materialResult->totalCount;
            $restResult->data = $materialResult->data;
        }

        return $restResult;
    }


}
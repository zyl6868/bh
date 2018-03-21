<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 18-1-4
 * Time: 上午11:46
 */

namespace mobileWeb\modules\api\modules\keywords\controllers;


use common\clients\homework\HomeworkService;
use yii\web\BadRequestHttpException;
use yii\rest\Controller;

class HomeworkListController extends Controller
{

    /**
     * 关键字搜索相关作业
     * @return \stdClass
     * @throws BadRequestHttpException
     */
    public function actionIndex()
    {
        $page = app()->request->get('page', 1);
        $perPage = app()->request->get('per-page', 10);
        $keywords = app()->request->get('keywords', '');
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

        $model = new HomeworkService();
        $result = $model->searchKeywords($keywords, $page, $perPage, $isHighlight);
        if (isset($result->code) && $result->code == 200) {
            $homeworkResult = $result->body;
            $restResult->pageCount = $homeworkResult->pageCount;
            $restResult->totalCount = $homeworkResult->totalCount;
            $restResult->data = $homeworkResult->data;
        }

        return $restResult;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 18-1-4
 * Time: 上午11:41
 */

namespace mobileWeb\modules\api\modules\keywords\controllers;


use common\clients\homework\HomeworkService;
use common\clients\material\MaterialMicroService;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class HomeworkAndMaterialController extends Controller
{
    /**
     * 关键词搜索课件和作业
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

        //获取作业
        $restHomeworkResult = $this->getSourceList($keywords, $page, $perPage, $isHighlight, 'homework');

        //获取课件
        $restMaterialResult = $this->getSourceList($keywords, $page, $perPage, $isHighlight, 'material');

        //合并数据
        $restResult = new \stdClass();
        $restResult->homeworkList = $restHomeworkResult;
        $restResult->materialList = $restMaterialResult;

        return $restResult;
    }


    /**
     * 掉接口获取数据
     * @param string $keywords
     * @param int $page
     * @param int $perPage
     * @param int $isHighlight
     * @param string $type
     * @return \stdClass
     */
    private function getSourceList(string $keywords, int $page, int $perPage, int $isHighlight, string $type)
    {
        $restResult = new \stdClass();
        $restResult->pageCount = 0;
        $restResult->totalCount = 0;
        $restResult->page = $page;
        $restResult->perPage = $perPage;
        $restResult->data = [];

        if ($type == 'homework') {
            $model = new HomeworkService();
        } else {
            $model = new MaterialMicroService();
        }
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
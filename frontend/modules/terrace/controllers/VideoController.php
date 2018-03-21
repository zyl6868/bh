<?php
namespace frontend\modules\terrace\controllers;

use frontend\components\BaseAuthController;
use frontend\services\apollo\Apollo_ResourceManageService;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-18
 * Time: 上午10:01
 */
class VideoController extends BaseAuthController
{
    public $layout = "lay_new_terrace";

    /**
     * 视频列表
     */
    public function actionIndex()
    {

        $pages = new Pagination();$pages->validatePage=false;
        $pages->pageSize = 10;

        $tag = app()->request->getQueryParam('tag', '');
        $videoName = app()->request->getQueryParam('videoName', '');
        $order = app()->request->getQueryParam('order', '');

        $gradeid = app()->request->getQueryParam('gradeid', '');
        $subjectid = app()->request->getQueryParam('subjectid', '');
        $type = app()->request->getQueryParam('type', '');
        $year = app()->request->getQueryParam('year', '');

        $teacherMaterial = new Apollo_ResourceManageService();
        $classMatInfo = $teacherMaterial->videoSearch($tag, $videoName, $gradeid, $subjectid, $year, $type, $order, $pages->getPage() + 1, $pages->pageSize);

        $pages->totalCount = intval($classMatInfo->countSize);
        $pages->params = [
            'gradeid' => $gradeid,
            'subjectid' => $subjectid,
            'type' => $type,
            'year' => $year,
            'videoName' => $videoName,
        ];
        if (app()->request->isAjax) {
            return $this->renderPartial('_list_video', array('pages' => $pages, 'model' => $classMatInfo->videoList,));
        }
        return $this->render('index', array(
            'model' => $classMatInfo->videoList,
            'pages' => $pages,
            'gradeid' => $gradeid,
            'subjectid' => $subjectid,
            'type' => $type,
            'year' => $year,
            'videoName' => $videoName,
        ));
    }

    /**
     * 视频详情
     */
    public function actionVideoDetails()
    {

        $id = app()->request->getQueryParam('id');
        $teacherMaterial = new Apollo_ResourceManageService();
        $details = $teacherMaterial->videoDetail($id);

        if ($details == null) {
            return $this->notFound();
        }
        return $this->render('videodetails', array('model' => $details));

    }

}
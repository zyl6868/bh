<?php
namespace frontend\modules\teacher\controllers;

use frontend\components\PrintMakePager;
use frontend\components\TeacherBaseController;
use frontend\services\pos\pos_PaperManageService;

/**
 * Created by yangjie
 * User: Administrator
 * Date: 14-10-16
 * Time: 下午16:27
 */
class MakepaperController extends TeacherBaseController
{
    public $layout = 'lay_user';


    //下载试卷
    public function   actionPrintWord($id)
    {
//        foreach (Yii::$app->log->routes as $route) {
//            if ($route instanceof CWebLogRoute) {
//                $route->enabled = false;
//            }
//        }
        $q = new  pos_PaperManageService();
        $result = $q->queryMakerPaperById($id);

        $pager = new   PrintMakePager($result);
        $pager->run();

    }


}
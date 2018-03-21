<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/4/28
 * Time: 9:25
 */
namespace schoolmanage\modules\statistics\controllers;

use schoolmanage\components\SchoolManageBaseAuthController;
use schoolmanage\models\Homeworkuse;
use Yii;

class HomeworkuseController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_statistics_index';


    /*
     * 作业使用统计
     */
    public function actionIndex()
    {
        $n = time() - 86400 * date('N', time());
        $week_start = date('Y-m-d', $n - 86400 * 6 );
        $week_end = date('Y-m-d', $n);

        $searchModel = new Homeworkuse();
        $dataProvider = $searchModel->search($this->schoolId,$week_start,$week_end);
        if (yii::$app->request->getIsAjax()) {
            return $this->renderPartial('_namelist', ['dataProvider' => $dataProvider]);
        }
        return $this->render('index',['dataProvider'=>$dataProvider,'week_end'=>$week_end,'week_start'=>$week_start]);
    }


}
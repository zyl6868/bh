<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 16:47
 */

namespace frontend\modules\classstatistics\controllers;

use common\helper\dt\Carbon;
use common\models\pos\SeHomeworkClassReport;
use frontend\components\ClassesBaseController;
use common\models\dicmodels\SubjectModel;

class HomeworkexcellentrateController extends ClassesBaseController
{
    public $layout = '@app/views/layouts/lay_new_classstatistic_v2';

    /**
     * @param integer $classId
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionIndex(int $classId)
    {
        $this->getClassModel($classId);

        $classCreateYear = 2014;
        $nowYear = date('Y',time());
        $years = [];
        for($i=$classCreateYear ; $i<=$nowYear ;$i++){
            $years[] = $i;
        }

        $months = [1,2,3,4,5,6,7,8,9,10,11,12];

        $year = app()->request->post('year');
        $month = app()->request->post('month');

        $time = date('Y-m-d H:i:s',time());
        $timeModel=  Carbon::parse($time);
        $firstDay = $timeModel->firstOfMonth()->addMonthNoOverflow(-1)->toDateTimeString();  //上个月第一天
        $lastDay = $timeModel->lastOfMonth()->addMonthNoOverflow(-1)->toDateTimeString();   // 上个月最后一天

        if(!empty($year) && !empty($month)){
            $firstDay = $year. '-' .$month. '-01';
            $timeModel=  Carbon::parse($firstDay);
            $lastDay = $timeModel->lastOfMonth()->toDateTimeString();
        }

        $classHomeworkReport = SeHomeworkClassReport::find()->where(['classId'=>$classId])
            ->andWhere(['between', 'generateTime', $firstDay, $lastDay])
            ->all();

        $data = [];
        $subjectArr = [];
        $excellentArr = [];
        $goodArr = [];
        $middleArr = [];
        $badArr = [];
        foreach($classHomeworkReport as $report){
            $subjectArr[] = SubjectModel::model()->getName((int)$report->subjectId);
            $excellentArr[] = $report->excellentNum;
            $goodArr[] = $report->goodNum;
            $middleArr[] = $report->middleNum;
            $badArr[] = $report->badNum;
        }
        array_push($data ,$excellentArr,$goodArr,$middleArr,$badArr );

        if(app()->request->isAjax){
            return $this->renderPartial('_index_info',['subjectArr'=>$subjectArr ,'data'=>$data]);
        }


        return $this->render('index',['classId'=>$classId ,'years'=>$years,'months'=>$months , 'subjectArr'=>$subjectArr ,'data'=>$data ,'firstDay'=>$firstDay]);

    }






}
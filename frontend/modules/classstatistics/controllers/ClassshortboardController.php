<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2016/2/22
 * Time: 16:47
 */

namespace frontend\modules\classstatistics\controllers;

use common\models\databusiness\SdUserWeakness;
use common\models\databusiness\SdUserWeaknessKid;
use common\models\DateTime;
use common\models\pos\SeClass;
use common\models\sanhai\ShTestquestion;
use frontend\components\ClassesBaseController;
use frontend\components\helper\ViewHelper;
use common\models\dicmodels\KnowledgePointModel;
use yii\db\Query;

class ClassshortboardController extends ClassesBaseController
{
    public $layout = '@app/views/layouts/lay_new_classstatistic_v2';

    /**
     * 月短板
     * @param integer $classId
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionIndex(int $classId)
    {

        $this->getClassModel($classId);

        //查询所有科目
        $classModel = SeClass::find()->where(['classId'=>$classId])->one();
        $subjectNumber = $classModel->getClassSubjects();
        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));
        $dateTimeModel = new DateTime();
        $defaultYearMonth = $dateTimeModel->lastMonthYear.'-'.$dateTimeModel->lastMonth;
        $month = app()->request->get('month',$defaultYearMonth);

        $BeginDate = $month . '-01';
        $endDate = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
        $monthShortBoard = $this->getKnowledgePoint($classId,$subjectId,$BeginDate,$endDate);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }
        return $this->render('index',['classId'=>$classId,'subjectNumber'=>$subjectNumber,'monthShortBoard'=>$monthShortBoard,'defaultYearMonth'=>$defaultYearMonth]);
    }

    /**
     * 周短板
     * @param integer $classId
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionWeekShort(int $classId)
    {

        $this->getClassModel($classId);

        //查询所有科目
        $classModel = SeClass::find()->where(['classId'=>$classId])->one();
        $subjectNumber = $classModel->getClassSubjects();

        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));

        $n = time() - 86400 * date('N', time());
        $week_start = date('Y-m-d', $n - 86400 * 6 );
        $week_end = date('Y-m-d', $n);

        $weekstart = app()->request->get('weekstart', $week_start);
        $weekend = app()->request->get('weekend', $week_end);
        $defaultTime = $weekstart .','.$weekend;

        $monthShortBoard = $this->getKnowledgePoint($classId,$subjectId,$weekstart,$weekend);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }
        return $this->render('weekshort', ['classId' => $classId, 'subjectNumber' => $subjectNumber,'monthShortBoard'=>$monthShortBoard,'defaultTime'=>$defaultTime,'weekstart'=>$weekstart,'weekend'=>$weekend]);
    }

    /**
     * 日短板
     * @param integer $classId
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     * @throws \yii\base\ExitException
     */
    public function actionDayShort(int $classId)
    {
        $this->getClassModel($classId);

        //查询所有科目
        $classModel = SeClass::find()->where(['classId'=>$classId])->one();
        $subjectNumber = $classModel->getClassSubjects();

        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));

        $day = app()->request->get('day', date('Y-m-d',strtotime('-1 day')));

        $startDay = $day .' 00:00:00';
        $endDay = $day . ' 23:59:59';
        $monthShortBoard = $this->getKnowledgePoint($classId,$subjectId,$startDay,$endDay);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }
        return $this->render('dayshort', ['classId' => $classId, 'subjectNumber' => $subjectNumber,'monthShortBoard'=>$monthShortBoard]);

    }

    /**
     * 短板知识点
     * @param integer $classId
     * @param $subjectId
     * @param $BeginTime
     * @param $endTime
     * @param int $limit
     * @return array
     * @throws \yii\db\Exception
     */
    public  function  getKnowledgePoint(int $classId,$subjectId,$BeginTime,$endTime,$limit=15){

        $shortBoard = [];

        $db = SdUserWeaknessKid::getDb();
        $userWeaknessModel = new Query();
        $userWeaknessModel->select(['a.kid', 'count(a.kid) num'])
            ->from('sd_user_weakness_kid a')
            ->join('INNER JOIN', 'sd_user_weakness b', 'a.weakId=b.weakId')
            ->where('b.correctResult<3')
            ->andWhere('a.classId=:classId ',[':classId'=>$classId])
            ->andWhere('a.subjectId=:subjectId ',[':subjectId'=>$subjectId]);

        $userWeaknessModel->andWhere(['between','a.createTime',$BeginTime,$endTime]);

        $monthWeaknessData = $userWeaknessModel->groupBy('kid')->orderBy('num desc')->limit($limit)->createCommand($db)->queryAll();

        foreach($monthWeaknessData as $k =>$v){
            $shortBoard[$k]['num'] = $v['num'];
            $shortBoard[$k]['name'] = KnowledgePointModel::getNamebyId($v['kid']);
            $shortBoard[$k]['kid'] = $v['kid'];
        }

        return $shortBoard;
    }


    /**
     * 短板错题
     * @param integer $classId
     * @param $kid
     * @param $timezone
     * @param $select
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionWeaknessQuestions(int $classId,$kid,$timezone,$select){

        if(empty($kid)){
            echo ViewHelper::emptyView('该班级暂无短板错题！');
        }


        //查询知识点对应的短板池id
        $userWeaknessKidModel = SdUserWeaknessKid::find()->where(['kid' => $kid]);
        if(!empty($classId)){
            $userWeaknessKidModel->andWhere(['classId' => $classId]);
        }

        if($select == 'month'){
            $BeginDate = $timezone . '-01';
            $endDate = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
            $userWeaknessKidModel->andWhere(['between','createTime',$BeginDate,$endDate]);
        }elseif($select == 'week'){
            $select = explode(',',$timezone);
            $week_start=$select[0];
            $week_end=$select[1];
            $userWeaknessKidModel->andWhere(['between','createTime',$week_start,$week_end]);
        }elseif($select == 'day'){
            $userWeaknessKidModel->andWhere(['createTime'=>$timezone]);
        }
        $weakId = $userWeaknessKidModel->select('weakId')->distinct()->column();
        //查询错题
        $userWeaknessModel = SdUserWeakness::find()->select(['count(questionId) as num','questionId'])->where(['weakId' => $weakId])->andWhere(['<','correctResult',3]);
        $questionIdList = $userWeaknessModel->groupBy('questionId')->asArray()->orderBy('num desc')->limit(20)->all();
        $testQuestionList = [];
        foreach($questionIdList as $v){
            $dataArray=['num'=>$v['num'],'questionDetails'=>ShTestquestion::find()->where(['id' => $v['questionId']])->one()];
            $testQuestionList[] = $dataArray;
        }

        return $this->renderPartial('error_question',['testQuestionList'=>$testQuestionList]);


    }


}
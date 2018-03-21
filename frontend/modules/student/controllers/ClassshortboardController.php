<?php
namespace frontend\modules\student\controllers;

use common\helper\dt\Carbon;
use common\models\databusiness\SdUserWeakness;
use common\models\databusiness\SdUserWeaknessKid;
use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\sanhai\ShTestquestion;
use frontend\components\helper\ViewHelper;
use frontend\components\StudentBaseController;
use common\models\dicmodels\KnowledgePointModel;
use yii\db\Query;
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 2016/10/11
 * Time: 10:10
 */

class ClassshortboardController extends StudentBaseController
{
    public $layout = 'lay_user_new';

    /**
     * 月短板
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @internal param $classId
     */
    public function actionIndex()
    {
        $userModel = loginUser();
        $userId = $userModel->userID;
        $seClassData = SeClassMembers::find()->where(['userID' => $userModel->userID])->one();
        $subjectNumber = [];
        if(!empty($seClassData)){
            $classId = $seClassData->classID;

            //查询所有科目
            $classModel = SeClass::find()->where(['classId'=>$classId])->one();
            $subjectNumber = $classModel->getClassSubjects();
        }

        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));

        $time = date('Y-m-d H:i:s',time());
        $timeModel=  Carbon::parse($time);
        $firstDay = $timeModel->firstOfMonth()->addMonthNoOverflow(-1)->toDateTimeString();  //上个月第一天
        $lastDay = $timeModel->lastOfMonth()->addMonthNoOverflow(-1)->toDateTimeString();   //上个月最后一天


        $month = app()->request->get('month');
        if(!empty($month)){
            $firstDay = $month . '-01';
            $timeModel=  Carbon::parse($firstDay);
            $lastDay = $timeModel->lastOfMonth()->toDateTimeString();
        }

        $monthShortBoard = $this->getKnowledgePoint($userId,$subjectId,$firstDay,$lastDay);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }

        return $this->render('index',['subjectNumber'=>$subjectNumber,'monthShortBoard'=>$monthShortBoard,'firstDay'=>$firstDay]);
    }


    /**
     * 周短板
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidParamException
     * @internal param $classId
     */
    public function actionWeekShort()
    {

        $userModel = loginUser();
        $userId = $userModel->userID;
        $seClassData = SeClassMembers::find()->where(['userID' => $userModel->userID])->one();
        $subjectNumber = [];
        if(!empty($seClassData)){
            $classId = $seClassData->classID;

            //查询所有科目
            $classModel = SeClass::find()->where(['classId'=>$classId])->one();
            $subjectNumber = $classModel->getClassSubjects();
        }

        $subjectId = app()->request->get('subjectId',empty($subjectNumber)?[]:key($subjectNumber[0]));

        $n = time() - 86400 * date('N', time());
        $week_start = date('Y-m-d', $n - 86400 * 6 );
        $week_end = date('Y-m-d', $n);

        $weekstart = app()->request->get('weekstart', $week_start);
        $weekend = app()->request->get('weekend', $week_end);
        $defaultTime = $weekstart .','.$weekend;

        $monthShortBoard = $this->getKnowledgePoint($userId,$subjectId,$weekstart,$weekend);

        if(app()->request->isAjax) {
            return $this->renderPartial('short_board',['monthShortBoard'=>$monthShortBoard]);
        }
        return $this->render('weekshort', ['subjectNumber' => $subjectNumber,'monthShortBoard'=>$monthShortBoard,'defaultTime'=>$defaultTime,'weekstart'=>$weekstart,'weekend'=>$weekend]);
    }

    /**
     * 短板知识点
     * @param $userId
     * @param $subjectId
     * @param $BeginTime
     * @param $endTime
     * @param int $limit
     * @return array
     * @throws \yii\db\Exception
     * @internal param $classId
     */
    public  function  getKnowledgePoint($userId,$subjectId,$BeginTime,$endTime,$limit=15){

        $shortBoard = [];

        $db = SdUserWeaknessKid::getDb();
        $userWeaknessModel = new Query();
        $userWeaknessModel->select(['a.kid', 'count(a.kid) num'])
            ->from('sd_user_weakness_kid a')
            ->join('INNER JOIN', 'sd_user_weakness b', 'a.weakId=b.weakId')
            ->where('b.correctResult<3')
            ->andWhere('a.userId=:userId ',[':userId'=>$userId])
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
     * @param $kid
     * @param $timezone
     * @param $select
     * @return string
     * @throws \yii\base\InvalidParamException
     * @internal param $classId
     */
    public function actionWeaknessQuestions($kid,$timezone,$select){

        if(empty($kid)){
            echo ViewHelper::emptyView('该班级暂无短板错题！');
        }
        $userModel = loginUser();
        $userId = $userModel->userID;

        //查询知识点对应的短板池id
        $userWeaknessKidModel = SdUserWeaknessKid::find()->where(['kid' => $kid]);
        $userWeaknessKidModel->andWhere(['userId'=>$userId]);
        if($select == 'month'){
            $BeginDate = $timezone . '-01';
            $endDate = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
            $userWeaknessKidModel->andWhere(['between','createTime',$BeginDate,$endDate]);
        }elseif($select == 'week'){
            $select = explode(',',$timezone);
            $week_start=$select[0];
            $week_end=$select[1];
            $userWeaknessKidModel->andWhere(['between','createTime',$week_start,$week_end]);
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
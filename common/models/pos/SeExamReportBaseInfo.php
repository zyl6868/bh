<?php

namespace common\models\pos;

use common\components\WebDataCache;
use Yii;

/**
 * This is the model class for table "se_exam_reportBaseInfo".
 *
 * @property integer $examReportId 报表主键id
 * @property integer $schoolExamId 考试id（学校）
 * @property integer $classExamId 考试id（班级）
 * @property integer $classId 班级id
 * @property integer $subjectId 科目id
 * @property integer $realNumber 实考人数
 * @property integer $missNumber 缺考人数
 * @property integer $fullScore 满分
 * @property string $avgScore 平均分
 * @property string $maxScore 最高分
 * @property string $minScore 最低分
 * @property integer $goodNum 优良人数
 * @property integer $noPassNum 不及格人数
 * @property integer $lowScoreNum 低分人数
 * @property integer $overLineNum 上线人数
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 */
class SeExamReportBaseInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_reportBaseInfo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schoolExamId', 'fullScore', 'avgScore', 'maxScore', 'minScore', 'createTime'], 'required'],
            [['schoolExamId', 'classExamId', 'classId', 'subjectId', 'realNumber', 'missNumber', 'fullScore', 'goodNum', 'noPassNum', 'lowScoreNum', 'overLineNum', 'createTime', 'updateTime'], 'integer'],
            [['avgScore', 'maxScore', 'minScore'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'examReportId' => '报表主键id',
            'schoolExamId' => '考试id（学校）',
            'classExamId' => '考试id（班级）',
            'classId' => '班级id',
            'subjectId' => '科目id',
            'realNumber' => '实考人数',
            'missNumber' => '缺考人数',
            'fullScore' => '满分',
            'avgScore' => '平均分',
            'maxScore' => '最高分',
            'minScore' => '最低分',
            'goodNum' => '优良人数',
            'noPassNum' => '不及格人数',
            'lowScoreNum' => '低分人数',
            'overLineNum' => '上线人数',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamReportBaseInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamReportBaseInfoQuery(get_called_class());
    }


    /**
     * 统计——概览
     * 成绩概览
     * 单年级，单科目
     * @param int $examId 考试ID
     * @param int|null $classId 班级ID
     * @param int|null $subjectId 科目ID
     * @return array|bool
     */
    public static function getSingleClassSingleSubjectInfo(int $examId , int $classId=null , int $subjectId=null){

        $data = [];
        $seExamReprotBaseInfoList = SeExamReportBaseInfo::find()->where(['schoolExamId'=>$examId ,'subjectId'=>$subjectId ,'classId'=>$classId])->limit(1)->one();

        $seExamClass = SeExamClass::find()->where(['schoolExamId'=>$examId ,'classId'=>$classId])->limit(1)->one();
        if(empty($seExamClass)){
            return false;
        }
        $classExamId = $seExamClass->classExamId;

        //班级前5名
        $rankListDesc = SeExamPersonalScore::find()->where(['classExamId'=>$classExamId])->select("sub$subjectId")->groupBy('sub'.$subjectId)->orderBy('sub'.$subjectId.' desc')->limit('5')->column();
        $subArrDesc = [];
        foreach ($rankListDesc as $rankDesc) {
            $userInfoAsc = [];
            $userInfoAsc['score'] = $rankDesc;
            $rankScoreListDesc = SeExamPersonalScore::find()->where(['sub'.$subjectId=>$rankDesc , 'classExamId'=>$classExamId])->select("userId")->all();

            foreach($rankScoreListDesc as $rankScoreDesc){
                $userInfoAsc['userId'][] = WebDataCache::getTrueNameByuserId($rankScoreDesc->userId);;
            }
            $subArrDesc[] = $userInfoAsc;
        }

        //班级后5名
        $rankListAsc = SeExamPersonalScore::find()->where(['classExamId'=>$classExamId])->select("sub$subjectId")->groupBy('sub'.$subjectId)->orderBy('sub'.$subjectId.' asc')->limit('5')->column();
        $subArrAsc = [];
        foreach ($rankListAsc as $rankAsc) {
            $userInfoAsc = [];
            $userInfoAsc['score'] = $rankAsc;
            $rankScoreListAsc = SeExamPersonalScore::find()->where(['sub'.$subjectId=>$rankAsc , 'classExamId'=>$classExamId])->select("userId")->all();

            foreach($rankScoreListAsc as $rankScoreAsc){
                $userInfoAsc['userId'][] = WebDataCache::getTrueNameByuserId($rankScoreAsc->userId);
            }
            $subArrAsc[] = $userInfoAsc;
        }

        $data['seExamReprotBaseInfoList'] = $seExamReprotBaseInfoList;
        $data['rankListDesc'] = $subArrDesc;
        $data['rankListAsc'] = $subArrAsc;

        return $data;
    }


    /**
     * 统计——概览
     * 成绩概览
     * 全年级，单科目
     * @param int $examId 考试ID
     * @param int $subjectId 科目ID
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getAllClassSingleSubjectInfo(int $examId , int $subjectId){

        $seExamReportBaseInfo = SeExamReportBaseInfo::findBySql("select schoolExamId ,subjectId ,MAX(maxScore) as maxScore ,MIN(minScore) as minScore,SUM((realNumber+missNumber)*avgScore)/SUM(realNumber+missNumber) avgScore,SUM(realNumber) realNumber,SUM(missNumber) missNumber,SUM(noPassNum) noPassNum , SUM(goodNum) goodNum, SUM(lowScoreNum) lowScoreNum,SUM(overLineNum) as overLineNum from se_exam_reportBaseInfo".
            " where schoolExamId=:schoolExamId and subjectId=:subjectId" , [':schoolExamId'=>$examId ,':subjectId'=>$subjectId ])->limit(1)->one();

        return $seExamReportBaseInfo;
    }


    /**
     * 统计——概览
     * 成绩概览
     * 全年级，单班级
     * @param int $examId 考试ID
     * @param int $classId 班级ID
     * @return array|SeExamReportBaseInfo[]
     */
    public static function getSingleClassAllSubjectInfo(int $examId , int $classId){

        $seExamReprotBaseInfoList = SeExamReportBaseInfo::find()->where(['schoolExamId'=>$examId  ,'classId'=>$classId])->all();
        return $seExamReprotBaseInfoList;
    }


    /**
     * 统计——概览
     * 成绩概览
     * 全部年级全部科目
     * @param int $examId 考试ID
     * @return array
     */
    public static function getAllClassAllSubjectInfo(int $examId ){


        $subjectList = SeExamReportBaseInfo::find()->where(['schoolExamId'=>$examId])->groupBy(['subjectId' ])->select('subjectId')->all();
        $data = [];
        foreach($subjectList as $subject){

            $seExamReportBaseInfo = SeExamReportBaseInfo::findBySql("select schoolExamId , subjectId ,MAX(maxScore) as maxScore ,MIN(minScore) as minScore,SUM((realNumber+missNumber)*avgScore)/SUM(realNumber+missNumber) avgScore,SUM(realNumber) realNumber,SUM(missNumber) missNumber,SUM(noPassNum) noPassNum , SUM(goodNum) goodNum, SUM(lowScoreNum) lowScoreNum,SUM(overLineNum) as overLineNum from se_exam_reportBaseInfo".
                " where schoolExamId=:schoolExamId and subjectId=:subjectId" , [':schoolExamId'=>$examId ,':subjectId'=>$subject->subjectId ])->limit(1)->one();

            array_push($data , $seExamReportBaseInfo);
        }

        return $data;
    }

    /**
     * 统计——概览
     * 成绩概览
     * 优良率
     */
    public function getExcellentRate(){

        $classNum = $this->realNumber + $this->missNumber;
        return sprintf("%.2f", $classNum == 0 ? 0 : $this->goodNum / $classNum * 100);

    }

    /**
     * 统计——概览
     * 成绩概览
     * 及格率
     */
    public function getPassRate(){

        $classNum = $this->realNumber + $this->missNumber;
        return sprintf("%.2f", $classNum == 0 ? 0 : ($classNum - $this->noPassNum) / $classNum * 100);

    }

    /**
     * 统计——概览
     * 成绩概览
     * 低分率
     */
    public function getLowScoreRate(){

        $classNum = $this->realNumber + $this->missNumber;
        return sprintf("%.2f", $classNum == 0 ? 0 : $this->lowScoreNum / $classNum * 100) ;

    }

    /**
     * 统计——概览
     * 成绩概览
     * 分数线
     */
    public function getScoreLineOne(){

        $scoreLine = 0;
        $seExamSubject = SeExamSubject::find()->where(['schoolExamId'=>$this->schoolExamId ,'subjectId'=>$this->subjectId])->select('borderlineOne')->limit(1)->one();

        if(!empty($seExamSubject->borderlineOne)){
            $scoreLine = $seExamSubject->borderlineOne;
        }
        return $scoreLine;
    }

    /**
     * 统计——概览
     * 成绩概览
     * 满分
     */
    public function getFullScore(){

        $fullScore = 0;
        $seExamSubject = SeExamSubject::find()->where(['schoolExamId'=>$this->schoolExamId ,'subjectId'=>$this->subjectId])->select('fullScore')->limit(1)->one();

        if(!empty($seExamSubject->fullScore)){
            $fullScore = $seExamSubject->fullScore;
        }
        return $fullScore;
    }




}

<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homework_classDayReport".
 *
 * @property integer $sid
 * @property integer $classId
 * @property integer $subjectId
 * @property integer $finishNum
 * @property integer $totalNum
 * @property integer $excellentNum
 * @property integer $goodNum
 * @property integer $middleNum
 * @property integer $badNum
 * @property integer $createTime
 * @property string $generateTime
 */
class SeHomeworkClassDayReport extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework_classDayReport';
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
            [['classId', 'subjectId', 'finishNum', 'totalNum', 'excellentNum', 'goodNum', 'middleNum', 'badNum', 'createTime'], 'integer'],
            [['generateTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'classId' => 'Class ID',
            'subjectId' => 'Subject ID',
            'finishNum' => 'Finish Num',
            'totalNum' => 'Total Num',
            'excellentNum' => 'Excellent Num',
            'goodNum' => 'Good Num',
            'middleNum' => 'Middle Num',
            'badNum' => 'Bad Num',
            'createTime' => 'Create Time',
            'generateTime' => 'Generate Time',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkClassDayReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkClassDayReportQuery(get_called_class());
    }

    /**
     * 班级日报告求和
     * @param string $monthBegin
     * @param string $monthEnd
     * @return array|SeHomeworkClassDayReport[]
     */
    public static function getClassStatistic(string $monthBegin,string $monthEnd){

       return SeHomeworkClassDayReport::find()
           ->select(['classId','subjectId','sum(finishNum) finishNum','sum(totalNum) totalNum','sum(excellentNum) excellentNum','sum(goodNum) goodNum','sum(middleNum) middleNum','sum(badNum) badNum','generateTime'])
           ->where(['between','generateTime',$monthBegin,$monthEnd])
           ->groupBy('classId,subjectId')
           ->orderBy('classId,subjectId')
           ->asArray()->all();

    }
}

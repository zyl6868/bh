<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_reportClassRank".
 *
 * @property integer $reportCalssRankId
 * @property integer $schoolExamId
 * @property integer $classExamId
 * @property integer $classId
 * @property integer $subjectId
 * @property integer $rankNum
 */
class SeExamReportClassRank extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_reportClassRank';
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
            [['schoolExamId', 'rankNum'], 'required'],
            [['schoolExamId', 'classExamId', 'classId', 'subjectId', 'rankNum'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reportCalssRankId' => '班级排名报表',
            'schoolExamId' => '考试id（学校）',
            'classExamId' => '考试id（班级）',
            'classId' => '班级id',
            'subjectId' => '科目id',
            'rankNum' => '排名',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamReportClassRankQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamReportClassRankQuery(get_called_class());
    }
}

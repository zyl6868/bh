<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_reportStudentStructure".
 * 学生构成分析表,记录每个班各个等级的人数
 * @property integer $reportStructureId 记录id
 * @property integer $schoolExamId 考试id（学校）
 * @property integer $classId 班级id
 * @property integer $AplusNum A+Num
 * @property integer $ANum ANum
 * @property integer $BplusNum B+Num
 * @property integer $BNum BNum
 * @property integer $CplusNum C+Num
 * @property integer $CNum CNum
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 */
class SeExamReportStudentStructure extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_reportStudentStructure';
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
            [['schoolExamId', 'createTime'], 'required'],
            [['schoolExamId', 'classId', 'AplusNum', 'ANum', 'BplusNum', 'BNum', 'CplusNum', 'CNum', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reportStructureId' => '记录id',
            'schoolExamId' => '考试id（学校）',
            'classId' => '班级id',
            'AplusNum' => 'A+Num',
            'ANum' => 'ANum',
            'BplusNum' => 'B+Num',
            'BNum' => 'BNum',
            'CplusNum' => 'C+Num',
            'CNum' => 'CNum',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamReportStudentStructureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamReportStudentStructureQuery(get_called_class());
    }
}

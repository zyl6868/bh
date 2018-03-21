<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_platform".
 *
 * @property integer $examId
 * @property string $examName
 * @property integer $examType
 * @property integer $gradeId
 * @property string $schoolYear
 * @property integer $semester
 * @property integer $subjectType
 * @property integer $createTime
 * @property integer $updateTime
 */
class SeExamPlatform extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_platform';
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
            [['examType', 'gradeId', 'semester', 'subjectType', 'createTime', 'updateTime'], 'integer'],
            [['examName'], 'string', 'max' => 50],
            [['schoolYear'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'examId' => '考试id',
            'examName' => '考试名称',
            'examType' => '考试类型',
            'gradeId' => '年级',
            'schoolYear' => '学年',
            'semester' => '学期',
            'subjectType' => '文/理',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamPlatformQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamPlatformQuery(get_called_class());
    }
}

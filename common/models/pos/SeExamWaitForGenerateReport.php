<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_waitForGenerateReport".
 *
 * @property integer $waitForGenerateReportId
 * @property integer $schoolExamId
 * @property integer $processStatus
 * @property integer $createTime
 * @property integer $updateTime
 */
class SeExamWaitForGenerateReport extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_waitForGenerateReport';
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
            [['schoolExamId', 'processStatus', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'waitForGenerateReportId' => '待生成报表考试',
            'schoolExamId' => '考试id（学校）',
            'processStatus' => '处理状态',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamWaitForGenerateReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamWaitForGenerateReportQuery(get_called_class());
    }
}

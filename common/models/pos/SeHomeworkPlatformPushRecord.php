<?php

namespace common\models\pos;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "se_homework_platform_push_record".
 *
 * @property integer $id
 * @property integer $homeworkId
 * @property integer $subjectId
 * @property integer $gradeId
 * @property integer $versionId
 * @property integer $homeworkType
 * @property integer $createTime
 * @property integer $pushTime
 */
class SeHomeworkPlatformPushRecord extends ActiveRecord
{
    /**
     * 基础作业
     */
    const BASIC_HOMEWORK = 2241110;
    /**
     * 提高作业
     */
    const ADVANCE_HOMEWORK = 2241111;
    /**
     * 单元检测
     */
    const UNIT_TEST = 2241100;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework_platform_push_record';
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
            [['homeworkId'], 'required'],
            [['homeworkId', 'subjectId', 'gradeId', 'versionId', 'homeworkType', 'createTime', 'pushTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'homeworkId' => 'Homework ID',
            'subjectId' => 'Subject ID',
            'gradeId' => 'Grade ID',
            'versionId' => 'Version ID',
            'homeworkType' => 'Homework Type',
            'createTime' => 'Create Time',
            'pushTime' => 'Push Time',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformPushRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkPlatformPushRecordQuery(get_called_class());
    }

}

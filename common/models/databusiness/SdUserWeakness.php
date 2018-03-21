<?php

namespace common\models\databusiness;

use Yii;

/**
 * This is the model class for table "sd_user_weakness".
 *
 * @property integer $weakId
 * @property integer $userId
 * @property string $createTime
 * @property integer $questionId
 * @property integer $correctResult
 * @property integer $sourceType
 * @property integer $sourceId
 * @property integer $schoolId
 * @property string $areaId
 * @property integer $gradeId
 * @property integer $subjectId
 * @property integer $tqtid
 * @property integer $classId
 */
class SdUserWeakness extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sd_user_weakness';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_databusiness');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'createTime', 'questionId', 'schoolId', 'areaId', 'gradeId', 'subjectId', 'classId'], 'required'],
            [['userId', 'questionId', 'correctResult', 'sourceType', 'sourceId', 'schoolId', 'gradeId', 'subjectId', 'tqtid', 'classId'], 'integer'],
            [['createTime'], 'safe'],
            [['areaId'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'weakId' => '主键id',
            'userId' => '用户id',
            'createTime' => '时间',
            'questionId' => '题目',
            'correctResult' => '对错，1错，2半对，3对',
            'sourceType' => '来源类型,1作业',
            'sourceId' => '来源id',
            'schoolId' => '学生学校id',
            'areaId' => '学生地区id',
            'gradeId' => '年级',
            'subjectId' => '题目的科目',
            'tqtid' => '题型',
            'classId' => '用户当时所在班级',
        ];
    }

    /**
     * @inheritdoc
     * @return SdUserWeaknessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdUserWeaknessQuery(get_called_class());
    }
}

<?php

namespace common\models\databusiness;

use Yii;

/**
 * This is the model class for table "sd_user_weakness_kid".
 *
 * @property integer $id
 * @property integer $weakId
 * @property integer $kid
 * @property integer $userId
 * @property integer $sourceType
 * @property integer $sourceId
 * @property integer $schoolId
 * @property string $areaId
 * @property integer $gradeId
 * @property integer $subjectId
 * @property string $createTime
 * @property integer $classId
 */
class SdUserWeaknessKid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sd_user_weakness_kid';
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
            [['weakId', 'kid', 'userId', 'schoolId', 'areaId', 'gradeId', 'subjectId', 'createTime', 'classId'], 'required'],
            [['weakId', 'kid', 'userId', 'sourceType', 'sourceId', 'schoolId', 'gradeId', 'subjectId', 'classId'], 'integer'],
            [['createTime'], 'safe'],
            [['areaId'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weakId' => '关联sd_user_weakness 的weakId',
            'kid' => '知识点id',
            'userId' => '用户id',
            'sourceType' => '作业 1作业',
            'sourceId' => '来源id',
            'schoolId' => 'user学校id',
            'areaId' => 'user地区id',
            'gradeId' => 'user年级id',
            'subjectId' => '科目id',
            'createTime' => '创建时间',
            'classId' => '用户当时所在班级id',
        ];
    }

    /**
     * @inheritdoc
     * @return SdUserWeaknessKidQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdUserWeaknessKidQuery(get_called_class());
    }
}

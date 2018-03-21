<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "{{%se_groupLecturePlanReport}}".
 *
 * @property string $lecturePlanReportId
 * @property string $lecturePlanID
 * @property string $reportTitle
 * @property string $reportContent
 * @property string $userID
 * @property integer $createTime
 * @property integer $updateTime
 * @property string $teachingGroupID
 */
class SeGroupLecturePlanReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_groupLecturePlanReport}}';
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
            [['lecturePlanID', 'userID'], 'required'],
            [['lecturePlanID', 'userID', 'createTime', 'updateTime', 'teachingGroupID'], 'integer'],
            [['reportTitle'], 'string', 'max' => 50,'tooLong'=>'标题不能超过50个字符'],
            [['reportContent'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lecturePlanReportId' => 'Lecture Plan Report ID',
            'lecturePlanID' => '听课计划ID',
            'reportTitle' => '报告标题',
            'reportContent' => '报告内容',
            'userID' => '用户ID',
            'createTime' => '创新时间',
            'updateTime' => '更新时间',
            'teachingGroupID' => 'Teaching Group ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeGroupLecturePlanReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupLecturePlanReportQuery(get_called_class());
    }
}

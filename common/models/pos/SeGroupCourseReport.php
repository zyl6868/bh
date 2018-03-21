<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "{{%se_groupCouseReport}}".
 *
 * @property string $courseReportId
 * @property string $courseID
 * @property string $reportTitle
 * @property string $reportContent
 * @property string $userID
 * @property integer $createTime
 * @property integer $updateTime
 * @property string $teachingGroupID
 */
class SeGroupCourseReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_groupCourseReport}}';
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
            [['courseID', 'userID'], 'required'],
            [['courseID', 'userID', 'createTime', 'updateTime', 'teachingGroupID'], 'integer'],
            [['reportTitle'], 'string', 'max' => 50],
            [['reportContent'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseReportId' => 'Course Report ID',
            'courseID' => '课题ID',
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
     * @return SeGroupCouseReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupCouseReportQuery(get_called_class());
    }
}

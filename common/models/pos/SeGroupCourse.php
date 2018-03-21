<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_groupCourse".
 *
 * @property integer $courseID
 * @property string $courseName
 * @property integer $gradeID
 * @property string $brief
 * @property string $url
 * @property integer $creatorID
 * @property integer $createTime
 * @property string $Type
 * @property integer $teachingGroupID
 * @property integer $isDelete
 */
class SeGroupCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_groupCourse';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    public function getGroupCourseMember()
    {
        return $this->hasMany(SeGroupCourseMember::className(), ['courseID' => 'courseID']);
    }

    public function getGroupCourseReport()
    {
        return $this->hasMany(SeGroupCourseReport::className(), ['courseID' => 'courseID']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gradeID', 'creatorID', 'createTime', 'teachingGroupID', 'isDelete'], 'integer'],
            [['courseName'], 'string', 'max' => 200],
            [['brief'], 'string', 'max' => 1000],
            [['url'], 'string', 'max' => 50],
            [['Type'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseID' => '课题ID',
            'courseName' => '课题名称',
            'gradeID' => '课题年级',
            'brief' => '课题描述',
            'url' => '课题要求附件URL',
            'creatorID' => '课题创建人',
            'createTime' => '课题创建时间',
            'Type' => '课题类型',
            'teachingGroupID' => '教研组id',
            'isDelete' => '是否已经删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeGroupCourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupCourseQuery(get_called_class());
    }
}

<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_dibbleCourseLimit".
 *
 * @property integer $limitID
 * @property string $courseID
 * @property string $stuLimit
 * @property string $groupMemberLimit
 * @property string $allMemLimit
 * @property string $isDelete
 * @property string $classID
 * @property string $creatorID
 * @property string $type
 * @property string $createTime
 * @property string $isShare
 */
class SeDibbleCourseLimit extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_dibbleCourseLimit';
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
     * @return SeDibbleCourseLimitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeDibbleCourseLimitQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['limitID'], 'required'],
            [['limitID'], 'integer'],
            [['courseID', 'stuLimit', 'groupMemberLimit', 'allMemLimit', 'classID', 'creatorID', 'createTime', 'isShare'], 'string', 'max' => 20],
            [['isDelete', 'type'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'limitID' => 'Limit ID',
            'courseID' => 'Course ID',
            'stuLimit' => 'Stu Limit',
            'groupMemberLimit' => 'Group Member Limit',
            'allMemLimit' => 'All Mem Limit',
            'isDelete' => 'Is Delete',
            'classID' => 'Class ID',
            'creatorID' => 'Creator ID',
            'type' => '0精品课程，1每周一课',
            'createTime' => 'Create Time',
            'isShare' => 'Is Share',
        ];
    }
}

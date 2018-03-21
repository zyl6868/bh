<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_internetParMeeting".
 *
 * @property integer $meeID
 * @property string $creatorID
 * @property string $classID
 * @property string $meetingName
 * @property string $meetingDetail
 * @property string $beginTime
 * @property string $finishTime
 * @property string $isDelete
 * @property string $createTime
 */
class SeInternetParMeeting extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_internetParMeeting';
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
     * @return SeInternetParMeetingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeInternetParMeetingQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meeID'], 'required'],
            [['meeID'], 'integer'],
            [['meetingDetail'], 'string'],
            [['creatorID', 'classID', 'beginTime', 'finishTime'], 'string', 'max' => 20],
            [['meetingName'], 'string', 'max' => 500],
            [['isDelete'], 'string', 'max' => 2],
            [['createTime'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'meeID' => 'Mee ID',
            'creatorID' => 'Creator ID',
            'classID' => 'Class ID',
            'meetingName' => 'Meeting Name',
            'meetingDetail' => 'Meeting Detail',
            'beginTime' => 'Begin Time',
            'finishTime' => 'Finish Time',
            'isDelete' => 'Is Delete',
            'createTime' => 'Create Time',
        ];
    }
}

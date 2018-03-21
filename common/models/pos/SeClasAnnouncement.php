<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_clasAnnouncement".
 *
 * @property integer $noticeID
 * @property string $classID
 * @property string $noticeName
 * @property string $noticeBrief
 * @property string $creatorID
 * @property string $createTime
 * @property string $timesOfView
 * @property string $isDelete
 * @property string $homeWorkId
 * @property string $meetingID
 * @property string $type
 * @property string $disabled
 */
class SeClasAnnouncement extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_clasAnnouncement';
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
     * @return SeClasAnnouncementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeClasAnnouncementQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noticeID'], 'required'],
            [['noticeID'], 'integer'],
            [['classID', 'creatorID', 'createTime', 'timesOfView'], 'string', 'max' => 20],
            [['noticeName', 'homeWorkId', 'meetingID', 'type'], 'string', 'max' => 100],
            [['noticeBrief'], 'string', 'max' => 1024],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'noticeID' => '公告id',
            'classID' => '班级id',
            'noticeName' => '公告名称',
            'noticeBrief' => '公告内容',
            'creatorID' => '公告创建人',
            'createTime' => '创建时间',
            'timesOfView' => '阅读次数',
            'isDelete' => '是否删除',
            'homeWorkId' => '作业ID',
            'meetingID' => '家长会ID',
            'type' => '公告类型',
            'disabled' => '是否禁用',
        ];
    }
}

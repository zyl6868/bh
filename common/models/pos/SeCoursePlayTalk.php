<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlayTalk".
 *
 * @property integer $talkID
 * @property string $courseID
 * @property string $userID
 * @property string $message
 * @property string $createTime
 * @property string $isDelete
 */
class SeCoursePlayTalk extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlayTalk';
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
     * @return SeCoursePlayTalkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayTalkQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['talkID'], 'required'],
            [['talkID'], 'integer'],
            [['courseID', 'userID', 'createTime'], 'string', 'max' => 20],
            [['message'], 'string', 'max' => 500],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'talkID' => '记录id',
            'courseID' => '课程id',
            'userID' => '用户id',
            'message' => '消息',
            'createTime' => 'Create Time',
            'isDelete' => 'Is Delete',
        ];
    }
}

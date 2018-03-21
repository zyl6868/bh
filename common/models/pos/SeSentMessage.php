<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_sentMessage".
 *
 * @property integer $messageID
 * @property string $messageTiltle
 * @property string $messageContent
 * @property integer $fromUserid
 * @property string $receiverUserID
 * @property string $messageType
 * @property string $sentTime
 * @property string $isRead
 * @property string $isDelete
 * @property string $objectID
 * @property string $senderIsDelet
 * @property string $disabled
 */
class SeSentMessage extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_sentMessage';
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
     * @return SeSentMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSentMessageQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['messageID'], 'required'],
            [['messageID', 'fromUserid'], 'integer'],
            [['messageTiltle', 'messageContent'], 'string'],
            [['receiverUserID', 'messageType', 'sentTime', 'objectID'], 'string', 'max' => 20],
            [['isRead', 'isDelete', 'senderIsDelet', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'messageID' => '消息id',
            'messageTiltle' => '消息标题',
            'messageContent' => '消息内容',
            'fromUserid' => '发送用户id',
            'receiverUserID' => '接受用户id',
            'messageType' => '发送类型',
            'sentTime' => '发送时间',
            'isRead' => '接收者是否阅读',
            'isDelete' => '接收者是否删除',
            'objectID' => '对象id',
            'senderIsDelet' => '发送者是否删除',
            'disabled' => '审核标识 0：审核通过，1：未审核',
        ];
    }
}

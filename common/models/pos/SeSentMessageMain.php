<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_sentMessageMain".
 *
 * @property integer $messageID
 * @property string $messageTiltle
 * @property string $messageContent
 * @property string $url
 * @property integer $fromUserid
 * @property string $mainType
 * @property string $messageType
 * @property string $sentTime
 * @property string $isDelete
 * @property string $objectID
 * @property string $disabled
 */
class SeSentMessageMain extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_sentMessageMain';
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
     * @return SeSentMessageMainQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSentMessageMainQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['messageID'], 'required'],
            [['messageID', 'fromUserid'], 'integer'],
            [['messageTiltle', 'messageContent', 'url'], 'string'],
            [['mainType', 'messageType', 'sentTime', 'objectID'], 'string', 'max' => 20],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
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
            'url' => '图片或咨询url',
            'fromUserid' => '发送用户id',
            'mainType' => '消息大类',
            'messageType' => '发送类型',
            'sentTime' => '发送时间',
            'isDelete' => '接收者是否删除',
            'objectID' => '对象id',
            'disabled' => '审核标识 0：审核通过，1：未审核',
        ];
    }
}

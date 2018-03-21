<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schlHomRcvr".
 *
 * @property integer $id
 * @property string $msgId
 * @property string $type
 * @property string $receiverId
 * @property string $receiverName
 * @property string $allOrPart
 */
class SeSchlHomRcvr extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schlHomRcvr';
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
     * @return SeSchlHomRcvrQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchlHomRcvrQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['msgId', 'type', 'receiverId', 'receiverName', 'allOrPart'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'msgId' => '短信id',
            'type' => '类型(class 班级 student 学生)',
            'receiverId' => '接收者id',
            'receiverName' => '接收者名称',
            'allOrPart' => '全部或部分(all 全部 part 部分)',
        ];
    }
}

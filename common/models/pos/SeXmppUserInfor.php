<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_xmppUserInfor".
 *
 * @property integer $id
 * @property string $userId
 * @property string $xmppPasswd
 * @property string $isDelete
 */
class SeXmppUserInfor extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_xmppUserInfor';
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
     * @return SeXmppUserInforQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeXmppUserInforQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['userId'], 'string', 'max' => 20],
            [['xmppPasswd'], 'string', 'max' => 100],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '评论ID',
            'userId' => '用户id',
            'xmppPasswd' => 'XMPP用户秘密',
            'isDelete' => '是否已删除',
        ];
    }
}

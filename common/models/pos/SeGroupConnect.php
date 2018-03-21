<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_groupConnect".
 *
 * @property integer $ID
 * @property string $beginGroupID
 * @property string $beginTime
 * @property string $acceptTime
 * @property string $initiator
 * @property string $askUserID
 * @property string $status
 * @property string $reason
 * @property string $isDelete
 * @property string $acceptGroupID
 * @property string $cancelUserID
 * @property string $cancelGroupID
 */
class SeGroupConnect extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_groupConnect';
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
     * @return SeGroupConnectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupConnectQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['beginGroupID', 'beginTime', 'acceptTime', 'initiator', 'askUserID', 'status', 'acceptGroupID', 'cancelUserID', 'cancelGroupID'], 'string', 'max' => 20],
            [['reason'], 'string', 'max' => 500],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '主键ID',
            'beginGroupID' => '发起绑定教研组ID',
            'beginTime' => '发起绑定时间',
            'acceptTime' => '接受绑定时间',
            'initiator' => '发起人',
            'askUserID' => '接受或驳回人',
            'status' => '状态0：发起手拉手班级申请中，1：已经通过申请，2：已经驳回申请，4：已经取消,已经解除',
            'reason' => '原因',
            'isDelete' => '是否删除，0未删除，1已删除',
            'acceptGroupID' => '接收教研组ID',
            'cancelUserID' => '取消操作用户id',
            'cancelGroupID' => '取消操作教研组id',
        ];
    }
}

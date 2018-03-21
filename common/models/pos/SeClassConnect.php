<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_classConnect".
 *
 * @property integer $ID
 * @property string $beginClassID
 * @property string $acceeptClassID
 * @property string $beginTime
 * @property string $userID
 * @property string $initiator
 * @property string $askUserID
 * @property string $status
 * @property string $isDelete
 * @property string $reason
 * @property string $cancelUserID
 * @property string $cancelClassID
 */
class SeClassConnect extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_classConnect';
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
     * @return SeClassConnectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeClassConnectQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['beginClassID', 'acceeptClassID', 'beginTime', 'userID', 'initiator', 'askUserID', 'status', 'cancelUserID', 'cancelClassID'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2],
            [['reason'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'id',
            'beginClassID' => '发起方班级id',
            'acceeptClassID' => '接受方班级id',
            'beginTime' => '发起时间',
            'userID' => '驳回/通过时间',
            'initiator' => '发起人',
            'askUserID' => '驳回/通过人',
            'status' => '状态',
            'isDelete' => '是否删除',
            'reason' => '应答原因',
            'cancelUserID' => 'Cancel User ID',
            'cancelClassID' => 'Cancel Class ID',
        ];
    }
}

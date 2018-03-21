<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionMore".
 *
 * @property integer $qMoreID
 * @property string $creatorID
 * @property string $qMoreDetail
 * @property string $createTime
 * @property string $isDelete
 * @property string $rel_aqID
 */
class SeQuestionMore extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionMore';
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
     * @return SeQuestionMoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionMoreQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qMoreID'], 'required'],
            [['qMoreID'], 'integer'],
            [['qMoreDetail'], 'string'],
            [['creatorID', 'createTime', 'rel_aqID'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qMoreID' => '补充问题主键ID',
            'creatorID' => '创建人ID',
            'qMoreDetail' => '补充问题详情',
            'createTime' => '创建时间',
            'isDelete' => '是否删除，0未删除，1已删除',
            'rel_aqID' => 'Rel Aq ID',
        ];
    }
}

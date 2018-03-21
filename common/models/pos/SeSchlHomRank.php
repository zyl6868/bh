<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schlHomRank".
 *
 * @property integer $id
 * @property string $msgId
 * @property string $low
 * @property string $high
 * @property string $peoples
 */
class SeSchlHomRank extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schlHomRank';
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
     * @return SeSchlHomRankQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchlHomRankQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['msgId', 'low', 'high', 'peoples'], 'string', 'max' => 20]
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
            'low' => '低分',
            'high' => '高分',
            'peoples' => '人数',
        ];
    }
}

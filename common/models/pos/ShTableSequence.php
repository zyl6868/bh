<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "sh_table_sequence".
 *
 * @property string $table_name
 * @property integer $current_seq
 */
class ShTableSequence extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_table_sequence';
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
     * @return ShTableSequenceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShTableSequenceQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name'], 'required'],
            [['current_seq'], 'integer'],
            [['table_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'table_name' => '表名称',
            'current_seq' => '表序列 从1开始',
        ];
    }
}

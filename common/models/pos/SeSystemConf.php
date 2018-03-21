<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_systemConf".
 *
 * @property string $variable
 * @property string $value
 * @property string $comment
 */
class SeSystemConf extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_systemConf';
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
     * @return SeSystemConfQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSystemConfQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variable'], 'required'],
            [['comment'], 'string'],
            [['variable'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variable' => '参数名',
            'value' => '参数值',
            'comment' => 'Comment',
        ];
    }
}

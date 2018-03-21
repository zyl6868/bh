<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_mParameter".
 *
 * @property integer $mid
 * @property string $mkey
 * @property string $mval
 * @property string $mtime
 */
class SeMParameter extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_mParameter';
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
     * @return SeMParameterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeMParameterQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mkey'], 'string', 'max' => 50],
            [['mval'], 'string', 'max' => 200],
            [['mtime'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mid' => 'Mid',
            'mkey' => 'Mkey',
            'mval' => 'Mval',
            'mtime' => '时间',
        ];
    }
}

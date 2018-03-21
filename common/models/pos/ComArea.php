<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "com_area".
 *
 * @property integer $AreaNo
 * @property string $AreaID
 * @property string $AreaPID
 * @property string $AreaName
 * @property integer $Levels
 */
class ComArea extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'com_area';
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
     * @return ComAreaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComAreaQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AreaNo', 'Levels'], 'integer'],
            [['AreaID', 'AreaPID'], 'string', 'max' => 30],
            [['AreaName'], 'string', 'max' => 90]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AreaNo' => 'Area No',
            'AreaID' => 'Area ID',
            'AreaPID' => 'Area Pid',
            'AreaName' => 'Area Name',
            'Levels' => 'Levels',
        ];
    }
}

<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_honorInformation".
 *
 * @property integer $honorID
 * @property string $honorInfor
 * @property string $honorType
 * @property integer $honorBelongID
 * @property string $isDelete
 */
class SeHonorInformation extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_honorInformation';
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
     * @return SeHonorInformationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHonorInformationQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['honorID'], 'required'],
            [['honorID', 'honorBelongID'], 'integer'],
            [['honorInfor'], 'string'],
            [['honorType'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'honorID' => '荣誉ID',
            'honorInfor' => '荣誉内容',
            'honorType' => '荣誉类型',
            'honorBelongID' => '荣誉所属对象',
            'isDelete' => '是否已删除',
        ];
    }
}

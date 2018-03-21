<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_sloganInfo".
 *
 * @property integer $id
 * @property string $aimID
 * @property string $slogan
 * @property string $sType
 * @property string $isDelete
 */
class SeSloganInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_sloganInfo';
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
     * @return SeSloganInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSloganInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['aimID'], 'string', 'max' => 20],
            [['slogan'], 'string', 'max' => 500],
            [['sType', 'isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'aimID' => '目标id',
            'slogan' => '口号内容',
            'sType' => '目标类型1学校、2班级、3教研组、4个人',
            'isDelete' => 'Is Delete',
        ];
    }
}

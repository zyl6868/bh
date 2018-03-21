<?php

namespace common\models\pos;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "se_materialShowRecord".
 *
 * @property integer $id
 * @property integer $favoriteId
 * @property integer $matType
 * @property integer $userId
 * @property string $createTime
 * @property integer $isBoutique
 */
class SeMaterialShowRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_materialShowRecord';
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
     */
    public function rules()
    {
        return [
            [['favoriteId', 'matType', 'userId', 'isBoutique'], 'integer'],
            [['createTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'favoriteId' => 'Favorite ID',
            'matType' => 'Mat Type',
            'userId' => 'User ID',
            'createTime' => 'Create Time',
            'isBoutique' => 'Is Boutique',
        ];
    }

    /**
     * @inheritdoc
     * @return SeMaterialShowRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeMaterialShowRecordQuery(get_called_class());
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime'],
                ],
                'value' => date("Y-m-d",time())
            ],
        ];
    }
}

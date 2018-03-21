<?php

namespace common\models\pos;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "se_materialDownloadRecord".
 *
 * @property integer $id
 * @property integer $favoriteId
 * @property integer $matType
 * @property integer $userId
 * @property integer $createTime
 * @property integer $isBoutique
 */
class SeMaterialDownloadRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_materialDownloadRecord';
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
            [['favoriteId', 'matType', 'userId', 'createTime', 'isBoutique'], 'integer']
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
     * @return SeMaterialDownloadRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeMaterialDownloadRecordQuery(get_called_class());
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

    /**
     * 获取用户下载记录
     * @param $fileId
     * @param $userId
     * @return array|SeMaterialDownloadRecord|null
     */
    public static function getDownloadRecord($fileId,$userId){

       return self::find()->where(['favoriteId'=>$fileId,'userId'=>$userId])->one();

    }
}

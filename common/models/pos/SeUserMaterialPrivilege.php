<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_userMaterialPrivilege".
 *
 * @property integer $id
 * @property integer $memberType
 * @property integer $operationType
 * @property integer $isBoutique
 * @property integer $number
 * @property string $createTime
 * @property string $updateTime
 */
class SeUserMaterialPrivilege extends \yii\db\ActiveRecord
{

    const MATERIAL_PREVIEW = 0;
    const MATERIAL_DOWNLOAD = 1;
    const MATERIAL_COLLECT = 2;
    const MATERIAL_SHOW = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_userMaterialPrivilege';
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
            [['memberType', 'operationType', 'isBoutique', 'number'], 'integer'],
            [['createTime', 'updateTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'memberType' => 'Member Type',
            'operationType' => 'Operation Type',
            'isBoutique' => 'Is Boutique',
            'number' => 'Number',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return SeUserMaterialPrivilegeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeUserMaterialPrivilegeQuery(get_called_class());
    }


    /**
     * 获取用户操作课件的次数
     * @param integer $userLevel
     * @param integer $operationType
     * @param integer $isBoutique
     * @return int
     */
    public static function getUserMaterialNum(int $userLevel,int $operationType,int $isBoutique){

        $userPrivilege = SeUserMaterialPrivilege::find()->where(['memberType'=>$userLevel,'operationType'=>$operationType,'isBoutique'=>$isBoutique])->one();
        $num = 0;
        if (!empty($userPrivilege)){
            $num = $userPrivilege->number;
        }
        return $num;

    }
}

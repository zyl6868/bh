<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\components\WebDataKey;
use Yii;

/**
 * This is the model class for table "se_shareMaterial".
 *
 * @property integer $id
 * @property integer $matId
 * @property integer $shareUserId
 * @property integer $classId
 * @property integer $groupId
 * @property integer $isDelete
 * @property integer $createTime
 */
class SeShareMaterial extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_shareMaterial';
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
            [['matId', 'shareUserId', 'classId', 'groupId', 'isDelete', 'createTime'], 'integer'],
            [['shareUserId'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matId' => 'Mat ID',
            'shareUserId' => 'Share User ID',
            'classId' => 'Class ID',
            'groupId' => 'Group ID',
            'isDelete' => 'Is Delete',
            'createTime' => '分享时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeShareMaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeShareMaterialQuery(get_called_class());
    }


    /**
     * 分享到班级
     * @param string $classId
     * @param int $userId
     * @param int $matId
     * @return bool
     */
    public static function shareToClass(string $classId,int $userId,int $matId)
    {
        if(!empty($classId)){
            $arrClassId = explode(',',$classId );
            foreach($arrClassId as $valClassId){
                $classFileModel = SeShareMaterial::find()->where(['classId'=>$valClassId,'matId'=>$matId])->limit(1)->one();
                if($classFileModel){
                    $classFileModel->shareUserId = $userId;
                    $classFileModel->createTime = DateTimeHelper::timestampX1000();
                }else{
                    $classFileModel = new SeShareMaterial();
                    $classFileModel->shareUserId = $userId;
                    $classFileModel ->matId = $matId;
                    $classFileModel ->classId = $valClassId;
                    $classFileModel->createTime = DateTimeHelper::timestampX1000();
                }
                if(!$classFileModel->save(false)){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 分享的教研组
     * @param string $groupId
     * @param int $userId
     * @param int $matId
     * @return bool
     */
    public static function shareToGroup(string $groupId,int $userId,int $matId)
    {
        if(!empty($groupId)){
            $arrGroupId = explode( ',',$groupId );
            foreach($arrGroupId as $valGroupId){
                $groupFileModel = SeShareMaterial::find()->where(['groupId'=>$valGroupId,'matId'=>$matId])->limit(1)->one();
                if($groupFileModel){
                    $groupFileModel->shareUserId = $userId;
                    $groupFileModel->createTime = DateTimeHelper::timestampX1000();
                }else{
                    $groupFileModel = new SeShareMaterial();
                    $groupFileModel->shareUserId = $userId;
                    $groupFileModel ->matId = $matId;
                    $groupFileModel ->groupId = $valGroupId;
                    $groupFileModel->createTime = DateTimeHelper::timestampX1000();
                }
                if(!$groupFileModel->save(false)){
                    return false;
                }
            }
        }
        return true;
    }
}

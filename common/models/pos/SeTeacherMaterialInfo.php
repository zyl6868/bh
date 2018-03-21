<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_teacherMaterialInfo".
 *
 * @property integer $ID
 * @property string $informationPackID
 * @property string $infoId
 * @property string $materialType
 * @property string $url
 * @property string $isDelete
 * @property string $name
 * @property string $brief
 * @property string $uploadTime
 * @property string $disabled
 */
class SeTeacherMaterialInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_teacherMaterialInfo';
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
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['informationPackID', 'materialType', 'uploadTime'], 'string', 'max' => 20],
            [['infoId'], 'string', 'max' => 30],
            [['url'], 'string', 'max' => 500],
            [['isDelete', 'disabled'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 300],
            [['brief'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'id',
            'informationPackID' => '资料袋id',
            'infoId' => '资料内容id',
            'materialType' => '资料类型 1教案，2讲义，3视频,4 资料，5 ppt，6 素材，7教学计划',
            'url' => '资料url',
            'isDelete' => '是否删除',
            'name' => '名称',
            'brief' => '简介',
            'uploadTime' => '上传时间',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }

    /**
     * @inheritdoc
     * @return SeTeacherMaterialInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTeacherMaterialInfoQuery(get_called_class());
    }
}

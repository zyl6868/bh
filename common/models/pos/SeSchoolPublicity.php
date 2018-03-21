<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "{{%se_schoolPublicity}}".
 *
 * @property integer $publicityId
 * @property integer $schoolID
 * @property integer $publicityType
 * @property string $publicityTitle
 * @property string $publicityContent
 * @property integer $createTime
 * @property integer $updateTime
 * @property integer $userID
 *  * @property integer $userName
 *  * @property integer $imageUrl
 */
class SeSchoolPublicity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_schoolPublicity}}';
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
     * @return SeSchoolPublicityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolPublicityQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schoolID', 'userID'], 'required'],
            [['schoolID', 'publicityType', 'createTime', 'updateTime', 'userID'], 'integer'],
            [['publicityTitle'], 'string', 'max' => 100],
            [['publicityContent'], 'string', 'max' => 1000],
            [['userName'], 'string', 'max' => 50],
            [['imageUrl'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'publicityId' => '公告ID',
            'schoolID' => '学校ID',
            'publicityType' => '公示类型',
            'publicityTitle' => '公示标题',
            'publicityContent' => '公示内容',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'userID' => '创建人',
            'imageUrl' => '图片',
        ];
    }
}

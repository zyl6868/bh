<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_favoriteFolder".
 *
 * @property integer $collectID
 * @property string $headLine
 * @property string $brief
 * @property string $favoriteId
 * @property string $favoriteType
 * @property string $url
 * @property string $creatorID
 * @property string $createTime
 * @property string $isDelete
 * @property string $disabled
 */
class SeFavoriteFolder extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_favoriteFolder';
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
     * @return SeFavoriteFolderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeFavoriteFolderQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['brief'], 'string'],
            [['headLine'], 'string', 'max' => 200],
            [['favoriteId', 'favoriteType'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 800],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collectID' => '收藏id',
            'headLine' => '标题',
            'brief' => '简介',
            'favoriteId' => '收藏内容id',
            'favoriteType' => '收藏类型(1教案，2讲义，3视频,4 资料，5 ppt，6 素材)',
            'url' => 'url',
            'creatorID' => '收藏夹创建人id',
            'createTime' => '创建时间',
            'isDelete' => '是否已删除',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }
}

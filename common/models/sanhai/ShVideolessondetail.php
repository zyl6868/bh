<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_videolessondetail".
 *
 * @property integer $lvid
 * @property string $cnum
 * @property string $cname
 * @property string $videourl
 * @property string $kid
 * @property string $videolessonid
 * @property string $isDelete
 * @property string $ltype
 * @property string $teachMaterialID
 * @property string $isAudition
 */
class ShVideolessondetail extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_videolessondetail';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sanku');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lvid'], 'required'],
            [['lvid'], 'integer'],
            [['cnum', 'cname', 'videolessonid', 'teachMaterialID'], 'string', 'max' => 20],
            [['videourl'], 'string', 'max' => 200],
            [['kid'], 'string', 'max' => 100],
            [['isDelete', 'ltype', 'isAudition'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lvid' => 'Lvid',
            'cnum' => '节号',
            'cname' => ' 节次名',
            'videourl' => '视频url',
            'kid' => '知识点',
            'videolessonid' => '关联sh_videolesson:lid',
            'isDelete' => 'Is Delete',
            'ltype' => '1：知识点讲解，2课本章节',
            'teachMaterialID' => '讲义ID',
            'isAudition' => '是否允许试听，0不允许，1允许',
        ];
    }

    /**
     * @inheritdoc
     * @return ShVideolessondetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShVideolessondetailQuery(get_called_class());
    }
}

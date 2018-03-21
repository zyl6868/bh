<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_dibbleCourse_classFile".
 *
 * @property integer $fileID
 * @property string $hourID
 * @property string $type
 * @property string $materialID
 * @property string $createTime
 * @property string $creatorID
 * @property string $isDelete
 * @property string $disabled
 */
class SeDibbleCourseClassFile extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_dibbleCourse_classFile';
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
            [['fileID'], 'required'],
            [['fileID'], 'integer'],
            [['hourID', 'type', 'materialID', 'createTime', 'creatorID'], 'string', 'max' => 20],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fileID' => 'id',
            'hourID' => '课时id',
            'type' => '资源类型',
            'materialID' => '资源id',
            'createTime' => '信息创建时间',
            'creatorID' => '信息创建人',
            'isDelete' => '是否删除',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }

    /**
     * @inheritdoc
     * @return SeDibbleCourseClassFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeDibbleCourseClassFileQuery(get_called_class());
    }
}

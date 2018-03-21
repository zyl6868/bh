<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_coursePlay_courseFile".
 *
 * @property integer $ID
 * @property string $courseID
 * @property string $type
 * @property string $filesID
 * @property string $createTime
 * @property string $createID
 * @property string $isDelete
 * @property string $disabled
 */
class SeCoursePlayCourseFile extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_coursePlay_courseFile';
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
            [['courseID', 'type', 'filesID', 'createTime', 'createID'], 'string', 'max' => 20],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'id',
            'courseID' => '课程id',
            'type' => '资源类型',
            'filesID' => '资源id',
            'createTime' => '信息创建时间',
            'createID' => '信息创建人',
            'isDelete' => '是否删除',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayCourseFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCoursePlayCourseFileQuery(get_called_class());
    }
}

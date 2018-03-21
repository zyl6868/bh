<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_teachingGroup".
 *
 * @property integer $ID
 * @property string $schoolID
 * @property string $groupName
 * @property string $brief
 * @property string $subjectID
 * @property string $creatorID
 * @property string $createTime
 * @property string $updateTime
 * @property string $isDelete
 * @property string $departmentID
 * @property string $bookVersionID
 * @property string $disabled
 */
class SeTeachingGroup extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_teachingGroup';
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
     * @return SeTeachingGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTeachingGroupQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['brief'], 'string'],
            [['schoolID', 'subjectID', 'creatorID', 'createTime', 'updateTime', 'departmentID', 'bookVersionID'], 'string', 'max' => 20],
            [['groupName'], 'string', 'max' => 200],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '序号ID',
            'schoolID' => '学校id。',
            'groupName' => '教研组名称',
            'brief' => '描述',
            'subjectID' => '科目id',
            'creatorID' => '教研组创建人员',
            'createTime' => '信息创建时间',
            'updateTime' => '最后修改时间',
            'isDelete' => '是否已经删除',
            'departmentID' => '学部',
            'bookVersionID' => '教材版本',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }
}

<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_groupMembers".
 *
 * @property integer $ID
 * @property string $groupID
 * @property string $teacherID
 * @property string $identity
 * @property string $isDelete
 * @property string $identityName
 */
class SeGroupMembers extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_groupMembers';
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
     * @return SeGroupMembersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupMembersQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['groupID', 'teacherID', 'identity'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2],
            [['identityName'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '序号',
            'groupID' => '教研组ID',
            'teacherID' => '教师用户ID',
            'identity' => '教研组职务',
            'isDelete' => '是否删除',
            'identityName' => '教研组职务名称',
        ];
    }
}

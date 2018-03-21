<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "{{%se_groupLecturePlanMember}}".
 *
 * @property integer $ID
 * @property integer $lecturePlanID
 * @property integer $userID
 * @property string $userName
 * @property integer $isDelete
 */
class SeGroupLecturePlanMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_groupLecturePlanMember}}';
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
            [['lecturePlanID', 'userID'], 'required'],
            [['lecturePlanID', 'userID', 'isDelete'], 'integer'],
            [['userName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'id',
            'lecturePlanID' => '听课计划id',
            'userID' => '用户id',
            'userName' => '听课人姓名',
            'isDelete' => '是否删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeGroupLecturePlanMemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupLecturePlanMemberQuery(get_called_class());
    }
}

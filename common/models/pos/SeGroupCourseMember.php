<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "{{%se_groupCourseMember}}".
 *
 * @property integer $ID
 * @property string $teacherID
 * @property string $courseID
 * @property integer $isDelete
 */
class SeGroupCourseMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_groupCourseMember}}';
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
            [['teacherID', 'courseID', 'isDelete'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'id',
            'teacherID' => '教师ID',
            'courseID' => '课题组id',
            'isDelete' => '是否已删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeGroupCourseMemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupCourseMemberQuery(get_called_class());
    }
}

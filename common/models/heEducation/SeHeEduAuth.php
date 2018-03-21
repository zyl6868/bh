<?php

namespace common\models\heEducation;

use common\models\sanhai\SanhaiActiveRecord;
use Yii;
/**
 * This is the model class for table "se_heEduAuth".
 *
 * @property integer $id
 * @property integer $hUserId
 * @property string $name
 * @property integer $role
 * @property integer $classId
 * @property string $className
 * @property integer $schoolId
 * @property string $schoolName
 * @property string $schoolType
 * @property integer $year
 * @property string $subject
 * @property string $city
 * @property integer $userId
 */
class SeHeEduAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_heEduAuth';
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
            [['id', 'hUserId', 'role'], 'required'],
            [['id', 'hUserId', 'role', 'classId', 'schoolId', 'year', 'userId'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['className', 'schoolType'], 'string', 'max' => 20],
            [['schoolName'], 'string', 'max' => 300],
            [['subject', 'city'], 'string', 'max' => 45],
            [['hUserId'], 'unique'],
            [['userId'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hUserId' => '和用户id',
            'name' => '用户名',
            'role' => '身份　１　老师　２　家长',
            'classId' => '班级id',
            'className' => '班级名称',
            'schoolId' => '学校id',
            'schoolName' => '学校名称',
            'schoolType' => '学校类型',
            'year' => '入学年份',
            'subject' => '学科（老师有）',
            'city' => '城市',
            'userId' => '班海用户id',
        ];
    }


    /**
     * @inheritdoc
     * @return SeHeEduAuthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHeEduAuthQuery(get_called_class());
    }


}

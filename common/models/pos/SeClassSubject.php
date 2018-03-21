<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_classSubject".
 *
 * @property integer $ID
 * @property string $classID
 * @property string $subjectNumber
 * @property string $teacherID
 * @property string $teacherName
 * @property string $isDelete
 */
class SeClassSubject extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_classSubject';
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
     * @return SeClassSubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeClassSubjectQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['classID', 'subjectNumber', 'teacherID'], 'string', 'max' => 20],
            [['teacherName'], 'string', 'max' => 50],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '序号ID',
            'classID' => '班级ID',
            'subjectNumber' => '科目编码',
            'teacherID' => '授课老师用户ID',
            'teacherName' => '授课老师姓名',
            'isDelete' => '是否删除',
        ];
    }


}

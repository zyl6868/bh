<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolOwnGrade".
 *
 * @property integer $sGradeID
 * @property string $schoolID
 * @property string $department
 * @property string $joinYear
 * @property string $gradeID
 * @property string $creatorID
 * @property string $createTime
 * @property string $updateTime
 * @property string $isDelete
 */
class SeSchoolOwnGrade extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolOwnGrade';
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
     * @return SeSchoolOwnGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolOwnGradeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sGradeID'], 'required'],
            [['sGradeID'], 'integer'],
            [['schoolID', 'department', 'joinYear', 'gradeID', 'creatorID'], 'string', 'max' => 20],
            [['createTime', 'updateTime'], 'string', 'max' => 100],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sGradeID' => 'S Grade ID',
            'schoolID' => '学校id',
            'department' => '学段，学部',
            'joinYear' => '入学年份',
            'gradeID' => '所在年级',
            'creatorID' => '创建者id',
            'createTime' => '创建时间',
            'updateTime' => '最后一次修改时间',
            'isDelete' => '是否已删除',
        ];
    }
}

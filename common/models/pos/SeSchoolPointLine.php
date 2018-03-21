<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolPointLine".
 *
 * @property integer $pointLineID
 * @property string $schoolID
 * @property string $departmentID
 * @property string $departmentName
 * @property string $year
 * @property string $admissionLine
 * @property string $seclectSchoolLine
 * @property string $residentialLine
 * @property string $creatorID
 * @property string $createTime
 * @property string $isDelete
 */
class SeSchoolPointLine extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolPointLine';
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
     * @return SeSchoolPointLineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolPointLineQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pointLineID'], 'required'],
            [['pointLineID'], 'integer'],
            [['schoolID', 'departmentID', 'year', 'admissionLine', 'seclectSchoolLine', 'residentialLine', 'creatorID', 'createTime'], 'string', 'max' => 20],
            [['departmentName'], 'string', 'max' => 50],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pointLineID' => 'id',
            'schoolID' => '学校id',
            'departmentID' => '学部id',
            'departmentName' => '学部名称',
            'year' => '年份',
            'admissionLine' => '录取分数线',
            'seclectSchoolLine' => '择校分数线',
            'residentialLine' => '住宿分数线',
            'creatorID' => '信息创建人',
            'createTime' => '信息创建时间',
            'isDelete' => '是否已删除',
        ];
    }
}

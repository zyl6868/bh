<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolGrade".
 *
 * @property integer $gradeId
 * @property string $gradeName
 * @property string $sixThree
 * @property string $fiveFour
 * @property string $fiveThree
 * @property string $xFour
 * @property string $xFive
 * @property string $xSix
 * @property string $schoolDepartment
 */
class SeSchoolGrade extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolGrade';
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
     * @return SeSchoolGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolGradeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gradeId'], 'required'],
            [['gradeId'], 'integer'],
            [['gradeName'], 'string', 'max' => 50],
            [['sixThree', 'fiveFour', 'fiveThree'], 'string', 'max' => 2],
            [['xFour', 'xFive', 'xSix'], 'string', 'max' => 3],
            [['schoolDepartment'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gradeId' => '年级id',
            'gradeName' => '年级名称',
            'sixThree' => '六三学制是否存在该年级，0不存在，1：存在',
            'fiveFour' => '五四学制是否存在该年级，0不存在，1：存在',
            'fiveThree' => '五三学制是否存在该年级，0不存在，1：存在',
            'xFour' => '预设该学制，用来判断该学制是否存在该年级',
            'xFive' => '预设该学制，用来判断该学制是否存在该年级',
            'xSix' => '预设该学制，用来判断该学制是否存在该年级',
            'schoolDepartment' => '0：小学部，1:初中部，2：高中部',
        ];
    }
}

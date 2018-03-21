<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_dibbleCourseInfo".
 *
 * @property integer $couresID
 * @property string $gradeID
 * @property string $subjectID
 * @property string $version
 * @property string $courseName
 * @property string $courseBrief
 * @property string $teacherID
 * @property string $teacherName
 * @property string $cost
 * @property string $type
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property string $createTime
 * @property string $creatorID
 * @property string $teacherProportion
 * @property string $schoolProportion
 * @property string $price
 * @property string $isDelete
 * @property string $url
 * @property string $powers
 * @property string $classID
 */
class SeDibbleCourseInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_dibbleCourseInfo';
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
     * @return SeDibbleCourseInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeDibbleCourseInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['couresID'], 'required'],
            [['couresID'], 'integer'],
            [['courseBrief'], 'string'],
            [['gradeID', 'subjectID', 'version', 'teacherID', 'type', 'provience', 'city', 'country', 'createTime', 'creatorID', 'teacherProportion', 'schoolProportion', 'classID'], 'string', 'max' => 20],
            [['courseName', 'teacherName', 'powers'], 'string', 'max' => 50],
            [['cost', 'isDelete'], 'string', 'max' => 2],
            [['price'], 'string', 'max' => 30],
            [['url'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'couresID' => '课程id',
            'gradeID' => '年级id',
            'subjectID' => '科目id',
            'version' => '教材版本',
            'courseName' => '课程名称',
            'courseBrief' => '课程介绍',
            'teacherID' => '授课老师id',
            'teacherName' => '授课老师姓名',
            'cost' => '是否收费',
            'type' => '课程类型，0精品，1每周一课',
            'provience' => '地区：省',
            'city' => '地区：市/地区',
            'country' => '地区：县区',
            'createTime' => '信息创建时间',
            'creatorID' => '信息创建人',
            'teacherProportion' => '分财比例：老师比例',
            'schoolProportion' => '分财比例：学校比例',
            'price' => '销售价格',
            'isDelete' => '是否删除',
            'url' => '视频资源地址',
            'powers' => '权限',
            'classID' => '班级id',
        ];
    }
}

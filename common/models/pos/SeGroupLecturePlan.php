<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "{{%se_groupLecturePlan}}".
 *
 * @property integer $lecturePlanID
 * @property string $title
 * @property integer $teacherID
 * @property string $teacherName
 * @property string $chapters
 * @property string $joinTime
 * @property integer $creatorID
 * @property integer $createTime
 * @property string $Type
 * @property integer $teachingGroupID
 * @property integer $isDelete
 * @property integer $disabled
 */
class SeGroupLecturePlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%se_groupLecturePlan}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    public function getGroupLecturePlanMember()
    {
        return $this->hasMany(SeGroupLecturePlanMember::className(), ['lecturePlanID' => 'lecturePlanID']);
    }

    public function getGroupLecturePlanReport()
    {
        return $this->hasMany(SeGroupLecturePlanReport::className(), ['lecturePlanID' => 'lecturePlanID']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacherID', 'creatorID', 'createTime', 'teachingGroupID', 'isDelete', 'disabled'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['teacherName'], 'string', 'max' => 50],
            [['chapters'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lecturePlanID' => '听课计划id',
            'title' => '标题',
            'teacherID' => '主讲人id',
            'teacherName' => '主讲人姓名',
            'chapters' => '章节',
            'joinTime' => '听课时间',
            'creatorID' => '计划创建人id',
            'createTime' => '计划创建时间',
            'Type' => '计划所属类型',
            'teachingGroupID' => '教研组id',
            'isDelete' => '是否已经删除',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }

    /**
     * @inheritdoc
     * @return SeGroupLecturePlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupLecturePlanQuery(get_called_class());
    }
}

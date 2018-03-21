<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_createTeachingPlan".
 *
 * @property integer $ID
 * @property string $title
 * @property string $teacherID
 * @property string $teacherName
 * @property string $chapters
 * @property string $joinTime
 * @property string $creatorID
 * @property string $createTime
 * @property string $Type
 * @property string $teachingGroupID
 * @property string $isDelete
 * @property string $disabled
 */
class SeCreateTeachingPlan extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_createTeachingPlan';
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
     * @return SeCreateTeachingPlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCreateTeachingPlanQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['teacherID', 'joinTime', 'creatorID', 'createTime', 'Type', 'teachingGroupID', 'disabled'], 'string', 'max' => 20],
            [['teacherName'], 'string', 'max' => 50],
            [['chapters'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '听课计划id',
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
}

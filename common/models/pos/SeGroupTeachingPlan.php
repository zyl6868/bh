<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_groupTeachingPlan".
 *
 * @property integer $ID
 * @property string $planName
 * @property string $gradeID
 * @property string $brief
 * @property string $url
 * @property string $type
 * @property string $creatorID
 * @property string $createTime
 * @property string $teachingGroupID
 * @property string $isDelete
 * @property string $planType
 * @property string $disabled
 */
class SeGroupTeachingPlan extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_groupTeachingPlan';
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
     * @return SeGroupTeachingPlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeGroupTeachingPlanQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['brief'], 'string'],
            [['planName', 'url'], 'string', 'max' => 200],
            [['gradeID', 'type', 'creatorID', 'createTime', 'teachingGroupID', 'planType'], 'string', 'max' => 20],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '序号ID',
            'planName' => '计划名称',
            'gradeID' => '适用年级',
            'brief' => '描述',
            'url' => '教学计划附件URL',
            'type' => '教学计划类型',
            'creatorID' => '计划创建人员id',
            'createTime' => '创建时间',
            'teachingGroupID' => '如果教学计划所属类型是教研组教学计划，存储教研组id，否为该字段值为空。',
            'isDelete' => '是否已经删除',
            'planType' => '教学计划所属类型：',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }
}

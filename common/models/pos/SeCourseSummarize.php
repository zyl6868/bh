<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_courseSummarize".
 *
 * @property integer $summarizeID
 * @property string $classID
 * @property string $summarizeName
 * @property string $beginTime
 * @property string $classAtmosphere
 * @property string $studyPlan
 * @property string $isDelete
 * @property string $createTime
 * @property string $knowledgePoint
 * @property string $subjectID
 * @property string $creatorID
 * @property string $finishTime
 * @property string $disabled
 */
class SeCourseSummarize extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_courseSummarize';
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
     * @return SeCourseSummarizeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCourseSummarizeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['summarizeID'], 'required'],
            [['summarizeID'], 'integer'],
            [['classAtmosphere', 'studyPlan'], 'string'],
            [['classID', 'beginTime', 'createTime', 'subjectID', 'creatorID', 'finishTime'], 'string', 'max' => 20],
            [['summarizeName'], 'string', 'max' => 50],
            [['isDelete', 'disabled'], 'string', 'max' => 2],
            [['knowledgePoint'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'summarizeID' => '课程总结id',
            'classID' => '班级id',
            'summarizeName' => '总评名称',
            'beginTime' => '时间段.开始时间',
            'classAtmosphere' => '班级氛围',
            'studyPlan' => '学习计划',
            'isDelete' => '是否已删除',
            'createTime' => '创建时间',
            'knowledgePoint' => '知识点',
            'subjectID' => '科目ID',
            'creatorID' => '创建人ID',
            'finishTime' => '时间段：结束时间',
            'disabled' => '已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }
}

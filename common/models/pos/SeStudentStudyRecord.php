<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_studentStudyRecord".
 *
 * @property integer $recordID
 * @property string $studentID
 * @property string $recordType
 * @property string $resourceType
 * @property string $resourceID
 * @property string $createTime
 * @property string $isDelete
 * @property string $secondResourceType
 * @property string $appendInfo
 * @property string $remark
 */
class SeStudentStudyRecord extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_studentStudyRecord';
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
            [['recordID'], 'required'],
            [['recordID'], 'integer'],
            [['studentID', 'recordType', 'resourceType', 'resourceID', 'createTime', 'secondResourceType'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2],
            [['appendInfo', 'remark'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recordID' => '记录id',
            'studentID' => '学生id',
            'recordType' => '记录操作类型',
            'resourceType' => '资源类型',
            'resourceID' => '资源id',
            'createTime' => '时间',
            'isDelete' => 'Is Delete',
            'secondResourceType' => '资源子类型',
            'appendInfo' => '附加信息',
            'remark' => '备注',
        ];
    }

    /**
     * @inheritdoc
     * @return SeStudentStudyRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeStudentStudyRecordQuery(get_called_class());
    }
}

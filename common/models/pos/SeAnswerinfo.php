<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_answerinfo".
 *
 * @property integer $id
 * @property string $studentID
 * @property string $submitTime
 * @property string $personalScore
 * @property string $isDelete
 * @property string $isChecked
 * @property string $disabled
 * @property string $examSubID
 * @property string $personalEvaluate
 * @property string $cmemID
 */
class SeAnswerinfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_answerinfo';
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
     * @return SeAnswerinfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeAnswerinfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['studentID', 'submitTime', 'examSubID'], 'string', 'max' => 30],
            [['personalScore', 'isDelete', 'isChecked'], 'string', 'max' => 50],
            [['disabled'], 'string', 'max' => 2],
            [['personalEvaluate'], 'string', 'max' => 500],
            [['cmemID'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'studentID' => '学生ID',
            'submitTime' => '提交时间',
            'personalScore' => '学生科目分数',
            'isDelete' => '是否删除0：否1：是默认0',
            'isChecked' => '是否已经批阅 0：未批阅  1：已批阅',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'examSubID' => '考试科目id',
            'personalEvaluate' => '科目个人评价',
            'cmemID' => 'se_classMembers中的id',
        ];
    }
}

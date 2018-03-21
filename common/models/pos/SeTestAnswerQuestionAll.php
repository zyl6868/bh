<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_testAnswerQuestionAll".
 *
 * @property string $mainID
 * @property string $questionID
 * @property string $answerOption
 * @property string $answerTime
 * @property string $isDelete
 * @property string $testAnswerID
 * @property integer $aID
 * @property string $answerRight
 * @property string $ischecked
 * @property string $studentID
 * @property string $examSubID
 * @property string $testID
 */
class SeTestAnswerQuestionAll extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_testAnswerQuestionAll';
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
            [['aID'], 'required'],
            [['aID'], 'integer'],
            [['mainID', 'questionID', 'answerTime', 'testAnswerID'], 'string', 'max' => 20],
            [['answerOption'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 2],
            [['answerRight', 'ischecked', 'studentID', 'examSubID', 'testID'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mainID' => '关联大题作答·表',
            'questionID' => '题目id',
            'answerOption' => '选择题答案',
            'answerTime' => 'Answer Time',
            'isDelete' => 'Is Delete',
            'testAnswerID' => '作业答案id',
            'aID' => 'A ID',
            'answerRight' => '0错误，1正确，2未批改',
            'ischecked' => 'Ischecked',
            'studentID' => 'Student ID',
            'examSubID' => 'Exam Sub ID',
            'testID' => 'Test ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionAllQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTestAnswerQuestionAllQuery(get_called_class());
    }
}

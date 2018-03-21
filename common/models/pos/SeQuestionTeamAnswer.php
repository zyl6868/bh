<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionTeamAnswer".
 *
 * @property string $id
 * @property string $notesID
 * @property string $questionTeamID
 * @property string $questionID
 * @property string $studentID
 * @property string $answerOption
 * @property string $answerText
 * @property string $isright
 * @property string $answerCount
 * @property string $answerTime
 */
class SeQuestionTeamAnswer extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionTeamAnswer';
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
     * @return SeQuestionTeamAnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionTeamAnswerQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['answerText'], 'string'],
            [['id', 'notesID', 'questionTeamID', 'questionID', 'studentID', 'isright', 'answerCount', 'answerTime'], 'string', 'max' => 20],
            [['answerOption'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notesID' => 'Notes ID',
            'questionTeamID' => 'Question Team ID',
            'questionID' => 'Question ID',
            'studentID' => 'Student ID',
            'answerOption' => '选择题答案 多选题逗号隔开',
            'answerText' => '其他题目答案',
            'isright' => '是否正确 0错误 1正确',
            'answerCount' => '题目组答题次数',
            'answerTime' => '答题时间',
        ];
    }
}

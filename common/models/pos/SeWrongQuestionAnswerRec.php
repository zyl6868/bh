<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_wrongQuestionAnswerRec".
 *
 * @property integer $id
 * @property string $questionId
 * @property string $answerTime
 * @property string $wrongId
 * @property integer $recSeq
 * @property string $score
 * @property string $checkUser
 * @property string $checkTime
 * @property string $answerRight
 */
class SeWrongQuestionAnswerRec extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestionAnswerRec';
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
            [['id'], 'required'],
            [['id', 'recSeq'], 'integer'],
            [['questionId'], 'string', 'max' => 60],
            [['answerTime', 'wrongId', 'score', 'checkUser', 'checkTime', 'answerRight'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'questionId' => '题目id',
            'answerTime' => '答题时间',
            'wrongId' => '关联错题id',
            'recSeq' => '答题次数',
            'score' => '分数',
            'checkUser' => '批改人',
            'checkTime' => 'Check Time',
            'answerRight' => '答案是否正确 0错误 1正确',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionAnswerRecQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionAnswerRecQuery(get_called_class());
    }
}

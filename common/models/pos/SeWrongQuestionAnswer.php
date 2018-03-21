<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_wrongQuestionAnswer".
 *
 * @property integer $id
 * @property string $questionId
 * @property string $answerOption
 * @property string $answerUrl
 * @property string $answerRight
 * @property string $answerTime
 * @property string $isDelete
 * @property string $wrongId
 * @property string $isChecked
 * @property integer $recId
 * @property integer $recSeq
 */
class SeWrongQuestionAnswer extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestionAnswer';
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
            [['id', 'recId', 'recSeq'], 'integer'],
            [['questionId'], 'string', 'max' => 60],
            [['answerOption', 'answerRight', 'answerTime', 'isDelete', 'wrongId'], 'string', 'max' => 20],
            [['answerUrl'], 'string', 'max' => 300],
            [['isChecked'], 'string', 'max' => 10]
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
            'answerOption' => '选择答案',
            'answerUrl' => '题目答案',
            'answerRight' => '答案是否正确 0错误 1正确',
            'answerTime' => '答题时间',
            'isDelete' => '删除状态',
            'wrongId' => '关联错题id',
            'isChecked' => '是否批改',
            'recId' => '答题记录id',
            'recSeq' => 'Rec Seq',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionAnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionAnswerQuery(get_called_class());
    }
}

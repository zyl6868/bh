<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkAnswerDetailAll".
 *
 * @property integer $aid
 * @property string $mainID
 * @property string $questionID
 * @property string $answerOption
 * @property string $answerTime
 * @property string $isDelete
 */
class SeHomeworkAnswerDetailAll extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerDetailAll';
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
            [['aid'], 'required'],
            [['aid'], 'integer'],
            [['mainID', 'questionID', 'answerTime'], 'string', 'max' => 20],
            [['answerOption'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'Aid',
            'mainID' => '关联大题作答·表',
            'questionID' => '题目id',
            'answerOption' => '选择题答案',
            'answerTime' => 'Answer Time',
            'isDelete' => 'Is Delete',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailAllQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerDetailAllQuery(get_called_class());
    }
}
